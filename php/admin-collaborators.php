<?php
  include "DatabaseConnection.php";
  session_start();
  if(!isset($_SESSION['login_user'])){
  header("location:../blog.php");

}
  $connection = new DatabaseConnection("localhost");
  $pdo = $connection->connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=C, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css?v=<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <title>Document</title>
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
    if(isset($_POST['gotoposts'])){
        header("location: ./admin-posts.php");
    }
  ?>
    <form class="admin-nav-parent" method="post">
      <div class="link-parent">
        <button class="link-wrapper posts-btn"  name="gotoposts">
          Posts
        </button>
        <button type="submit" class="link-wrapper collaborators-btn active" >
          Collaborators
        </button>
      </div>
    </form>
    <main>
      <div id="create-collaborator-wrapper">
        <?php
          if(isset($_POST['create-collaborator'])){
            header("location:./create-collaborator.php");
          }
        ?>

        <form method="post">
          <button class="create-button" name="create-collaborator" type="submit"><i class="fa-solid fa-plus"></i>Create collaborator</button>
        </form>
      </div>
      <table border=1>
        <tr>
          <th>First name</th>
          <th>Last name</th>
          <th>Username</th>
          <th>Action</th>
        </tr>
      <?php
        $result = $pdo->query("SELECT * FROM user WHERE ROLE='collaborator'")->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($result); $i++){
          $fname = $result[$i]['FIRST_NAME'];
          $lname = $result[$i]['LAST_NAME'];
          $uname = $result[$i]['USERNAME'];
          $uid = $result[$i]['USER_ID'];

          if(isset($_POST['delete-collaborator-'.$i])){
            $deleteUser = $pdo->query("DELETE FROM user WHERE USER_ID = $uid");
            if($deleteUser){
              echo "successfully deleted";
              header("location:admin-collaborators.php");
            }else{
              echo "failed to delete";
            }
          }
      ?>
        <tr>
          <td><?=$fname?></td>
          <td><?=$lname?></td>
          <td><?=$uname?></td>
          <td>
            <form action="" method="post">
              <button type="submit" name="delete-collaborator-<?=$i?>">Delete</button>
            </form>
          </td>
        </tr>
      <?php
        }
        $connection = null;
      ?>
      </table>
    </main>
</body>
</html>