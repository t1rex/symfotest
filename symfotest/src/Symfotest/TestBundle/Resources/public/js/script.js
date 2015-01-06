$(document).ready(function(){
    var timeLimit =60;
    var $container = $('.table-container');
    $('.comment-form input').removeAttr('value');
    var status = '';
    var $form = $('.comment-form'),
        action = $form.attr('action'),
        data = null;
    $form.submit(function(){
        $('.submit-form').attr('disabled', true);
        data = $form.serialize();
        $.ajax({
            type: "POST",
            url: action,
            dataType: 'json',
            data: data,
            success: function(response){
                if (response["error"] != undefined ) {
                    $container.append(response)
                    status = response["error"];
                } else{
                    $container.empty().append(response);
                    status = 'Comment successfully added';
                }

            },
            error: function(data) {
                alert('Error:' + data + ' is not valid');
                status = 'Error: comment can\'t be added';
            },
            complete: function(){
                $( "#dialog").html('<p>' + status + '</p>' + '<br/> You can add comment through 60 s.').dialog({
                    dialogClass: "no-close",
                    buttons: [
                        {
                            text: "OK",
                            click: function() {
                                $( this ).dialog( "close" );
                            }
                        }
                    ]
                });
                showTime();
            }
        });
        return false;
    });

    function showTime() {
        var i = 1;
        var timerId = setInterval(function() {
            $('.submit-form').html('Wait ' + i + ' s.');
            if (i == timeLimit) {
                clearInterval(timerId);
                $('.submit-form').html('Submit').attr('disabled', false);
            }
            i++;
        }, 1000);
    }



})