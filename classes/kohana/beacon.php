<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Beacon {




    public static function factory()
    {
        return new Kohana_Beacon();
    }

    protected function send_request($method, $command, $arg=NULL, array $data=array())
    {
        $request_url = 'http://'.Kohana::config('beacon.api_host').'/'.Kohana::config('beacon.api_version').'/'.Kohana::config('beacon.api_key');
        $request_url = $request_url.'/'.strtolower($command).($arg ? '/'.$arg : '');

        $options = array(
            'http' => array(
                'method' => $method,
                'header' => "Content-type: application/x-www-form-urlencoded\r\n".
                            "X-Beacon-Secret-Key: ".Kohana::config('beacon.secret_key')."\r\n",
                'content' => json_encode($data),
            ),
        );

        $context = stream_context_create($options);
        $response = @file_get_contents($request_url, FALSE, $context);
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
        return isset($response->{'online'}) ? TRUE : FALSE;
    }

    public function send_message_to_user($user, $msg)
    {
        $response = $this->send_request('POST', 'users', $user, array('message' => $msg));
        return isset($response->{'messages_sent'}) ? TRUE : FALSE;
    }

    public function send_message_to_channel($channel, $msg)
    {
        $response = $this->send_request('POST', 'channels', $channel, array('message' => $msg));
        return isset($response->{'messages_sent'}) ? $response->{'messages_sent'} : FALSE;
    }

    public function force_user_logout($user)
    {
        $this->send_request('DELETE', 'users', $user);
        return TRUE;
    }



}