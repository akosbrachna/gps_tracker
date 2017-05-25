$("#main_view").width($(document).width()-194);
$("#main_view").height($(document).height()-42);

var form_attr = {
    form_ref: 'stock/stock/get_part/',
    form_width: '700px',
    dialog_title: 'Stock Form',
};

var callback = function(){ return;};

var table_row = function()
{
    $(".table tr:odd").css('background-color', 'rgb(255,255,255)');
    $(".table tr:even").css('background-color', 'rgb(250,250,250)');
    $(".table_row").click(function(e){
        var id = $(this).attr('id');
        e.stopPropagation();
        $('#spinning_wheel').fadeIn(200);
        $.ajax(
        {
            url : form_attr.form_ref+id,
            type: 'POST',
            data: new FormData($('form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            success:function(data)
            {
                $('#spinning_wheel').fadeOut(200);
                $('#main_form').html(data);
                $('#main_form').dialog({autoOpen: true,
                                        draggable: true,
                                        resizable: true,
                                        position: { my: "center top", 
                                                    at: "center top", 
                                                    of: "body"},
                                        modal: true,
                                        width: form_attr.form_width,
                                        title: form_attr.dialog_title
                                });
                submit_form('#main_form');
            },
            error: function(data)
            {
                $(id).html(data);
                $('#spinning_wheel').fadeOut(200);
            }
        });
        e.stopPropagation();
    });
}

form_attr.table_row = table_row;

function submit_form(id)
{
    $(id+" form").submit(
        function(e)
        {
            e.preventDefault();
            $('#spinning_wheel').fadeIn(200);
            $.ajax(
            {
                url : $(this).attr("action"),
                type: 'POST',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    $(id+' file').html($(data).filter('file').html());
                    $(id+' message').html($(data).filter('main').html());
                    $('#site_message').html($(data).filter('form_message').html()).show().delay(3000).fadeOut();
                    form_attr.table_row();
                    $('#spinning_wheel').fadeOut(200);
                    callback();
                    callback = function(){return;};
                    $("#userfile").replaceWith($("#userfile").val('').clone(true));
                    sorttable.makeSortable($(id+' message').find(".sortable").get(0));
                },
                error: function(data)
                {
                    $(id).html(data);
                    $('#spinning_wheel').fadeOut(200);
                }
            });
        }
    )
};
