<?php
    include './Global.php';

    function createSigninPanel(){
        if($_SESSION['name'] !== ""){
            echo "<p>Logout</p>";
          }else{
            echo "<p>Already a collaborator? <button> Sign in</button> or <button> Register </button>";
          }
    }
        
?>
