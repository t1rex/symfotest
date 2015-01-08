$(document).ready(function(){
    var timeLimit =60;
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
                $('.table-container').empty().append(response);
                status = 'Comment successfully added';
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
        var i = timeLimit;
        var timerId = setInterval(function() {
            $('.submit-form').html('Wait ' + i + ' s.');
            if (i == 1) {
                clearInterval(timerId);
                $('.submit-form').html('Submit').attr('disabled', false);
            }
            i--;
        }, 1000);
    }



})