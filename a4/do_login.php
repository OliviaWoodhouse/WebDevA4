<?php
session_start();
?>
<body>
  <?php include 'menu.html';?>
  <?php include 'mysql_connect.php';?>

  <?php
    $stmt = $conn->prepare("select * from user where username=?");
    $stmt->bind_param("s", $username);
    $username = $_POST['username'];
    $stmt->execute();

  ?>
  <p>
    <?php
      $result = $stmt->get_result();
      if ($result->num_rows == 0) {
        print('No account found');
      }
      else {
        $row = $result->fetch_assoc();
        if (password_verify($_POST['password'], $row['password'])) {
          print('Hello '.$row['username'].', you are now logged in.');
          $_SESSION['id'] = $row['id'];
          $_SESSION['username'] = $row['username'];
        }
        else {
          print('Wrong password.');
        }
      }
    ?>
  </p>
</body>
