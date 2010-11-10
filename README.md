How to get started
==================
Create an account at http://www.beaconpush.com if you don't already have 
one and find your API key and Secret key (go to your account page).

Apply you API key and Secret key on row 6 and 7 in classes/beaconpush.php


How to use it
=============
Simply include the file beaconpush in your site and it should be pretty straight forward from there.

	require('classes/beaconpush.php');
	$beaconpush = new BeaconPush();
	
	// Add user to the channel "theBestChannel"
	$beaconpush >add_channel('theBestChannel');
	
	// Send an event (+data) to all users in the channel "theBestChannel"
	$beaconpush >send_to_channel('theBestChannel', 'newMessage', array('message' => 'Hello world!'));

and in your "base" html file, include following before your closing body tag

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

And that's pretty much all you need to get started with BeaconPush-PHP!


Documentation
=============

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

* Send an event to all users in multiple channels. Does the exact some thing as `send_to_channel` but send the event to multiple channels instead.

#### Example #1:

	$beaconpush->send_to_channel(array('theBestChannel', 'foo'), 'newMessage', array('message' => 'Hello everyone!'));

#### Example #1 returns:
* We get back an array with arrays for each channel we sent the event to with data that Beaconpush.com returned (for each channel)