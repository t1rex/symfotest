$(document).ready(function(){
    var $form = $('.studios-list'),
        action = $form.attr('action');
    $('.studios-list select').on('change', function() {
        var value = $('.studios-list option:selected').attr('value');
        $.get(
            action,
            {
                'list-studio': value
            },
            onAjaxSuccess
        );
        function onAjaxSuccess(response)
        {
            $('.studio-info').empty().append(response);
        }
    })
})

$.each( $form.serializeArray(), function(i, field) {
    values[field.name] = field.value;
});