<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['username']);
?>
<body>
  <?php include 'menu.html';?>
  <p>
    You are now logged out.
  </p>
</body>
