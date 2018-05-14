function CreateDivPostVille(obj){
    $(obj).next().after('<div class="villediv"></div>');
}

function SelectDivPostVille(){
    $('.villediv>a').unbind('click').click(function () {
        $(this).parent().prev().prev().val($(this).text());
        $(this).parent().remove();
    });
}

$('.cp_ville').keyup(function () {
    if($(this).val().length==5 ){
        $('.villediv').remove();
        var element = this;
        $.post('/get_cp_ville',
            {
                'cp':$(this).val().substring(0,5)
            }
            ,function (data) {

                CreateDivPostVille(element);
                var villeeponse = '';
                $.each(data,function (index,value) {
                    villeeponse +='<a>'+value[0]+' '+value[1]+'</a>';
                });
                $('.villediv').html(villeeponse);

                SelectDivPostVille();
        });
    }
    else if($(this).val().length<5){
        if($('.villediv').length>0){
            $('.villediv').remove();
        }
    }
});
