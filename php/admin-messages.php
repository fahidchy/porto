<?php
include "DatabaseConnection.php";  

$connection = new DatabaseConnection("localhost");
$pdo = $connection->connect();
$messages = $pdo->query("SELECT * FROM message")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" type="text/css" href="../css/blog.css?v=<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <title>Messages</title>
</head>
<body>
    <?php
        if(isset($_POST['back-button-post'])){
            header("location: admin-posts.php");
        }
    ?>
  <form method="post" action="" id="visitor-back-button-form">
      <button class="back-button" type="submit" name="back-button-post"><i class="fa-solid fa-arrow-left"></i></button>
  </form>
    <main id="messages-main">
    <?php
        for($i = 0; $i < count($messages); $i++){
          $name = $messages[$i]["FROM_NAME"];
          $content= $messages[$i]["CONTENT"];
          $mobile = $messages[$i]["FROM_MOBILE"];
          $email = $messages[$i]["FROM_EMAIL"];
    ?>
    <div class="message-wrapper">
        <p>From: <?=$name?></p>
        <p>Email address: <?=$email?></p>
        <p>Mobile number: <?=$mobile?></p>
        <p>Message: <?=$content?></p>
    </div>
    <?php
        }
      $pdo=null;
    ?>
    </main>
    
</body>
</html>