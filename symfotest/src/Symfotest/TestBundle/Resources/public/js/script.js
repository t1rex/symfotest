$(document).ready(function(){
    $( "#dialog").hide();
    $('.comment-form input').removeAttr('value');
    var status = '';
    var $form = $('.comment-form'),
        action = $form.attr('action'),
        data = null;
    $form.submit(function(){
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
                alert(status);
            }
        });
        return false;
    })
})