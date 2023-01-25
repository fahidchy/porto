
function nameValidation(value, elementClass){
    let regex =/^[a-z ,.'-]+$/i;
    if(!regex.test(value)){
        $(elementClass).css("display","block");
    }else{
        $(elementClass).css("display","none");
    }
}

function userNameValidation(value, elementClass){
     let regex =/^[a-z_0-9]+$/i;
     if(!regex.test(value)){
        $(elementClass).css("display","block");
    }else{
        $(elementClass).css("display","none");
    }
}

function validatePasswordMatch(value,elementClass, targetElement, targetElementClass){
    if(value != $(targetElement)[0].value){
        $(elementClass).css("display","block");
    }else{
        $(elementClass).css("display","none");
        $(targetElementClass).css("display","none");
    }
}

$("#like-button").click(function(e){
    setTimeout(() => {
        e.currentTarget.disabled = true;
    },100);
    setTimeout(() => {
        e.currentTarget.disabled = false;
    },5000);
});

$("#like-popular-button").click(function(e){
    setTimeout(() => {
        e.currentTarget.disabled = true;
    },100);
    setTimeout(() => {
        e.currentTarget.disabled = false;
    },5000);
});

$("#upload-image").click(function(){
    $("#upload-image-input").trigger("click");
});

