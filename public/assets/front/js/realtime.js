"use strict";
$(document).ready(function () {
    // LIve Order Notification
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher(pusherAppKey, {
        cluster: pusherCluster
    });

    var channel = pusher.subscribe('order-placed-channel');
    channel.bind('order-placed-event', function (data) {
        if ($("#refreshOrder").length > 0) {
            $(".request-loader").addClass("show");
            $("#refreshOrder").load(location.href + " #refreshOrder", function () {
                $(".request-loader").removeClass("show");
            });
        }

        audio.play();

        // show notification
        let content = {};

        content.message = 'New Order Received!';
        content.title = 'Success';
        content.icon = 'fa fa-bell';

        $.notify(content, {
            type: 'success',
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            time: 1000,
            delay: 2000,
        });
    });

});
