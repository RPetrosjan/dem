/**
 * Created by Win10 on 23.04.2018.
 */


function InputActiveClass(obj) {
    if ($(obj).val().length>0) {
        console.log($(obj).val());
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


$('form :input,form :selected').keyup(function () {
     InputActiveClass($(this));
})

function CheckFormActiveClass(){
    $('form :input,form :selected').each(function(){
        InputActiveClass($(this));
    });
}

CheckFormActiveClass();


