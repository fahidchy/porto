
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

const validateEmail = () => {
    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    const email = $('#email')[0].value;
    if(email === ""){
        document.querySelector(".err-msg-email").innerHTML = "Please enter your email";
     }else if(!emailRegex.test(email)){
        document.querySelector(".err-msg-email").innerHTML = "Invalid email";
     }else{
         document.querySelector(".err-msg-email").innerHTML ="";
     }
}

const validateMobileNum = () => {
    const mobileRegex = /^04\d{8}$/;
    const mobileNum = $('#mobileNum')[0].value;
    if(mobileNum === ""){
        document.querySelector(".err-msg-mobile").innerHTML ="";
    }else if(!mobileRegex.test(mobileNum)){
        document.querySelector(".err-msg-mobile").innerHTML = "Invalid mobile number";
    }else{
        document.querySelector(".err-msg-mobile").innerHTML ="";
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

