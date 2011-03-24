jQuery.extend({

    BeaconPush: {
        addEventListener: function(event, handler) {
            Beacon.listen(function(data) {
                if(data.name == event) {
                    return handler(data);
                }
            });
        },

        // Ignore these if you dont know how to use jQuery Tmpl
        append: function(list, tmpl, event) {
            $(tmpl).tmpl(event.data).appendTo(list);
        },

        prepend: function(list, tmpl, event) {
            $(tmpl).tmpl(event.data).prependTo(list);
        }
    }

});


/* ########## Usage #############
* ### PHP
* $beaconpush->send_to_channels(array('theBestChannel', 'foo'), 'newMessage', array('myMessage' => 'Hello everyone!'));
*
* ### JavaScript
* $.BeaconPush('newMessage', function(event) {
*     console.log('The message: ' + event.data.myMessage);
*     console.log('The event: ' + event.name);
* });
*/