<?php

namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
class Helper
{
    
    // Base URL
    protected static $apiUrl = 'https://fcm.googleapis.com/v1/projects/legible/messages:send';

    // Get Access Token
    public static function getAccessToken()
    {
        $keyFile = storage_path('app/googleConfigFile.json');
        $key = json_decode(file_get_contents($keyFile), true);

        $jwtHeader = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $jwtPayload = json_encode([
            'iss' => $key['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => time() + 3600,
            'iat' => time(),
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jwtHeader));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jwtPayload));
        $signature = '';
        openssl_sign("$base64UrlHeader.$base64UrlPayload", $signature, $key['private_key'], OPENSSL_ALGO_SHA256);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

        // Get the access token
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $response->json()['access_token'];
    }

    // send Push  
    public static function push_notification($push_arr)
    {
        $accessToken = self::getAccessToken();
        $registrationIDs = array_filter((array) ($push_arr['device_token'] ?? [])); // Filter out null/empty tokens
    
        // Check if there are valid device tokens
        if (empty($registrationIDs)) {
            Log::debug('No valid device token found, skipping notification.');
    
            return [
                'success' => false,
                'message' => 'No valid device token provided, notification not sent.',
            ];
        }
    
        $message = [
            'notification' => [
                'title' => $push_arr['title'] ?? 'No title',  
                'body' => $push_arr['description'] ?? 'No description',
            ],
            'data' => [
                'notification_type' => (string) ($push_arr['type'] ?? ''),
                'full_name' => (string) ($push_arr['full_name'] ?? ''),
                'receiver_id' => (string) ($push_arr['receiver_id'] ?? ''),
                'date' => now()->toString(),
                'vibrate' => '1',
                'sound' => '1',    
            ],
        ];
    
        $fields = [
            'message' => [
                'token' => $registrationIDs[0], 
                'notification' => $message['notification'],
                'data' => $message['data'],
            ],
        ];
    
        // Send the notification
        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post(self::$apiUrl, $fields);
    
        // Log the response for debugging
        Log::debug('push_notification');
        Log::debug(json_encode($response->json()));
    
        return $response->json();
    }

    public static function in_app_notification($data)
    {
        $notification = new Notification();
        $notification->sender_id = $data['sender_id']  ?? null;
        $notification->receiver_id = $data['receiver_id'] ?? null;
        $notification->title = $data['title'] ?? null;
        $notification->description = $data['description'] ?? null;
        $notification->record_id = $data['record_id'] ?? null;
        $notification->type = $data['type'] ?? null;
        $notification->save();

        Log::debug('in_app_notification');
        Log::debug(json_encode($notification));
    }
}