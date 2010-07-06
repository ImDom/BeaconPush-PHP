<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package   Beacon
 * @category  Base
 * @author    Dominik Rask
 * @copyright (c) 2010 Dominik Rask
 * @license   MIT
 */
class Kohana_Beacon {



    
    /**
     * Send the request
     */
    protected static function _request($method, $command, $arg=NULL, array $data=array())
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

    /**
     * Get an array of users online in a channel
     *
     *      $users = Beacon::get_get_users_in_channel($channel);
     *
     * @param string  $channel   The channel to get online users from
     * @return array             Users online in the channel defined
     */
    public static function get_users_in_channel($channel)
    {
        $response = Beacon::_request('GET', 'channels', $channel);
        return $response->{'users'};
    }

    /**
     * Get the total amount of users online in all channels
     *
     *      $users_online = Beacon::get_total_users_online();
     *
     * @return int  Total number of users online
     */
    public static function get_total_users_online()
    {
        $response = Beacon::_request('GET', 'users');
        return $response->{'online'};
    }

    /**
     * Check to see if a user is online or offline
     *
     *      if( Beacon::user_online($user) )
     *          print 'User is online';
     *      else
     *          print 'User is offline';
     *
     * @param string $user  The user to check
     * @return bool         Returns TRUE if user is online and FALSE if the user is offline
     */
    public static function user_online($user)
    {
        $response = Beacon::_request('GET', 'users', $user);
        return isset($response->{'online'}) ? TRUE : FALSE;
    }

    /**
     * Send a message to a specific user
     *
     *      if( Beacon::send_message_to_user($user, $message) )
     *          print 'Message was sent successfully';
     *      else
     *          print 'Something went wrong';
     *
     * @param string $user  The user to the message to
     * @param string $msg   The message
     * @param array  $data  Extra data
     * @return bool         TRUE if sent successfully, otherwise FALSE
     */
    public static function send_message_to_user($user, $msg, array $data=array())
    {
        $response = Beacon::_request('POST', 'users', $user, array_merge(array('message' => $msg), $data));
        return isset($response->{'messages_sent'}) ? TRUE : FALSE;
    }

    /**
     * Send a message to all users in a specific channel
     *
     *      $messages_sent = Beacon::send_message_to_channel($channel, $message);
     *
     *      if( $messages_sent !== FALSE )
     *          print 'Messages sent: '.$messages_sent;
     *      else
     *          print 'Something went wrong';
     *
     * @param string    $channel   The channel to send the message to
     * @param string    $msg       The message
     * @param array     $data      Extra data
     * @return int/bool            Returns number of messages sent. On failure it returns FALSE.
     * @WARNING Make sure to use "$messages_sent === FALSE" or "$messages_sent !== FALSE" to check for failure, this function returns 0 (zero) if there wasn't any users online to receive the message.
     */
    public static function send_message_to_channel($channel, $msg, array $data=array())
    {
        $response = Beacon::_request('POST', 'channels', $channel, array_merge(array('message' => $msg), $data));
        return isset($response->{'messages_sent'}) ? $response->{'messages_sent'} : FALSE;
    }

    /**
     * Log out a user
     *
     *      Beacon::force_user_logout($user);
     *
     * @param string $user  The user to force logout on
     * @return void
     */
    public static function force_user_logout($user)
    {
        Beacon::_request('DELETE', 'users', $user);
    }



}