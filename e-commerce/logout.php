<?php

      session_start();
      $_SESSION['status']=0;
      $_SESSION['user_id']=0;
      header('Location: index.php');
?>
