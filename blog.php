<?php
  include "./php/DatabaseConnection.php";
  $connection = new DatabaseConnection("localhost");
  $pdo = $connection-> connect();

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
  <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
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
  <div id="search-popular-form-wrapper">
    <form action="" method="post">
        <button type="submit" name="popular-section" class="popular-button">Popular</button>
    </form> 
    <form action="" method="post">
          <input placeholder="Search post here.." type="text" name="search-input" class="search-input"/>
          <button type="submit" name="search-button">Search</button>
    </form>
  </div>

  <main id="blog-main">
  <h2 class="section-title">Blog posts</h2>
    <?php
    $postQuery = "SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.USER_ID = user.USER_ID AND post.PUBLISHED = 1";
    $result = $pdo->query($postQuery)->fetchAll(PDO::FETCH_ASSOC);

    //search blog
    if(isset($_POST['search-input'])){
      $searchInput=strtolower($_POST['search-input']);
      $query='';
      if($searchInput !=''){
        $query = $pdo->prepare("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE (LOWER(post.TITLE) = ? OR post.DATE_CREATED = ? OR LOWER(user.FIRST_NAME) = ? OR user.LAST_NAME =?) AND post.USER_ID = user.USER_ID AND post.PUBLISHED = 1");
        $query->execute([$searchInput,$searchInput,$searchInput,$searchInput]);
      }else{
        $query = $pdo->query($postQuery);
      }
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if(!$result){
        echo "There's no post match to your query.";
      }
    }

    //popular
    if(isset($_POST['popular-section'])){
      header("location: php/popular.php");
    }

      
    for($i = 0; $i < count($result); $i++){
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
            header("location:blog.php");
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
        <div class='post-image-wrapper'>
          <img alt='post_img' src="<?=substr($image,3)?>"/>
        </div>
        <div>
          <h2><?=$title?></h2>
          <p><?=$content?></p>
          <p>By <?=$name?></p>
          <p>Date created: <?php
          $dateTime = DateTime::createFromFormat('Y-m-d', $dateCreated);
          echo date_format($dateTime,"d-M-Y");
          ?></p>
        </div>
        <form action="" method="post" onsubmit="return">
          <div>
            <button type="submit" id="like-button" name="like-post-button-<?=$i?>"><i class="fa-solid fa-thumbs-up"></i></button>
            <span><?=$postLike?></span>
          </div>
          <button type="submit" class ="view-post-button" name="view-post-<?=$i?>">View</button>
        </form>
      </div>
    <?php
        }
    ?>
    <?php
      if(count($result) <=0){

    ?>
    <p>There is nothing here</p>
    <?php
      }
    ?>
  </main>
</body>
</html>