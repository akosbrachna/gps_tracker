$('#geocode').tooltip({position: {
                        my: "bottom",
                        at: "top"}});

function setMarker(point)
{
    var button = "<input type='button' value='Delete marker' onclick='map.removeOverlay(marker);'/>";
    if (marker) map.removeOverlay(marker);
    map.setCenter(point, 12);
    var marker = new GMarker(point, {draggable: true});
    map.addOverlay(marker);
    GEvent.addListener(marker, "dragend", function() {
        $('#latitude').val(marker.getLatLng().lat());
        $('#longitude').val(marker.getLatLng().lng());
    });
    GEvent.addListener(marker, "mouseover", function() {
       marker.openInfoWindowHtml($('#company_id :selected').text() + ' '
                                + '('+ $('#store_number').val() + ') '
                                +$('#site_name').val() + '<br />' 
                                +$('#site_address').val() + '<br />' 
                                );
    });
}

function draw_map(point)
{
    if (point)
    {
        $('#latitude').val(point.lat());
        $('#longitude').val(point.lng());
        $('.coords').slideDown();
        $(map_canvas).show();
        $('infomap p').remove();
        $('infomap').append("<p>Drag the marker on the map<br />if you'd like to refine the location.</p>");
        $('infomap').show();
        setMarker(point);
    }
    else
    {
        $('infomap p').remove();
        $('infomap').append("<p>Address not found.</p>");
        $('.coords').hide();
    }
}

function getCoord(address)
{
    var geocoder = new GClientGeocoder();
    if(!address) 
    {
        $('infomap').html('Please, enter address!');
        $('.coords').hide();
        return;
    }
    geocoder.getLatLng(address, function(point){draw_map(point);});
}

function show_on_map(data)
{
    var point = new GLatLng(data.latitude, data.longitude);
    draw_map(point);
}

function callback(data)
{
    if (!data.latitude)
    {
        getCoord($('#site_address').val());
        return;
    }
    var point = new GLatLng(data.latitude, data.longitude);
    $('#site_id').val(data.id);
    if (data.name)   $('#site_name').val(data.name);
    if (data.address)$('#site_address').val(data.address);

    draw_map(point);
}

$('#geocode').click(function(e)
{ 
    e.preventDefault();
    e.stopPropagation();
    if (!$('#store_number').val())
    {
        getCoord($('#site_address').val());
        return;
    }
    $('#spinning_wheel').fadeIn(200);
    $.ajax(
    {
        url:  'admin/site/get_site',
        type: 'POST',
        data:{
            csrf_test_name: $("input[name=csrf_test_name]").val(),
            company_id:     $("#company_id").val(),
            store_number:   $("#store_number").val()
        },
        success: function(data)
        {
            callback($.parseJSON(data));
            $('#spinning_wheel').fadeOut(200);
        }
    }
    );
});

