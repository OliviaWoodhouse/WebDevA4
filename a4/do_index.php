<?php
session_start();
?>
<body>
  <?php include 'mysql_connect.php';?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <?php
  $stmt = $conn->prepare("insert into post (id, creator, title, content) values (?, ?, ?, ?)");
  $stmt->bind_param("isss",
    $id,
    $creator,
    $title,
    $content
  );

  if (isset($_SESSION['id']) && isset($_POST['title']) && isset($_POST['content']) && !empty($_POST['title']) && !empty($_POST['content'])) {
    $creator = $_SESSION['id'];
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $success = $stmt->execute();
    //Collects all of the usernames using the ids
    $stmt = $conn->prepare("select id, username from user");
    $stmt->execute();
    $result = $stmt->get_result();
    $creators = array();
    while($row = $result->fetch_assoc()) {
      $creators[$row['id']]=$row['username'];
    }
    //Returns new post
    print('<p class="postBlock">');
    print('<b>Title: </b>');
    print("<b>". $title . "</b>");
    print('<br />');
    print('By: '. $creators[$creator]);
    print('<br />');
    print($content);
    print('</p>');
  }
  ?>
</body>
