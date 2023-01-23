
$("#like-button").click(function(e){
    setTimeout(() => {
        e.currentTarget.disabled = true;
    },100);
    setTimeout(() => {
        e.currentTarget.disabled = false;
    },5000);
});