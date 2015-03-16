$(function() {
    $('#register-form :submit').click(function() {
        $(this).button('loading');
    });

    $('#register-form #email')[0].focus();
});
