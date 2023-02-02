<?php
  session_start();
  if(!isset($_SESSION['login_user'])){
  header("location:../blog.php");
  }
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
    <title>Collaborator page</title>
</head>
<body>

    <header>
        <p>Welcome
        <?php
        echo $_SESSION['login_user'];
        ?>
        </p>
        <?php
        if(isset($_POST['signout'])){
            unset($_SESSION['login_user']);
            unset($_SESSION['login_user_name']);
            unset($_SESSION['user_id']);
            unset($_SESSION['role']);
            session_destroy();
            header('location: ../blog.php');
        }
        ?>
        <form method="post" action="">
            <button type="submit"name="signout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Log out
            </button>
        </form>
  </header> 
  <div id="search-form-wrapper">
    <form action="" method="post">
        <input placeholder="Search post here.." type="text" name="search-input"/>
        <button type="submit" name="search-button">Search</button>
    </form>
  </div>
  <div id="create-post-wrapper">
        <?php
          if(isset($_POST['create-post'])){
            $_SESSION['post_title']='';
            $_SESSION['post_content']='';
            $_SESSION['post_image']='';
            $_SESSION['post_id']='';
            header("location:./create-update-post.php");
          }
        ?>
        <form method="post">
          <button class="create-button" name="create-post" type="submit"><i class="fa-solid fa-plus"></i>Create Post</button>
        </form>
    </div>
  <main id="collaborator-post-main">
    <?php
    include "DatabaseConnection.php";
    $connection = new DatabaseConnection("localhost");
    $pdo = $connection-> connect();
    $uid = $_SESSION['user_id'];
    $postQuery = "SELECT * FROM post WHERE post.USER_ID = ".$uid;
    $result = $pdo->query($postQuery)->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['search-input'])){
      $searchInput=strtolower($_POST['search-input']);
      $query='';
      if($searchInput !=''){
        $query = $pdo->prepare("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.TITLE = ? AND post.USER_ID = user.USER_ID");
        $query->execute([$searchInput]);
      }else{
        $query = $pdo->query($postQuery);
      }
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if(!$result){
        echo "There's no post match to your query.";
      }
    }

      
    for($i = 0; $i < count($result); $i++){
        $title = $result[$i]["TITLE"];
        $content= $result[$i]["CONTENT"];
        $image = $result[$i]["IMAGE"];
        $dateCreated = $result[$i]["DATE_CREATED"];
        $published = $result[$i]["PUBLISHED"];
        $postId = $result[$i]["POST_ID"];

        //update
        if(isset($_POST['update-post-'.$i])){
            $_SESSION['post_title']= $title;
            $_SESSION['post_content']=$content;
            $_SESSION['post_image']=$image;
            $_SESSION['post_id']= $postId;
            header("location:./create-update-post.php");
          }

           //delete button
           if(isset($_POST['delete-post-' .$i])){
            $deletepost = $pdo->query("DELETE FROM post WHERE POST_ID = $postId");
            if($deletepost){
              echo "<script>window.location.reload()</script>";
            }else{
              echo "failed to delete";
            }
          }
          
    ?>
      <div class='post-parent-wrapper'>
        <form class='post-panel-wrapper' method="post" action="">
                  <button class="<?=$published == 1 ? "active":""?>" disabled>Show</button>
                  <button class="<?=$published == 0 ? "active":""?>" disabled>Hide</button>
                  <button type="submit" name="update-post-<?=$i?>">Update</button>
                  <button type="submit" name="delete-post-<?=$i?>">Delete</button>
        </form>
        <div class="post-image-wrapper">
          <img alt='post_img' src="<?php
          echo ($image =="../uploads/") ? "../uploads/no-image.png": $image;
          ?>"/>
        </div>
        <h2><?=$title?></h2>
        <p id="post-content-paragraph"><?=$content?></p>
        <p>Date created: <?=$dateCreated?></p>
      </div>
    <?php
        }
      $pdo = null;
    ?>
  </main>
</body>
</html>