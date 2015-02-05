$('#upgrade-code').submit(function() {
    ajaxForm($(this), $(this).attr('action'), function() {
        window.location.reload();
    });

    return false;
});

$('#pricing-plans .select-plan').click(function() {
    var planId = $(this).parents('.plan').find('.plan_id').val();
    var plan = plans[planId];

    $('#charge-form input[name="plan"]').val(planId);

    // Open Checkout with further options
    handler.open({
        name: plan.name,
        //description: '2 widgets ($20.00)',
        amount: plan.price*100
    });

    return false;
});

function cancelSubscription(link, email) {
    link.button('loading');

    doorbell.send('I would like to cancel my account.', email, function() {
        link.button('reset');
        $.bootstrapGrowl('Your request was received');
    }, function(error) {
        link.button('reset');
        $.bootstrapGrowl(nl2br(error), { type: 'danger' });
    });
}

new Spinner({color:'#333', lines: 12}).spin($('#loading-spinner')[0]);
