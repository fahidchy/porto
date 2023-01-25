<?php
include "DatabaseConnection.php";
$error='';
$success='';
$connection = new DatabaseConnection("localhost");

if(isset($_POST['register'])){
    $firstName=$_POST['fname'];
    $lastName=$_POST['lname'];
    $username=$_POST['username'];
    $password=$_POST['password'];

    $pdo = $connection->connect();
    $query = $pdo->prepare("INSERT INTO user (FIRST_NAME, LAST_NAME, USERNAME, PASSWORD,ROLE) VALUES (?,?,?,password(?),?)");
    $result = $query->execute([$firstName,$lastName,$username,$password,"collaborator"]);
    if($result){
        header('location: ../blog.php');
    }else{
        $error="Something went wrong.";
    }
    $pdo=null;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loginAndRegister.css?v=<?php echo time(); ?>">
    <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
    <script src="../jscripts/index.js" defer></script>
    <title>Register as a collaborator</title>
</head>
<body>
    <main id="parent-wrapper">
        <div id="card-wrapper">
        <a href="../blog.php" class="back-button"><i class="fa-solid fa-arrow-left"></i></a>
        <form id="form" action="" method="post">
            <div class="label-input-wrapper">
                <label for="fname">First name: </label>
                <input type="text" name="fname" required onblur="nameValidation(this.value,'.fname-error')" />
                <span class="fname-error">Invalid first name</span>
            </div>
            <div class="label-input-wrapper">
             
                <label for="lname">Last name: </label>
                <input type="text" name="lname" required  onblur="nameValidation(this.value,'.lname-error')"/>
                <span class="lname-error">Invalid last name</span>
            </div>
            <div class="label-input-wrapper">
                <label for="username">User name: </label>
                <input type="text" name="username" required onblur="userNameValidation(this.value,'.uname-error')"/>
                <span class="uname-error">Invalid username</span>
            </div>
            <div class="label-input-wrapper">
                <label for="password">Password: </label>
                <input type="password" class='type-password' name="password" required onblur="validatePasswordMatch(this.value,'.password-err','.re-type-password', '.retype-password-err')" />
                <span class="password-err">Passwords do not match</span>
            </div>
            <div class="label-input-wrapper">
                <label for="re-password">Re-type Password: </label>
                <input  type="password" class='re-type-password' name="re-password" required onblur="validatePasswordMatch(this.value,'.retype-password-err','.type-password','.password-err')" />
                <span class="retype-password-err">Passwords do not match</span>
            </div>
            <div class="label-input-wrapper">
                <input type="submit" value="Register" name="register">
            </div>
        </form>
        </div>
    </main>
</body>
</html>