<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_model extends Model
{
    protected $table = 'tbl_user';

    protected $primaryKey = 'user_id';
    
    protected $guarded = [];
    
    public static function android_send_push_notification($device_token, $message, $badge) {

        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
        $id = $device_token;
        
        $data = array(
            'message' => $message,
            'total_notification' => $badge
        );

        $fields = array(
            'registration_ids' => $id,
            'data' => $data
        );
        $ANDROID_KEY = "";
        $headers = array(
            'Authorization: key='.$ANDROID_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    } 
    
    public static function ios_send_push_notification($device_token, $message, $badge) {
        
        if($device_token == null || $device_token =="no_token_get" || $device_token == ""){
            return true; 
        }
        
        $total_badge = intval(@$badge);
        
        $sound = 'default';
        $payload = array();
        
        $payload['aps'] = array(

            'alert' => array('title' => 'Food Culture App','body' => $message), 
            'badge' => $total_badge,
            'sound' => $sound,
            'content-available' => 1,
            'message' => array('message' => $message)
        );
        
        
        $payload = json_encode($payload);

        $apns_url = NULL;
        $apns_cert = NULL;
        $apns_port = 2195;
        $development = true;
        if ($development) {
            $apns_cert = $_SERVER["DOCUMENT_ROOT"].'/FoodCulture/public/pem/file.pem';
        } else {
            $apns_cert = $_SERVER["DOCUMENT_ROOT"].'/FoodCulture/public/pem/file.pem';
        }
       
        $stream_context = stream_context_create();
        stream_context_set_option($stream_context, 'ssl', 'local_cert', $apns_cert);
        
        
        if ($development) {
            $apns_url = 'gateway.sandbox.push.apple.com';
        } else {
            $apns_url = 'gateway.push.apple.com';
        }
        
        $apns = stream_socket_client('ssl://' . $apns_url . ':' . $apns_port, $error, $error_string, 2, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $stream_context);

        if(! $apns){
            $return_array['message'] = "Failed to connect: $error $error_string" . PHP_EOL;
        }
         
        $apns_message = chr(0) . pack('n',32) . pack('H*',$device_token) . pack('n',strlen($payload)) . $payload;
       
        $res = fwrite($apns, $apns_message,strlen($apns_message));

        
        @fclose($apns);
        
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    
    
    
}
