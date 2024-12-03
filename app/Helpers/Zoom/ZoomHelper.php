<?php

namespace App\Helpers\Zoom;

use Illuminate\Support\Facades\Http;


class ZoomHelper
{
    public static function getZoomAccessToken()
    {
       
        $clientId = env('ZOOM_CLIENT_KEY');  
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $accountId = env('ZOOM_ACCOUNT_ID');
      
 

     
 
        $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$accountId";

      
        $auth = base64_encode("$clientId:$clientSecret");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic $auth",
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        if ($httpCode !== 200) {
            echo 'Error: Received HTTP code ' . $httpCode . ' from Zoom API';
            echo 'Response: ' . $response;
            curl_close($ch);
            return null;
        }
        curl_close($ch);
        $data = json_decode($response, true);
        return $data['access_token'] ?? null;
    }

    public static function createMeeting($request)
    {
        $accessToken = self::getZoomAccessToken();
       

        if (!$accessToken) {
            throw new \Exception("Unable to retrieve access token");
        }
        $meetingData = [
            'topic' => $request->topic[0],
            'duration' => $request->duration[0] ?? null,
            'password' => 'wael',
            'start_time' => $request->start_time[0],
            'timezone' => 'Africa/Cairo',
            'settings' => [
                'join_before_host' => false,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => true,
                'waiting_room' => true,
                'approval_type' => config('zoom.approval_type'),
                'audio' => config('zoom.audio'),
                'auto_recording' => config('zoom.auto_recording')
            ]
        ];
        $response = Http::withToken($accessToken)
            ->post('https://api.zoom.us/v2/users/me/meetings', $meetingData);

        if ($response->failed()) {
            throw new \Exception("Failed to create Zoom meeting: " . $response->body());
        }
        $meetingDetails = $response->json();
        return [
            'meeting_id' => $meetingDetails['id'],
            'start_url' => $meetingDetails['start_url'],
            'join_url' => $meetingDetails['join_url'],
            'meeting' => $meetingDetails
        ];
    }
}
