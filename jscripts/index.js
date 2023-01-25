
$("#like-button").click(function(e){
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