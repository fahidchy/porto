<?php
include "DatabaseConnection.php";
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location:../blog.php");
} else {
  $result=[];

    $connection = new DatabaseConnection("localhost");
    $pdo = $connection->connect();

    $query = $pdo->prepare("SELECT * FROM post WHERE USER_ID=?");
    $query->execute([1]);

    $result = $query->fetchAll();

    if(isset($_POST['search-btn'])){
     if($_POST['title'] != ''){

       $query = $pdo->prepare("SELECT * FROM post WHERE USER_ID=? AND TITLE=?");
       $query->execute([1, $_POST['title']]);
       $result = $query->fetchAll();
     }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=C, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css?v=<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <title>Collaborator Posts</title>
    <style>
      table, th, td {
        border:1px solid black;
      }
      </style>
</head>
<body>
<header>
<p>Welcome <?php echo $_SESSION['login_user']; ?></p>
<?php
if (isset($_POST['signout'])) {
    unset($_SESSION['login_user']);
    unset($_SESSION['login_user_name']);
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
if (isset($_POST['gotoposts'])) {
    header("location: ./admin-posts.php");
}
?>

    <main>
      <div class="container">
        <div>
         
          <div id="create-post-wrapper">
        <?php
          if (isset($_POST['create-post'])) {
              $_SESSION['post_title']='';
              $_SESSION['post_content']='';
              $_SESSION['post_image']='';
              $_SESSION['post_id']='';
              header("location:./create-update-post.php");
          }
?>
       
      </div>
        </div>
        <br>
        <div>
        <form method="post">
          <button class="create-button" name="create-post" type="submit"><i class="fa-solid fa-plus"></i>Create Post</button>
        </form>
        <br>
        </div>
        <div>
          
          <form method="post">
            <input class="form-control" type="text" name="title" placeholder="Search By Post Title">
            <br>
            <button class="btn btn-primary" name="search-btn" type="submit"><i class="fa-solid fa-search"></i>Search</button>&nbsp;
             <a class="btn btn-primary" href="./collaborator-posts.php"><i class="fa-solid fa-refresh"></i>Refresh</a>
          </form>
        </div>
        <br>
        <table class="table" width="100%">
          <tr>
            <th>Sn</th>
            <th>Date Created</th>
            <th>Title</th>
            <th>Content</th>
            <th>Image</th>
            <th>Published</th>
            <th></th>
            <th></th>
          </tr>
          <?php
if (count($result) > 0) {
  $sn=1;
  foreach($result as $data) {
    
      if(isset($_POST['update-post-'.$data['POST_ID']])){
        
        $_SESSION['post_title']= $data['TITLE'];
        $_SESSION['post_content']=$data['CONTENT'];
        $_SESSION['post_image']=$data['IMAGE'];
        $_SESSION['post_id']= $data['POST_ID'];
        header("location:./create-update-post.php");
      }

        //delete button
        if(isset($_POST['delete-post-' .$data['POST_ID']])){
          $postId = $data['POST_ID'];
          $deletepost = $pdo->query("DELETE FROM post WHERE POST_ID = $postId");
          if($deletepost){
            echo "successfully deleted";
            header("location:collaborator-posts.php");
          }else{
            echo "failed to delete";
          }
        }
   
 ?>
 <tr>
   <td><?php echo $sn; ?> </td>
   <td><?php echo $data['DATE_CREATED']; ?> </td>
   <td><?php echo $data['TITLE']; ?> </td>
   <td><?php echo $data['CONTENT']; ?> </td>
   <td><?php echo '<img src="data:image/png;base64,'.base64_encode($data['IMAGE']) .'" width="200px" height="100px"/>';?> </td>
   <td><?php if($data['PUBLISHED']==1){
    echo "YES";
}else{echo "NO";} ?> </td>
 <form class='post-panel-wrapper' method="post" action="">
   <td><button class="btn btn-primary" name="update-post-<?php echo $data['POST_ID']; ?>" type="submit" value="1">Edit</button></td>
   <td><button class="btn btn-danger" name="delete-post-<?php echo $data['POST_ID']; ?>" type="submit">Delete</button></td>
 </form>
 <tr>
 <?php
  $sn++;}} else { ?>
    <tr>
     <td colspan="8">No posts found</td>
    </tr>
 <?php } ?>
        </table> 

      </div>
    </main>
</body>
</html>
