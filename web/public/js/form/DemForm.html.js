/**
 * Created by Win10 on 23.04.2018.
 */


function InputActiveClass(obj) {
    if ($(obj).val().length>0) {
        $(obj).addClass('active');
    }
    else {
        $(obj).removeClass('active');
    }
}

(function(old) {
    $.fn.attr = function() {
        if(arguments.length === 0) {
            if(this.length === 0) {
                return null;
            }

            var obj = {};
            $.each(this[0].attributes, function() {
                if(this.specified) {
                    obj[this.name] = this.value;
                }
            });
            return obj;
        }

        return old.apply(this, arguments);
    };
})($.fn.attr);

var Totalelement = $('select').length;
$('select').each(function (index,value) {
    element  = document.createElement("input");
    obj = $(element).attr($(this).attr());

    var aoptions = "";
    $(this).find('option').each(function () {
        aoptions += '<a dataoptions="'+$(this).val()+'">'+$(this).text()+'</a>';
    })

    $(this).replaceWith(obj);
    obj.next().after('<div class="selectorjs">'+aoptions+'</div>');

});

function InitialSelectA1() {
    $('.selectorjs').find('a').click(function () {
        $(this).parent().parent().find('input').val($(this).text());
        console.log($(this).text());
        InputActiveClass($(this).parent().parent().find('input'));
    });
}

function InitilaeSelectElements() {

    InitialSelectA1();
    var  selectObj = $('.selectorjs').parent();
    selectObj.find('input').click(function () {
        var objint = this;
        $(this).parent().find('.selectorjs').addClass('active');
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
InitilaeSelectElements();
CheckFormActiveClass();


