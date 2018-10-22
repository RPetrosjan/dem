function CreateDivPostVille(obj){
    $(obj).next().after('' +
        '<div id="rtopscroll">'+
        '<div id="scrollbar1">'+
        '<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>'+
        '<div class="viewport">'+
        '<div class="overview">'+
        '<div class="villediv"></div></div>');
}

function SelectDivPostVille(){
    $('.villediv>a').unbind('click').click(function () {
        $(this).closest('div.row').find('input').val($(this).text());
        $('#rtopscroll').remove();
    });
}

$('.societe_ajax').keyup(function () {
    if($(this).val().length==5 ){
        $('.villediv').remove();
        var element = this;
        $.post('/get_cp_ville', {
            'cp':$(this).val().substring(0,5)
        },function (data) {

            CreateDivPostVille(element);
            var villeeponse = '';
            $.each(data,function (index,value) {
                villeeponse +='<a>'+value[0]+' '+value[1]+'</a>';
            });
            $('.villediv').html(villeeponse);

            SetMenuTextListboxadm(data);
            $('#scrollbar1').tinyscrollbar();
            SelectDivPostVille();
        });

        $(this).unbind('focusout').focusout(function () {
            $('body').click(function (event) {
                if(($(event.target).parent().attr('class') != 'villediv' && $(event.target).parent().attr('class') != 'track' )){
                    $('#rtopscroll').remove();
                }
            });
        });
    }
    else{
        $('#rtopscroll').remove();
    }
});


$(document).ready(function(){
    $('#scrollbar1').tinyscrollbar();
    $('input,textarea,select').filter('[required]').each(function () {
        console.log($(this).next('label').prepend('* '));
    });
});



