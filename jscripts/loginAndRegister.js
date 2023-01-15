
const parentModalElement = $("#parent-modal");
var signInButton = $('.sign-in-button');
// const signOutButton;
var registerButton = $('.register-button');
var modalForm = $("<form/>").attr({"id":"modal-form", "method":"post","action":""});


var showModal = (el) => {
    parentModalElement.css("display","flex");
    $("#modal-card").append(modalForm);
    switch (el.target.name){
        case "sign-in":
            signInView();
            break;
        case "register":
            registrationView();
            break;
    }
}

function closeModal(){
    $("#modal-form").empty();
    parentModalElement.css("display","none");
    console.log("removed");
}

signInButton.on("click", showModal);
registerButton.on("click",showModal);
$(".modal-close-button").on("click", closeModal);

//closure function for reusable creation of form element inputs
function formChildElementsGenerator(inputName, inputType, htmlName){
    return function(){
        return $("<div/>").append($(`<label for=${inputName} />`).html(htmlName), 
        $(`<input name=${inputName} type=${inputType} class="form-input" />`));
    }
}


//Run when Sign-in button is clicked.
function signInView(){
    // let usernameInput = $("<div/>").append($("<label for='username'/>").html("Username: "), $("<input type='text' name='username' required/>"));
    let usernameInput = formChildElementsGenerator("username", "text", "Username: ");
    let passwordInput = formChildElementsGenerator("password", "email", "Password: ");
    let submitButton = $("<input type='submit' value='Sign In'/>");
    
    modalForm.append(usernameInput(), passwordInput(), submitButton);
}

//Run when Register button is clicked.
function registrationView(){
    let firstNameInput = formChildElementsGenerator("fname", "text", "First name: ");
    let lastNameInput = formChildElementsGenerator("lname", "text", "Last name: ");
    let usernameInput = formChildElementsGenerator("username", "text", "Username: ");
    let passwordInput = formChildElementsGenerator("password", "email", "Password: ");
    
    let submitButton = $("<input type='submit' value='Register'/>");

   modalForm.append(firstNameInput(), lastNameInput(), usernameInput(), passwordInput(), submitButton);
}


