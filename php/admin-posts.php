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
  <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
  <title>Blog posts</title>
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
  <?php
    if(isset($_POST['gotocollab'])){
        header("location: ./admin-collaborators.php");
    }
  ?>
    <form class="admin-nav-parent" method="post">
      <div class="link-parent">
        <button class="link-wrapper posts-btn active">
          Posts
        </button>
        <button type="submit" class="link-wrapper collaborators-btn" name="gotocollab">
          Collaborators
        </button>
      </div>
    </form>
    <main>
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
      <?php
       include "DatabaseConnection.php";  

       $connection = new DatabaseConnection("localhost");
       $pdo = $connection->connect();
       $result = $pdo->query("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.USER_ID = user.USER_ID")->fetchAll(PDO::FETCH_ASSOC);
          
       for($i=0; $i < count($result); $i++){
        $title = $result[$i]["TITLE"];
        $content= $result[$i]["CONTENT"];
        $image = $result[$i]["IMAGE"];
        $published = $result[$i]["PUBLISHED"];
        $postId = $result[$i]["POST_ID"];
        $name = $result[$i]["FIRST_NAME"]. " " . $result[$i]["LAST_NAME"];
       
        // foreach ($result = $pdo->query("SELECT *, FIRST_NAME, LAST_NAME  FROM post, user WHERE post.USER_ID = user.USER_ID")->fetchAll(PDO::FETCH_ASSOC) as $row){
          // $title=$row['TITLE'];
          // $content=$row['CONTENT'];
          // $image=$row['IMAGE'];

          //update button
          if(isset($_POST['update-post-'.$i])){
            $_SESSION['post_title']= $title;
            $_SESSION['post_content']=$content;
            $_SESSION['post_image']=$image;
            $_SESSION['post_id']= $postId;
            header("location:./create-update-post.php");
          }

          //delete button
          if(isset($_POST['delete-post-' .$i])){
            // $postId= $result[$i]["POST_ID"];
            $deletepost = $pdo->query("DELETE FROM post WHERE POST_ID = $postId");
            if($deletepost){
              echo "successfully deleted";
              header("location:admin-posts.php");
            }else{
              echo "failed to delete";
            }
          }

          ?>
          <div class='post-parent-wrapper'>
          <form class='post-panel-wrapper' method="post" action="">
                      <button class="<?=$published == 1 ? "active":""?>">Show</button>
                      <button class="<?=$published == 0 ? "active":""?>">Hide</button>
                      <button type="submit" name="update-post-<?=$i?>">Update</button>
                      <button type="submit" name="delete-post-<?=$i?>">Delete</button>
        </form>
          <img alt='post_img' src="<?=$image?>"/>
          <h2><?=$title?></h2>
          <p><?=$content?></p>
          <p>By <?=$name?></p>
          </div>
      <?php
          }
         $pdo = null;
      ?>
    </main>
</body>
</html>