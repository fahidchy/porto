<?php
    session_start();
    if(!isset($_SESSION['login_user'])){
    header("location:../blog.php");
    }
    include "DatabaseConnection.php";
    $error='';
    $connection = new DatabaseConnection("localhost");

       //declare post's variable for update feature
       $sessionTitle = $_SESSION['post_title'];
       $sessionContent = $_SESSION['post_content'];
       $sessionImage = $_SESSION['post_image'];

  
    if(isset($_POST['create-update-post'])){

        //upload image variables
        $target_dir = "../uploads/";
        $target_file ='';
        if($_FILES["image"]["name"]){
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

             // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                    } else {
                    echo "Sorry, there was an error uploading your file.";
                    }
            }
        }else{
            if($sessionImage != ''){
                $target_file = $sessionImage;
            }else{
                $target_file = "../uploads/no-image.png";
            }
        }
        
        //post variables
        $title = $_POST['title'];
        $content = $_POST['content'];
        $dateNow = date("Y-m-d");
        $image = $_POST['image'];
        $userid = $_SESSION['user_id'];
        $postId = $_SESSION['post_id'];

        //upload image
        // $check = getimagesize($_FILES["image"]["tmp_name"]);
        // if($check !== false) {
        //   echo "File is an image - " . $check["mime"] . ".";
        //   $uploadOk = 1;
        // } else {
        //   echo "File is not an image.";
        //   $uploadOk = 0;
        // }

        $pdo = $connection->connect();
        $query='';
        $result ='';
        if($_SESSION['post_id'] != ''){
        $query = $pdo->prepare("UPDATE post SET TITLE=?, CONTENT=?, DATE_CREATED=?, IMAGE=? WHERE POST_ID = $postId");
        $result = $query->execute([$title,$content,$dateNow,$target_file]);
        }else{
        $query = $pdo->prepare("INSERT INTO post(TITLE, CONTENT, DATE_CREATED, IMAGE, USER_ID) VALUES (?,?,?,?,?)");
        $result = $query->execute([$title,$content,$dateNow,$target_file,$userid]);
        }

        if($result){
            $error='';
            if($_SESSION['role'] == 'admin'){
                header("location:./admin-posts.php");
            }else{
                header("location: collaborator.php");
            }
        }else{
            $error = "something went wrong";
        }
        $pdo=null;
    }

 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loginAndRegister.css?v=<?php echo time(); ?>">
    <script src="../jscripts/index.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/692b5d8ceb.js" crossorigin="anonymous"></script>
    <title>Create or Update posts</title>
</head>
<body>
    <main id="parent-wrapper">
        <div id="card-wrapper">
        <?php
            if(isset($_POST['back-button-post'])){
                unset($_SESSION['post_title']);
                unset($_SESSION['post_content']);
                unset($_SESSION['post_image']);
                unset($_SESSION['post_id']);
                if($_SESSION['role'] == 'admin'){
                    header('location: ./admin-posts.php');
                }else{
                    header('location: ./collaborator.php');
                }
            }
        ?>
        <form method="post" action="">
        <button class="back-button" type="submit" name="back-button-post"><i class="fa-solid fa-arrow-left"></i></button>
        </form>
       <?php 
           if($error != ''){
            echo "<p style='color:red;'>$error</p>";
           }
        ?>
        <form id="form" action="" method="post" enctype="multipart/form-data">
            <div class="label-input-wrapper">
                <label for="title">Title: </label>
                <input type="text" name="title" required value="<?= $sessionTitle ?>" >
            </div>
            <div class="label-input-wrapper">
                <label for="content">Content: </label>
                <textarea name="content" type="text" required ><?= $sessionContent ?></textarea>
            </div>
            <div class="label-input-wrapper">
                <input type="file" id="upload-image-input" name="image" value="<?= $sessionImage?>" accept="image/jpeg,image/png,image/jpg,image/gif" style="visibility:hidden"/>
                <div>
                    <button id="upload-image" type="button">Upload image</button>
                    <label><?php
                    if($sessionImage != '../uploads/no-image.png'){
                        echo $sessionImage;
                    }?></label>
                    <!-- <?php
                    if($_SESSION['post_id'] != ''){
                    ?>
                    <button type="button" name="remove-image">X</button>
                    <?php
                    }
                    ?> -->
                </div>
            </div>
            <div class="label-input-wrapper">
                <input type="submit" value="Submit" name="create-update-post">
            </div>
        </form>
        </div>
    </main>
</body>
</html>