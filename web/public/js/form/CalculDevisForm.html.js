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

$('form :input,form :selected').keyup(function () {
    console.log('dfds');
    InputActiveClass($(this));
})
$('form :input,form :selected').each(function(){
    InputActiveClass($(this));
});