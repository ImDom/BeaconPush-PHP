jQuery.extend({

    BeaconPush: {
        addEventListener: function(event, handler) {
            Beacon.listen(function(data) {
                if(data.name == event) {
                    return handler(data);
                }
            });
        },

        append: function(list, tmpl, event) {
            $(tmpl).tmpl(event.data).appendTo(list);
        },

        prepend: function(list, tmpl, event) {
            $(tmpl).tmpl(event.data).prependTo(list);
        }
    }

});