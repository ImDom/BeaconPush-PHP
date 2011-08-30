How to get started
==================
Create an account at http://www.beaconpush.com if you don't already have 
one and find your API key and Secret key (go to your account page).

Put your API key and Secret key on row 6 and 7 in classes/beaconpush.php


How to use it
=============
Simply include the file beaconpush.php in your site and it should be pretty straight forward from there.

	require('classes/beaconpush.php');
	$beaconpush = new BeaconPush();
	
	// Add user to the channel "theBestChannel"
	$beaconpush >add_channel('theBestChannel');
	
	// Send an event (+data) to all users in the channel "theBestChannel"
	$beaconpush >send_to_channel('theBestChannel', 'newMessage', array('message' => 'Hello world!'));

In your html file, include the following line before your closing body tag

	<?php print $beaconpush >embed(); ?>

and after that, it should look something like this

	<html>
		<head>
			<title>MyBestSite</title>
		</head>

		<body>
			<h1>Welcome!</h1>
			<p>Welcome to my best website!</p>

			<?php print $beaconpush >embed(); ?>
		</body>
	</html>

That's pretty much all you need to get started with BeaconPush-PHP!


Documentation
=============
*I'll add better "example returns" later. For the moment, use print_r() to see exactly the results you get back.*

embed
-----
string **embed** ( [ array *$options* = *array()* ] )

* Returns a string with HTML used for including the file client.js from [beaconpush.com](http://www.beaconpush.com "Beaconpush"). Channels and options are returned by this also.

* **Options**
* See [beaconpush.com](http://beaconpush.com/guide/embedding-the-client/ "Beaconpush") for info on what the options do. Look under *JavaScript API* -> *options*
* Available options is: *bool* **log** and *string* **user**

#### Example #1:

	$beaconpush->add_channel('theBestChannel');
	$beaconpush->embed(array('log' => TRUE, 'user' => 'myCustomIdForUser'));

#### Example #1 returns:

	<script type="text/javascript" src="http://beaconpush.com/1/client.js"></script>
	
	<script type="text/javascript">
		Beacon.connect("5a30a673", ['theBestChannel'], {log: true, user: 'myCustomIdForUser'});
	</script>

#### Example #2:

	$beaconpush->add_channel('theBestChannel');
	$beaconpush->embed();

#### Example #2 returns:

	<script type="text/javascript" src="http://beaconpush.com/1/client.js"></script>
	
	<script type="text/javascript">
		Beacon.connect("5a30a673", ['theBestChannel']);
	</script>

add_channel
-----------
void **add_channel** ( string *$channel* )

* Add the connected user to a channel.

#### Example #1:

	$beaconpush->add_channel('theBestChannel');

add_channels
------------
void **add_channels** ( array *$channels* )

* Add the connected user to multiple channels.

#### Example #1:

	$beaconpush->add_channels( array('theBestChannel', 'foo') );

send_to_channel
---------------
array **send_to_channel** ( string *$channel*, string *$event* [, array *$data* = *array()* ] )

* Sends an event to all users in a channel. The data sent can then be used on the client-side (JavaScript) to do something usefull (like displaying a message).

#### Example #1:

	$beaconpush->send_to_channel('theBestChannel', 'newMessage', array('message' => 'Hello everyone!'));

#### Example #1 returns:
* We get back an array with data that Beaconpush.com returned

send_to_channels
----------------
array **send_to_channels** ( array *$channels*, string *$event* [, array *$data* = *array()* ] )

* Send an event to all users in multiple channels. Does the exact some thing as `send_to_channel` but sends the event to multiple channels instead of one.

#### Example #1:

	$beaconpush->send_to_channels(array('theBestChannel', 'foo'), 'newMessage', array('message' => 'Hello everyone!'));

#### Example #1 returns:
* We get back an array containing arrays for each channel we sent the event to with data that Beaconpush.com returned (for each channel)

send_to_user
------------
array **send_to_user** ( string *$user*, string *$event* [, array *$data* = *array()* ] )

* Sends an event to a user. The data sent can then be used on the client-side (JavaScript) to do something usefull (like displaying a message).

#### Example #1:

	$beaconpush->send_to_user('theBestUser', 'newMessage', array('message' => 'Hello everyone!'));

#### Example #1 returns:
* We get back an array with data that Beaconpush.com returned.

send_to_users
-------------
array **send_to_users** ( array *$users*, string *$event* [, array *$data* = *array()* ] )

* Send an event to multiple users. Does the exact some thing as `send_to_user` but sends the event to multiple users instead of one.

#### Example #1:

	$beaconpush->send_to_users(array('theBestUser', 'bar'), 'newMessage', array('message' => 'Hello everyone!'));

#### Example #1 returns:
* We get back an array containing arrays for each channel we sent the event to with data that Beaconpush.com returned (for each channel)

is_user_online
--------------
bool **send_to_users** ( string *$user* )

* Checks if a user is online and connected to Beaconpush.

#### Example #1:

	$beaconpush->is_user_online('theBestUser');

#### Example #1 returns:
* Returns TRUE if the user is online, else FALSE

get_users_in_channel
--------------------
array **get_users_in_channel** ( string *$channel* )

* Get an array of users currently in a channel.

#### Example #1:

	$beaconpush->get_users_in_channel('foo');

#### Example #1 returns:
* Returns an array of users.

get_users_in_channels
---------------------
array **get_users_in_channels** ( array *$channels* )

* Get an array of all users found in multiple channels.

#### Example #1:

	$beaconpush->get_users_in_channels(array('theBestChannel', 'foo'));

#### Example #1 returns:
* Returns an array of users.

count_users_online
------------------
string **count_users_online** (  )

* Get the number of users online (in all channels).

#### Example #1:

	$beaconpush->count_users_online();

#### Example #1 returns:
* Returns the number of users online

force_user_logout
-----------------
array **force_user_logout** ( string *$user* )

* Forces the logout of a user

#### Example #1:

	$beaconpush->force_user_logout('theWorstUser');

#### Example #1 returns:
* WARNING: The return value for this function is not fully done. Currently it returns the response body Beaconpush gave us, but Beaconpush doesn't give us a response body for **force_user_logout**, only a result code. You can still use this function.