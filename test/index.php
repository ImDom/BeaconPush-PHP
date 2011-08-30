<html>
<head><title>BeaconPush-PHP Test</title></head>
<body>

<h1>BeaconPush-PHP Test</h1>

<?php
require("../classes/beaconpush.php");
$bp = new BeaconPush();

echo $bp->embed(array( "user" => "BeaconPushPhpTest", "log" => TRUE ));
?>

</body>
</html>
