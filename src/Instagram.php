<?php

namespace Thoughtco\InstagramInstantTokens;

use Exception;
use Illuminate\Support\Facades\Storage;
use Statamic\Facades\GlobalSet;

class Instagram 
{
    public function renewToken()
    {
        $tokenPath = config('statamic.instagram.token.storage_file');
                                        
        if (Storage::exists($tokenPath)) {
            
            try {
                
                $token = json_decode(Storage::get($tokenPath), true);

                if ($token['expires_in'] < time()) {
        			$instagramToken = $this->getInstantToken();
                }
                
            } catch (Exception $exception) {

            }
            
        } else {
            
        	$instagramToken = $this->getInstantToken();
            
        }
        
        if (isset($instagramToken) && isset($instagramToken->Token)) {
            
            $token = [
                'access_token' => $instagramToken->Token,  
                'expires_in' => strtotime('+4 hours'),
                'last_update' => time(),
            ];
            
            Storage::put($tokenPath, json_encode($token));
        }
    }
    
    private function getInstantToken()
    {
        $instantTokenUrl = env('INSTANT_TOKEN_URL', false);      
        
        if (! $instantTokenUrl)
            return;
        
        $contents = file_get_contents($instantTokenUrl);
        
        if (!$contents)
            return;
            
        return json_decode($contents);
    }
}