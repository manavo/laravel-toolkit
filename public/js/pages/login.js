$(function() {
    $('#login-form :submit').click(function() {
        $(this).button('loading');
    });

    $('#login-form #email')[0].focus();
});
