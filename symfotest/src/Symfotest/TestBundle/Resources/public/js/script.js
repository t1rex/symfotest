$(document).ready(function(){
    $('.comment-form input').removeAttr('value');

    var $form = $('.comment-form'),
        action = $form.attr('action');
    $form.submit(function(){
        var data = $form.serialize();
        $.ajax({
            type: "POST",
            url: action,
            dataType: 'json',
            data: data,
            success: function(response){
                $('.table-container').empty().append(response);
            },
            error: function(data) {
                alert('Error:' + data + ' is not valid');
            }
        });
        return false;
    })

})