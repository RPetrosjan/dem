$.getScript( "https://code.jquery.com/ui/1.12.1/jquery-ui.js", function( data, textStatus, jqxhr ){
    InitialisationDatePicker();
});

function InitialisationDatePicker() {
     $( ".datepicker" ).datepicker({
         onSelect: function (date) {
             InputActiveClass(this);
         },
         prevText: '<i class="fas fa-chevron-left"></i>',
         nextText: '<i class="fas fa-chevron-right"></i>',
         dateFormat: 'dd/mm/yy',
         minDate: 0,
     });
     $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
}
