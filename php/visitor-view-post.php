<?php
  session_start();
  $title = $_SESSION['viewTitle'];
  $content=$_SESSION['viewContent'];
  $name= $_SESSION['viewAuthor'];
  $dateCreated= $_SESSION['viewDate'];
  $image= $_SESSION['viewImage'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css?v=<?php echo time(); ?>">
    <title>View <?=$title?> post</title>
</head>
<body>
        <?php
            if(isset($_POST['back-button-post'])){
                unset($_SESSION['viewTitle']);
                unset($_SESSION['viewContent']);
                unset($_SESSION['viewAuthor']);
                unset($_SESSION['viewDate']);
                unset($_SESSION['viewImage']);
                header("location:../blog.php");
            }
        ?>
    <form method="post" action="" id="visitor-back-button-form">
        <button class="back-button" type="submit" name="back-button-post"><i class="fa-solid fa-arrow-left"></i></button>
    </form>
    
    <main id="visitor-view-main">
        <h1><?=$title?></h1>
        <h4>By <em><?=$name?></em> / <span><?php
        $dateTime = DateTime::createFromFormat('Y-m-d', $dateCreated);
        echo date_format($dateTime,"d-M-Y");
        ?></span></h4>
        <p><?=$content?></p>
    </main>
</body>
</html>