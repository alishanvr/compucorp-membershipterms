CRM.$(function ($) {
    $('[name=starting_date], [name=ending_date]')
        .crmDatepicker({
            time: false,
            date: 'dd-mm-yy',
            allowClear: true
        });
});