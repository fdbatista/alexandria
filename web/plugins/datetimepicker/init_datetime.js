$.datetimepicker.setLocale('es');
$('.datetimepicker').datetimepicker({
    value: '',
    step: 30,
    format: 'd/m/Y' + ' - ' + 'H:m',
    lang: 'es',
    timepicker: true,
    minDate: '2017/01/1',
    maxDate: 0
});
