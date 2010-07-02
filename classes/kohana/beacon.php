<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Beacon {




    public static function factory()
    {
        return new Kohana_Beacon();
    }

    protected function send_request($method, $command, $arg=NULL, $content=array())
    {
        $request_url = 'http://'.Kohana::config('beacon.api_host').'/'.Kohana::config('beacon.api_version').'/'.Kohana::config('beacon.api_key');
        $request_url = $request_url.'/'.strtolower($command).($arg ? '/'.$arg : '');

        $headers[] = 'X-Beacon-Secret-Key: '.Kohana::config('beacon.secret_key')."\r\n";
        $headers[] = 'content: '.json_encode($content);


        $ch = curl_init($request_url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    public function get_users_in_channel($channel)
    {
        $response = $this->send_request('GET', 'channels', $channel);
        return $response->{'users'};
    }

    public function get_total_users_online()
    {
        $response = $this->send_request('GET', 'users');
        return $response->{'online'};
    }

    public function user_online($user)
    {
        $response = $this->send_request('GET', 'users', $user);
        return $response->{'status'} == '200' ? TRUE : FALSE;
    }

    public function send_message_to_user($user, $msg)
    {
        $response = $this->send_request('POST', 'users', $user, array('message' => $msg));
        return $response;
    }

    public function send_message_to_channel($channel, $msg)
    {
        $response = $this->send_request('POST', 'channels', $channel, array('message' => $msg));
        return $response;
    }

    public function user_force_logout($user)
    {
        $this->send_request('DELETE', 'users', $user);
        return TRUE;
    }



}