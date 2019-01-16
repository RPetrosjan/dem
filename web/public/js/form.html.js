var inputs = document.querySelectorAll( 'input[type=text], input[type=email], input[type=password]' );

setTimeout(function(){

    for (var i = 0; i < inputs.length; i ++) {
        var inputEl = inputs[i];
        if( inputEl.value.trim() !== '' ) {
            inputEl.parentNode.classList.add( 'input--filled' );
        }
        inputEl.addEventListener( 'focus', onFocus );
        inputEl.addEventListener( 'blur', onBlur );

      ///  var inputsWrappers = inputEl.target.parentNode.querySelectorAll( 'span' );
        console.log(inputEl.checkValidity());

        if ( inputEl.checkValidity() == true ) {
            inputEl.parentElement.classList.add( 'inputs--filled' );
        } else if ( inputEl.checkValidity() == false ) {
            inputEl.parentElement.classList.remove('inputs--filled');
        }
    }

}, 500);

function onFocus( ev ) {
    ev.target.parentNode.classList.add( 'inputs--filled' );
}

function onBlur( ev ) {
if ( ev.target.value.trim() === '' ) {
    ev.target.parentNode.classList.remove( 'inputs--filled' );
} else if ( ev.target.checkValidity() == false ) {
    ev.target.parentNode.classList.add( 'inputs--invalid' );
    ev.target.addEventListener( 'input', liveValidation );
} else if ( ev.target.checkValidity() == true ) {
    ev.target.parentNode.classList.remove( 'inputs--invalid' );
    ev.target.addEventListener( 'input', liveValidation );
}
}

function liveValidation( ev ) {
if ( ev.target.checkValidity() == false ) {
    ev.target.parentNode.classList.add( 'inputs--invalid' );
} else {
      ev.target.parentNode.classList.remove( 'inputs--invalid' );
  }
}

var submitBtn = document.querySelector( 'input[type=submit]' );
submitBtn.addEventListener( 'click', onSubmit );

function onSubmit( ev ) {
    var inputsWrappers = ev.target.parentNode.querySelectorAll( 'span' );
    for (i = 0; i < inputsWrappers.length; i ++) {
    input = inputsWrappers[i].querySelector( 'input[type=text], input[type=email], input[type=password]' );
if ( input.checkValidity() == false ) {
    inputsWrappers[i].classList.add( 'inputs--invalid' );
} else if ( input.checkValidity() == true ) {
    inputsWrappers[i].classList.remove( 'inputs--invalid' );
}
}
}

