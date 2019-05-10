jQuery(document).ready(function($) {
    $(".table-striped>tbody>tr").click(function() {
       var href = $(this).find('a').attr('href');
       if(typeof href !== "undefined") {
           window.location = href;
       }
    });
});