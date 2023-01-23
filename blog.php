<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/blog.css">
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
  <main>
    <?php
    include "./php/DatabaseConnection.php";
    $connection = new DatabaseConnection("localhost");
    $pdo = $connection-> connect();
    $result = $pdo->query("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.USER_ID = user.USER_ID")->fetchAll(PDO::FETCH_ASSOC);
      
    for($i = 0; $i < count($result); $i++){
        $title = $result[$i]["TITLE"];
        $content= $result[$i]["CONTENT"];
        $image = $result[$i]["IMAGE"];
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

    ?>
      <div class='post-parent-wrapper'>
        <img alt='post_img' src="<?=$image?>"/>
        <h2><?=$title?></h2>
        <p><?=$content?></p>
        <p>By <?=$name?></p>
      </div>
      <form action="" method="post" onsubmit="return">
        <button type="submit" id="like-button" name="like-post-button-<?=$i?>"><i class="fa-solid fa-thumbs-up"></i></button>
      </form>
    <?php
        }
      $pdo = null;
    ?>
  </main>
</body>
</html>