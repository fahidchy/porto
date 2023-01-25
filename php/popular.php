<?php
include "DatabaseConnection.php";  

$connection = new DatabaseConnection("localhost");
$pdo = $connection->connect();
$popularResult = $pdo->query("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.USER_ID = user.USER_ID ORDER BY post.POST_LIKE DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
  <link rel="stylesheet" type="text/css" href="../css/blog.css?v=<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
    <title>Popular posts</title>
</head>
<body>
  <?php
        if(isset($_POST['back-button-post'])){
            header("location:../blog.php");
        }
    ?>
  <form method="post" action="" id="visitor-back-button-form">
      <button class="back-button" type="submit" name="back-button-post"><i class="fa-solid fa-arrow-left"></i></button>
  </form>
<main id ="popular-section-wrapper">

      <h2 class="section-title"><?=count($popularResult)>0 ? "Popular":""?></h2>
    <?php
      if(count($popularResult) > 0){
        for($i = 0; $i < count($popularResult); $i++){
          $title = $popularResult[$i]["TITLE"];
          $content= $popularResult[$i]["CONTENT"];
          $image = $popularResult[$i]["IMAGE"];
          $dateCreated = $popularResult[$i]["DATE_CREATED"];
          $published = $popularResult[$i]["PUBLISHED"];
          $postId = $popularResult[$i]["POST_ID"];
          $name = $popularResult[$i]["FIRST_NAME"]. " " . $popularResult[$i]["LAST_NAME"];
          $postLike = $popularResult[$i]["POST_LIKE"];

           //like function
        if(isset($_POST['like-popular-button-' .$i])){
          $totalLike = $postLike + 1;
          $query = $pdo->prepare("UPDATE post SET POST_LIKE=? WHERE POST_ID = $postId");
          $likeResult = $query->execute([$totalLike]);
          if($likeResult){
            header("location:blog.php");
          }else{
            echo "Failed to like the post";
          }
          sleep(5);
        }

        if(isset($_POST['view-popular-post-' .$i])){
          session_start();
          $_SESSION['viewTitle'] = $title;
          $_SESSION['viewContent'] =$content;
          $_SESSION['viewAuthor'] = $name;
          $_SESSION['viewDate'] = $dateCreated;
          $_SESSION['viewImage']= $image;
          header("location: visitor-view-post.php");
        }
    ?>
      <div class='post-parent-wrapper'>
          <img alt='post_img' src="<?=substr($image,3)?>"/>
          <h2><?=$title?></h2>
          <p id="post-content-paragraph"><?=$content?></p>
          <p>By <?=$name?></p>
          <p>Date created: <?php
          $dateTime = DateTime::createFromFormat('Y-m-d', $dateCreated);
          echo date_format($dateTime,"d-M-Y");
          ?></p>
          <form action="" method="post" onsubmit="return">
            <button type="submit" id="like-popular-button" name="like-popular-button-<?=$i?>"><i class="fa-solid fa-thumbs-up"></i></button>
            <span><?=$postLike?></span>
            <button type="submit" class ="view-post-button" name="view-popular-post-<?=$i?>">View</button>
          </form>
        </div>
    <?php
        }
      }
      $pdo=null;
    ?>
  </main>
    
</body>
</html>