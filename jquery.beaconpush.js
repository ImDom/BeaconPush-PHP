jQuery.extend({
    BeaconPush: {
        addEventListener: function(event, handler) {
            Beacon.listen(function(data) {
                if(data.name == event) {
                    return handler(data);
                }
            });
        }
    }
});


/* ########## Usage #############
* ### PHP
* $beaconpush->send_to_channel("theBestChannel", "chat-message", array("message" => "Hello! This is my message"));
*
* ### JavaScript
* $.BeaconPush.addEventListener("chat-message", function(e) {
*   console.log(e);
* });
*/