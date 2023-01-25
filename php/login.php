<?php 
    session_start();
    include "DatabaseConnection.php";
    $error='';
    $connection = new DatabaseConnection("localhost");
    
    if (isset($_POST['signin'])){
        $pdo = $connection->connect();
        $query = $pdo->prepare("SELECT * FROM user WHERE USERNAME=? AND PASSWORD=?");
        $query->execute([$_POST['username'],$_POST['password']]);
        $result = $query->fetchAll();
        if($result){
            $error='';
            $_SESSION['login_user']=$_POST['username'];
            $_SESSION['user_id'] = $result[0]['USER_ID'];
            $_SESSION['role'] = $result[0]['ROLE'];
            $_SESSION['login_user_name'] = $result[0]['FIRST_NAME']. " ". $result[0]['LAST_NAME'];
            if($result[0]['ROLE']=='admin'){
                header('location: ./admin-posts.php');
            }else{
                header('location:./collaborator.php');
            }
        }else {
            $error = "Username or Password is invalid";
        }

        $pdo = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loginAndRegister.css">
    <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
    <title>Blogpost Sign in</title>
</head>
<body>
    <main id="parent-wrapper">
        <div id="card-wrapper">
        <a href="../blog.php" class="back-button"><i class="fa-solid fa-arrow-left"></i></a>
       <?php 
           if($error != ''){
            echo "<p style='color:red;'>$error</p>";
           }
        ?>
        <form id="form" action="" method="post">
            <div class="label-input-wrapper">
                <label for="username">Username: </label>
                <input type="text" name="username" required/>
            </div>
            <div class="label-input-wrapper">
                <label for="password">Password: </label>
                <input type="password" name="password" required/>
            </div>
            <div class="label-input-wrapper">
                <input type="submit" value="Sign in" name="signin">
            </div>
        </form>
        </div>
    </main>
</body>
</html>


