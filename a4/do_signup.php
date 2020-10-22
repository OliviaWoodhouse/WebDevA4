<body>
  <?php include 'menu.html';?>
  <?php include 'mysql_connect.php';?>

  <?php
    //https://www.w3schools.com/php/php_mysql_prepared_statements.asp

    $stmt = $conn->prepare("insert into user (id, username, password) values (?, ?, ?)");

    //s means string, i means int, d means double
    $stmt->bind_param("iss",
      $id,
      $username,
      $password
    );

    $username = $_POST['username'];

    // Hash the password so we don't store
    // password in plain text
    $password = password_hash(
      $_POST['password'],PASSWORD_DEFAULT);

    $success = $stmt->execute();
  ?>
  <p>
    <?php
      if (!$_POST['username'] || !$_POST['password']) {
        print('You left one or more of the required fields blank.');
      }
      elseif (!$success) {
        print('Signup failed: '. $stmt->error);
      }
      else {
        print('Signup successful');
      }
    ?>
  </p>
</body>
