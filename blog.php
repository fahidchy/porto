<?php
  include "./php/DatabaseConnection.php";
  $connection = new DatabaseConnection("localhost");
  $pdo = $connection-> connect();

  //fetch popular posts
  $popularPostQuery = "SELECT *, FIRST_NAME, LAST_NAME FROM post, user WHERE post.USER_ID = user.USER_ID AND post.PUBLISHED = 1 AND post.POST_LIKE > 1 ORDER BY post.POST_LIKE DESC LIMIT 3";
  $popularResult = $pdo->query($popularPostQuery)->fetchAll(PDO::FETCH_ASSOC);

  $popularPostId='';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/blog.css?v=<?php echo time(); ?>">
  <script src="./jscripts/index.js" defer></script>
  <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
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
        if(!isset($CURRENT_USER_LOGGED_IN)){
          echo "<p>Already a collaborator? <a class='sign-in-button' name='sign-in' href='../porto/php/login.php'> Sign in</a> or <a class='register-button' name='register' href='../porto/php/register.php'> Register </a>";
        }
      ?>
    </div>
  </header>
  <div id="search-form-wrapper">
    <form action="" method="post">
        <input placeholder="Search post here.." type="text" name="search-input"/>
        <button type="submit" name="search-button">Search</button>
    </form>
  </div>
  <section id ="popular-section-wrapper">
      <h2 class="section-title"><?=count($popularResult)>1 ? "Popular":""?></h2>
    <?php
     
      if(count($popularResult) > 1){
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
            echo "Success";
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
          header("location: php/visitor-view-post.php");
        }
      
    ?>
      <div class='post-parent-wrapper'>
          <img alt='post_img' src="<?=substr($image,3)?>"/>
          <h2><?=$title?></h2>
          <p><?=$content?></p>
          <p>By <?=$name?></p>
          <p>Date created: <?php
          $dateTime = DateTime::createFromFormat('Y-m-d', $dateCreated);
          echo date_format($dateTime,"d-M-Y");
          ?></p>
          <form action="" method="post" onsubmit="return">
            <button type="submit" id="like-button" name="like-popular-button-<?=$i?>"><i class="fa-solid fa-thumbs-up"></i></button>
            <span><?=$postLike?></span>
            <button type="submit" class ="view-post-button" name="view-popular-post-<?=$i?>">View</button>
          </form>
        </div>
    <?php
        }
      }

    ?>
      
  </section>
  <hr>
  <main id="blog-main">
  <h2 class="section-title">Blog posts</h2>
    <?php
    $postQuery = "SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.USER_ID = user.USER_ID AND post.PUBLISHED = 1 ORDER BY post.POST_LIKE DESC";
    $result = $pdo->query($postQuery)->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['search-input'])){
      $searchInput=strtolower($_POST['search-input']);
      $query='';
      if($searchInput !=''){
        $query = $pdo->prepare("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE (post.TITLE = ? OR post.DATE_CREATED = ? OR user.FIRST_NAME = ? OR user.LAST_NAME =?) AND post.USER_ID = user.USER_ID AND post.PUBLISHED = 1");
        $query->execute([$searchInput,$searchInput,$searchInput,$searchInput]);
      }else{
        $query = $pdo->query($postQuery);
      }
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if(!$result){
        echo "There's no post match to your query.";
      }
    }

      
    for($i = count($popularResult); $i < count($result); $i++){
        $title = $result[$i]["TITLE"];
        $content= $result[$i]["CONTENT"];
        $image = $result[$i]["IMAGE"];
        $dateCreated = $result[$i]["DATE_CREATED"];
        $published = $result[$i]["PUBLISHED"];
        $postId = $result[$i]["POST_ID"];
        $name = $result[$i]["FIRST_NAME"]. " " . $result[$i]["LAST_NAME"];
        $postLike = $result[$i]["POST_LIKE"];

        //like function
        if(isset($_POST['like-post-button-' .$i])){
          $totalLike = $postLike + 1;
          $query = $pdo->prepare("UPDATE post SET POST_LIKE=? WHERE POST_ID = $postId");
          $likeResult = $query->execute([$totalLike]);
          if($likeResult){
            echo "Success";
          }else{
            echo "Failed to like the post";
          }
          sleep(5);
        }

        if(isset($_POST['view-post-' .$i])){
          session_start();
          $_SESSION['viewTitle'] = $title;
          $_SESSION['viewContent'] =$content;
          $_SESSION['viewAuthor'] = $name;
          $_SESSION['viewDate'] = $dateCreated;
          $_SESSION['viewImage']= $image;
          header("location: php/visitor-view-post.php");
        }
    ?>
    
      <div class='post-parent-wrapper'>
        <img alt='post_img' src="<?=substr($image,3)?>"/>
        <h2><?=$title?></h2>
        <p><?=$content?></p>
        <p>By <?=$name?></p>
        <p>Date created: <?php
        $dateTime = DateTime::createFromFormat('Y-m-d', $dateCreated);
        echo date_format($dateTime,"d-M-Y");
        ?></p>
        <form action="" method="post" onsubmit="return">
          <button type="submit" id="like-button" name="like-post-button-<?=$i?>"><i class="fa-solid fa-thumbs-up"></i></button>
          <span><?=$postLike?></span>
          <button type="submit" class ="view-post-button" name="view-post-<?=$i?>">View</button>
        </form>
      </div>
    <?php
        }
      $pdo = null;
    ?>
  </main>
</body>
</html>