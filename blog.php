<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/blog.css">
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
  <script src="jscripts/loginAndRegister.js" defer></script>
  <title>This is our blog posts</title>
</head>
<body>
  <nav class="topnav">
    <a href="index.html">Home</a>
    <a href="qualifications.html">Qualifications</a>

    <a href="hobbies.html">Hobbies</a>
    <a class="active" href="blog.php">Blog</a>
    <a href="contact.html">Contact</a>
  </nav>
  <header>
    <div id="user-account-panel-wrapper">
      <?php
        include "Global.php";
        echo $CURRENT_USER_LOGGED_IN;
        if($CURRENT_USER_LOGGED_IN){
          echo "<p>Logout</p>";
        }else{
          echo "<p>Already a collaborator? <button class='sign-in-button' name='sign-in'> Sign in</button> or <button class='register-button' name='register'> Register </button>";
        }
      ?>
    </div>
  </header>
  <div id="parent-modal">
      <div id="modal-card">
        <button class="modal-close-button" >x</button>
      </div>
    </div>
</body>
</html>