<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Contact</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
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
    <form action="" method ="GET" name="myForm" onSubmit="return validationFunction()">

      <label for="name"></label>
      Name: <input type="text" id="name" name="name" placeholder="Your name.....">
      Email: <input type="email" id="email" name="email" placeholder="Your email.....">
      Phone: <input type="text" id="phone" name="phone" placeholder="Your phone.....">
      Subject: <textarea id="subject" name="subject" placeholder="Write something here.."
        style="height:200px"></textarea>

      <input type="submit" value="Submit">

    </form>
  </div>
  <footer>
    <p >Created by Fahid Chy<br>
    </p>
  </footer>
</body>

</html>