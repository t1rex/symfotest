var formHandler = function() {
    var timeLimit =60;
    var $container = $('.table-container'),
        message = '',
        $form = $('.comment-form'),
        action = $form.attr('action'),
        data = null,
        $submitForm = $('.submit-form');

    $form.submit(function(){
        $submitForm.attr('disabled', true);
        data = $form.serialize();
        $.ajax({
            type: "POST",
            url: action,
            dataType: 'json',
            data: data,
            success: function(response){
               var noErrors = (response["errorMessage"] != undefined);
               if (noErrors) {
                    message = response["errorMessage"];
               } else{
                    $container.empty().append(response);
                    message = 'Comment successfully added. You can add new comment through 60 s.';
               }
               showDialog(message);
               if (!noErrors){
                   showTime();
               } else {
                   $submitForm.attr('disabled', false);
               }
            },
            error: function() {
                message = 'Error: comment can\'t be added';
                showDialog(message);
                $submitForm.attr('disabled', false);
            }
        });
        return false;
    });

    function showTime() {
        var i = timeLimit;
        var timerId = setInterval(function () {
            $submitForm.html('Wait ' + i + ' s.');
            if (i == 1) {
                clearInterval(timerId);
                $submitForm.html('Submit').attr('disabled', false);
            }
            i--;
        }, 1000);
    }

    function showDialog(message)
    {
        $( "#dialog").html('<p>' + message + '</p>').dialog({
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
    }
}
$(document).ready(function(){
    new formHandler();
})

