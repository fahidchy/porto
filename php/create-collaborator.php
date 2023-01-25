<?php
    session_start();
    if(!isset($_SESSION['login_user'])){
    header("location:../blog.php");
    }
    include "DatabaseConnection.php";
    $error='';
    $connection = new DatabaseConnection("localhost");
    $pdo = $connection->connect();

    if(isset($_POST['create-collaborator'])){
        $fname = $_POST['fname'];
        $lname= $_POST['lname'];
        $uname = $_POST['uname'];
        $pw = $_POST['pw'];

        $query = $pdo->prepare("INSERT INTO user (FIRST_NAME, LAST_NAME, USERNAME, PASSWORD, ROLE) VALUES (?,?,?,?,?)");
        $result = $query->execute([$fname,$lname,$uname,$pw,"collaborator"]);
        if($result){
            echo "success";
            header("location: ./admin-collaborators.php");
        }else{
            echo "Something went wrong";
        }
    }

    $pdo=null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loginAndRegister.css">
    <script src="../jscripts/index.js" defer></script>
    <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
    <title>Create Collaborators</title>
</head>
<body>
    <main id="parent-wrapper">
        <div id="card-wrapper">
        <?php
            if(isset($_POST['back-button-post'])){
                header('location: ./admin-collaborators.php');
            }
        ?>
        <form method="post" action="">
        <button class="back-button" type="submit" name="back-button-post"><i class="fa-solid fa-arrow-left"></i></button>
        </form>
       <?php 
           if($error != ''){
            echo "<p style='color:red;'>$error</p>";
           }
        ?>
        <form id="form" action="" method="post">
            <div class="label-input-wrapper">
                <label for="fname">First name: </label>
                <input type="text" name="fname" required  onblur="nameValidation(this.value,'.fname-error')" />
                <span class="fname-error">Invalid first name</span>
            </div>
            <div class="label-input-wrapper">
                <label for="lname">Last name: </label>
                <input type="text" name="lname" required onblur="nameValidation(this.value,'.lname-error')"/>
                <span class="lname-error">Invalid last name</span>
            </div>
            <div class="label-input-wrapper">
                <label for="uname">Username: </label>
                <input type="text" name="uname" required onblur="userNameValidation(this.value,'.uname-error')"/>
                <span class="uname-error">Invalid username</span>
            </div>
            <div class="label-input-wrapper">
                <label for="pw">Password: </label>
                <input type="text" name="pw" required >
            </div>
            <div class="label-input-wrapper">
                <input type="submit" value="Create" name="create-collaborator">
            </div>
        </form>
        </div>
    </main>
</body>
</html>