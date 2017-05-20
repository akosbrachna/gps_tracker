<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
#map_canvas_users{
    position: absolute;
    top: 0px;
    left: 0px;
    margin: 0px !important;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
#map_canvas_users .gm-style img{
    max-width: none !important;
}
</style>

<div id="map_canvas_users">
    <div style="position: absolute;top:50%;left:50%; margin-left: -300px;">
        <h2>Please wait, map info is loading...</h2>
    </div>
</div>

<script>
//$("#map_canvas_users").height($(window).height());
// GOOGLE MAP API V3 !!!

function draw_map(latitude, longitude)
{
    if (first_loaded)
    {
        map = new google.maps.Map(document.getElementById("map_canvas_users"), 
                            { center:new google.maps.LatLng(latitude, longitude),//53.4175, -7.90663),
                              zoom: 7,
                              mapTypeId: google.maps.MapTypeId.ROADMAP });
        first_loaded = false;
        return;
    }
}

var first_loaded = true;

var color_chooser = {
    matrix: [[0, 0, 128],
            [0, 128, 0],
            [128, 0, 0],
            [0, 128, 128],
            [128, 0, 128],
            [128, 128, 0],
            [128, 128, 128]],
    color_index: 0
};
var users = {}; // object for users that contain markers, routes, checkbox for each user separately

function show_users_on_map(data)
{
    for (var i in data)
    {
        create_user(data[i]);
        create_marker(data[i]);
        draw_route(data[i]);
    }
}

function create_user(value)
{
    draw_map(value.latitude, value.longitude);
    if (users[value.id]) return;
   //create new user in users array if not exists and initialize with markers array and color.
    users[value.id] = {};
    users[value.id].id = value.id;
    users[value.id].markers = Array();
    var color_index = color_chooser.color_index;
    var colors = color_chooser.matrix;
    var factor = Math.floor(color_index/7+1);
    users[value.id].color = 'rgb('+colors[color_index%7][0]/factor+','
                                  +colors[color_index%7][1]/factor+','
                                  +colors[color_index%7][2]/factor+')';
    color_chooser.color_index++;
    users[value.id].visible = true;    // user is visible initially
    users[value.id].name = value.first_name+' '+value.last_name;
    users[value.id].phone_number = value.phone_number;
    users[value.id].email = value.email;
}

function create_marker(value)
{
    var user = users[value.id];
    var markers = user.markers;
    var i = markers.length;
    var latlng = new google.maps.LatLng(value.latitude, value.longitude);
    if (i > 0)
    {
        var prev_marker = markers[i-1];
        if (prev_marker.position.equals(latlng))
            return;
        prev_marker.infowindow.close();
    }

    // create new marker at the end of markers array
    var curr_marker = markers[i] = new google.maps.Marker({
        icon:{
            path: google.maps.SymbolPath.CIRCLE,
            fillColor: user.color,
            strokeOpacity: 1.0,
            strokeColor: user.color,
            strokeWeight: 3.0, 
            scale: 2,
        },
        position: latlng,
        map: map,
    });
    curr_marker.setVisible(user.visible);
    var div = document.createElement("div");
    var text_name = document.createElement("div");
    text_name.innerHTML = user.name+"<br />"+value.gps_update_time;
    div.appendChild(text_name);
    var pic = document.createElement("img");
    pic.style.position = "absolute";
    pic.style.right = '0px';
    pic.style.top = '0px';
    pic.src = "<?php echo base_url('web/pics/users'); ?>/"+user.email+".jpg";
    pic.style.height = "40px";
    pic.onload = function(){
        div.appendChild(pic);
    }
    curr_marker.infowindow = new google.maps.InfoWindow(
        {
            content: div,
            position: latlng
        });
    if (user.visible) curr_marker.infowindow.open(map, curr_marker);
    
    google.maps.event.addListener(curr_marker, 'click', function() {
                if (curr_marker.infowindow.getMap()) 
                     curr_marker.infowindow.close();
                else curr_marker.infowindow.open(map, curr_marker);
    });
}
// handle the directions service
function draw_route(value)
{
    var user = users[value.id];
    var markers = user.markers;
    var i = markers.length - 1;
    if (i <= 0) return;
    var curr_marker = markers[i];
    if (curr_marker.directionsDisplay) return;
    var prev_marker = markers[i-1];
    
    curr_marker.directionsService = new google.maps.DirectionsService();
    curr_marker.directionsDisplay = new google.maps.DirectionsRenderer({
                                    suppressMarkers: true,
                                    preserveViewport: true,
                                    polylineOptions: {
                                        strokeColor: user.color
                                    }
                                });
    curr_marker.directionsService.route
    (
        {
            origin: prev_marker.position,
            destination: curr_marker.position,
            travelMode: google.maps.TravelMode.DRIVING
        }, 
        function(result, status) 
        {
            if (status == google.maps.DirectionsStatus.OK) 
            {
              curr_marker.directionsDisplay.setDirections(result);
              if (user.visible)
                curr_marker.directionsDisplay.setMap(map);
            }
        }
    );
}

function refresh_map()
{
    $.ajax(
    {
        url : 'map/map/show_users_on_map',
        type: 'POST',
        data:{
            csrf_test_name: $.cookie('csrf_cookie_name'),
            json: 'json'
        },
        success:function(data)
        {
            show_users_on_map($.parseJSON(data));
            setTimeout(refresh_map, 5*60*1000);
        },
        error: function(data)
        {
        }
    });
}
setTimeout(refresh_map, 1*3*1000);
</script>
