<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
#map_canvas_phone{
    position: absolute;
    top: 55px;
    left: 0px;
    margin: 0px !important;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
#map_canvas_phone .gm-style img{
    max-width: none !important;
}
#phone_menu{
    position: absolute;
    top: 0px;
    left: 0px;
    padding: 0px;
    margin: 0px !important;
    height: 55px;
    width: 100%;
    overflow: hidden;
    border: solid 1px rgb(200,200,255);
    background: rgb(240,240,240);
    font-weight: bold;
}
.phone_menu_item{
    display: inline-block;
    border-right: solid 1px rgb(200,200,255);
    margin: 15px 5px 0px 10px;
    padding: 0px 25px 0px 8px;
}
.phone_pages{
    position: absolute;
    top: 60px;
    left: 0px;
    margin: auto;
    padding: 10px;
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
    visibility: hidden;
}
.logout{
    position: fixed; 
    bottom: 20px; 
    right: 30px;
    font-size: 18px;
}
#phone_settings{
    color: blue;
    font-weight: bold;
    font-size: 16px;
}
</style>

<div id='phone_menu'>
    <font class="phone_menu_item" value='map_canvas_phone'>Map</font>
    <font class="phone_menu_item" value='phone_contacts'>Contacts</font>
    <font class="phone_menu_item" value='phone_settings'>Settings</font>
</div>

<div id='phone_settings' class="phone_pages">
    <p class="logout"><a href="authorization/login/logout">Logout</a></p>
    <br/>
    <p>
      <label for="frequency">Refresh frequency: </label>
      <input type="number" id="frequency" value="3" min="1" max="10" onblur="frequency_changed(this);">minutes<br/>
      Value should be between 1 and 10.
    </p>
    <br/>
    <hr>
    <br/>
    <p><a href="<?php echo base_url('web/android/gps_tracker.apk'); ?>" target="_blank">Download android application</a></p>
</div>
<div id='phone_contacts' class="phone_pages"></div>


<div id="map_canvas_phone"></div>

<script>
    var frequency = 3;
    function frequency_changed(input)
    {
        if (input.value > 10 || input.value <1)
        {
            alert("The frequency value should be between 1 and 10.");
            return;
        }
        frequency = input.value;
    }
</script>
<script>
map = new google.maps.Map(document.getElementById("map_canvas_phone"), 
                    { center:new google.maps.LatLng(0, 0),
                      zoom: 2,
                      mapTypeId: google.maps.MapTypeId.ROADMAP });

var first_loaded = true;
function center_map(latitude, longitude)
{
    if (first_loaded)
    {
        map.setZoom(7);
        map.setCenter(new google.maps.LatLng(latitude, longitude));
        first_loaded = false;
        return;
    }
}

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
    center_map(value.latitude, value.longitude);
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
    create_checkbox(value);
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
        //if (prev_marker.position.equals(latlng))
          //  return;
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

function create_checkbox(value)
{
    var user = users[value.id];

    var markers = users[value.id].markers;

    var label= document.createElement("label");
    label.style.color = user.color;
    label.style.width = "100%";
    label.style.float = "left";
    label.style.borderBottom = "2px solid "+user.color;
    label.style.padding = "20px 2px 15px 2px";
    
    user.checkbox = document.createElement("input");
    user.checkbox.type = "checkbox";
    user.checkbox.checked = true;
    user.checkbox.style.float = "left";
    label.appendChild(user.checkbox);
    
    var name = document.createElement("div");
    name.innerHTML = user.name;
    name.style.float = "left";
    label.appendChild(name);
    
    var phone = document.createElement("div");
    phone.innerHTML = "phone: "+user.phone_number;
    phone.style.marginLeft = "20px";
    phone.style.float = "left";
    phone.style.clear = "both";
    label.appendChild(phone);
    
    var pic = document.createElement("img");
    pic.src = src="<?php echo base_url('web/pics/users'); ?>/"+user.email+".jpg";
    pic.style.height = "40px";
    pic.style.marginLeft = "30px";
    pic.onload = function(){
        label.appendChild(pic);
    }

    document.getElementById('phone_contacts').appendChild(label);
    
    user.checkbox.onclick = function() 
    {        
        if (user.checkbox.checked) 
        {
            user.visible = true;
            var i = markers.length-1;
            markers[i].infowindow.open(map, markers[i]);
            for (var x in markers)
            {
                markers[x].setVisible(true);
                if (x > 0) markers[x].directionsDisplay.setMap(map);
            }
        } 
        else 
        {
            user.visible = false;
            for (var x in markers)
            {
                markers[x].infowindow.close();
                markers[x].setVisible(false);
                if (x > 0) markers[x].directionsDisplay.setMap(null);
            }
        }
    }
}
</script>
<script>
function get_location() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(save_position);
    } 
    else {
        alert("Geolocation is not supported on this browser.");
    }
}
var my_latitude = 0;
var my_longitude = 0;
function save_position(position) 
{
    my_latitude  = position.coords.latitude;
    my_longitude = position.coords.longitude;
}

function refresh_map()
{
    get_location();
    $.ajax(
    {
        url : 'phone/map/show_contacts_on_map',
        type: 'POST',
        data:{
            csrf_test_name: $.cookie('csrf_cookie_name'),
            json: 'json',
            latitude: my_latitude,
            longitude: my_longitude
        },
        success:function(data)
        {
            show_users_on_map($.parseJSON(data));
            setTimeout(refresh_map, frequency*60*1000);
        },
        error: function(data)
        {
        }
    });
}
google.maps.event.addListenerOnce(map, 'idle', refresh_map);
</script>
<script>
    var current_menu = "map_canvas_phone";
    $('.phone_menu_item').click(function()
    {
        $('#'+current_menu).css('visibility', 'hidden');
        current_menu = $(this).attr('value');
        $('#'+current_menu).css('visibility', 'visible');
    });
</script>
