
var TotalelectElement = $('select').length;
$('select').each(function (index,value) {
    element  = document.createElement("input");
    obj = $(element).attr($(this).attr());
    obj.attr('class',$(this).attr('class')+' selector');
    obj.val($(this).val());

    var aoptions = "";
    $(this).find('option').each(function () {
        if($(this).text().length>0) {
            aoptions += '<a dataoptions="'+$(this).val()+'">'+$(this).text()+'</a>';
        }
    })

    $(this).replaceWith(obj);
    objselect = obj.next().after('<div class="selectorjs">'+aoptions+'</div>');

    $(element).click(function () {
        $(this).addClass('active');
        $(this).next().next().addClass('active');
    });


    if((index+1) == TotalelectElement){
        SelectorClick();
    }
});

function RemoveSelector(obj) {
    $(obj).parent().removeClass('active');
}

$(document).on('click', function (e) {
    if ( $(e.target).closest('.selectorjs>a').length === 0 && $(e.target).closest('.selector').length === 0 ) {
        $('.selectorjs.active').removeClass('active');
    }
});

function SelectorClick(){

    $('.selectorjs>a').click(function () {
        RemoveSelector(this);
        $(this).parent().prevAll('input').val($(this).text());
    });

}