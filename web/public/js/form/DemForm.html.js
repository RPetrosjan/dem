/**
 * Created by Win10 on 23.04.2018.
 */


function InputActiveClass(obj){
    if ($(obj).val().length>0){
        $(obj).addClass('active');
    }
    else {
        $(obj).removeClass('active');
    }
}


var Totalelement = $('select').length;
$('select').each(function (index,value) {
    element  = document.createElement("input");
    obj = $(element)
        .addClass($(this).attr('class'))
        .attr('name',$(this).attr('name'))
        .attr('id',$(this).attr('id'))
        .attr('required',$(this).attr('required'));

    var aoptions = "";
    $(this).find('option').each(function () {
        aoptions += '<a dataoptions="'+$(this).val()+'">'+$(this).text()+'</a>';
    })

    $(this).replaceWith(obj);
    obj.next().after('<div class="selectorjs">'+aoptions+'</div>');

    if(index+1 == Totalelement){
        console.log(index);
        InitilaeSelectElements();
    }


    /*
    obj.click(function () {
///        $(this).next().next().show(50);
        $(this).next().next().addClass('active');

    });

    obj.next().next().find('a').click(function () {
        $(this).parent().prev().prev().val($(this).text());
        console.log($(this).text());
        CheckFormActiveClass();
        $(this).parent().hide();
    });

    obj.focusout(function (event) {
      //  $(this).next().next().hide(200);
    }); */

})

function InitilaeSelectElements() {

    var  selectObj = $('.selectorjs').parent();

    selectObj.find('input').click(function () {
        var objint = this;
        $(this).parent().find('.selectorjs').addClass('active').find('a').click(function () {
            $(objint).val($(this).text());
            InputActiveClass(objint);
        });

        $(this).parent().unbind('focusout').focusout(function () {
            objelem = this;
            window.setTimeout(function() {
                 $(objelem).find('.selectorjs').removeClass('active');
            }, 100);
        });
    });

}


$('form :input,form :selected').keyup(function () {
     InputActiveClass($(this));
})

function CheckFormActiveClass(){
    $('form :input,form :selected').each(function(){
        InputActiveClass($(this));
    });
}


