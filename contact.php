<?php
 include "./php/DatabaseConnection.php";
 $connection = new DatabaseConnection("localhost");
 $pdo = $connection-> connect();

  if(isset($_POST['submit-contact-form'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $content = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO message (FROM_EMAIL,FROM_MOBILE, FROM_NAME, CONTENT) VALUES(?,?,?,?)");
    $result = $stmt->execute([$email,$mobile,$name,$content]);
    if($result){
      header("location:contact.php");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Contact Form</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
  <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
  <script src="./jscripts/index.js" defer></script>
</head>

<body>
  <div class="topnav">

    <a href="index.html">Home</a>

    <a href="qualifications.html">Qualifications</a>
    <a href="hobbies.html">Hobbies</a>
    <a href="blog.php">Blog</a>
    <a class="active" href="contact.html">Contact</a>
  </div>
  <h1>CONTACT</h1>
  <div class="container">
    <p>If you would like to contact me for any enquiry please fill out the form. Thank you!</p>

  </div>
  <main id="contact-main">
    <form action="" method ="post">
    <div class="label-input-wrapper">
        <label for="name">Name: </label>
        <input type="text" name="name" required placeholder="Your name..." onblur="nameValidation(this.value,'.name-error')" />
        <span class="name-error">Invalid name</span>
    </div>

    <div class="label-input-wrapper">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" required placeholder="Your email..." onblur="validateEmail()"/>
        <span class="err-msg-email"></span>
    </div>
    <div class="label-input-wrapper">
        <label for="mobile">Mobile #: </label>
        <input type="text" id="mobileNum" name="mobile" required placeholder="Your mobile number..."onblur="validateMobileNum()"/>
          <span class="err-msg-mobile"></span>
    </div>
    <div class="label-input-wrapper">
      <label for="message">Message: </label>
      <textarea name="message" placeholder="Write something here.."></textarea>
    </div>

    <input type="submit" value="Submit" name="submit-contact-form">

    </form>
  </main>
  <footer>
    <p >Created by Fahid Chy<br>
    </p>
  </footer>
</body>

</html>