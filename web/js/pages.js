;function ClosePanelMessage(){$objmessagebox.animate({top:"0px"},200,function(){$objmessagebox.css("display","none");$(".screengray").css("display","none");});};function MessageBox(alerttype,message){if(alerttype=="erreur"){$("#messagealerttype").attr("class","spanalert erreur");$("#messagealerttype").html("Erreur");}else if(alerttype=="succÃ¨s"){$("#messagealerttype").attr("class","spanalert succes");$("#messagealerttype").html("SuccÃ¨s");}else if(alerttype=="info"){$("#messagealerttype").attr("class","spanalert info");$("#messagealerttype").html("Info");};$("#messageboxtext").html(message);$(".screengray").css({"opacity":1,"width":$(document).width(),"height":$(document).height(),"display":"inherit"});$objmessagebox=$(".divmessagebox");$objmessagebox.css("position","fixed");$objmessagebox.css("display","inherit");$objmessagebox.css("top","0px");$objmessagebox.css("left",Math.max(0,(($(window).width()-$objmessagebox.outerWidth())/2)+$(window).scrollLeft())+"px");$objmessagebox.animate({top:"250px"},350);};if($('#messageboxtext').text().length>0){MessageBox($('#messagealerttype').text(),$('#messageboxtext').text());};$('.navbar li:first-child>i').click(function(){$('.navbar li').toggle();$('.navbar li:first-child').show();});function InputActiveClass(obj){if($(obj).val().length>0){console.log($(obj).val());$(obj).addClass('active');}else{$(obj).removeClass('active');}}(function(old){$.fn.attr=function(){if(arguments.length===0){if(this.length===0){return null;};var obj={};$.each(this[0].attributes,function(){if(this.specified){obj[this.name]=this.value;}});return obj;};return old.apply(this,arguments);};})($.fn.attr);$('form :input,form :selected').keyup(function(){InputActiveClass($(this));});function CheckFormActiveClass(){$('form :input,form :selected').each(function(){InputActiveClass($(this));});};CheckFormActiveClass();