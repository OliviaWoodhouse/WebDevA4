<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style type="text/css">
  .postBlock {
    box-shadow: 0px 0px 1.5px 0px grey;
    margin-top: 0px;
    margin-bottom: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 5px;
    padding-right: 5px;
  }
  #createpost {
    padding-top: 10px;
  }
</style>
</head>
<?php
session_start();
?>
<body>
  <?php include 'menu.html';?>
  <?php include 'mysql_connect.php';?>
  <h1>Posts</h1>

  <section id='previousposts'>
    <?php
    //Collects all of the usernames using the ids
    $stmt = $conn->prepare("select id, username from user");
    $stmt->execute();
    $result = $stmt->get_result();
    $creators = array();
    while($row = $result->fetch_assoc()) {
      $creators[$row['id']]=$row['username'];
    }

    //Prints posts
    $stmt = $conn->prepare("select * from post");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows==0) {
      print('<p id="noPosts">No posts available</p>');
    } else {
      while($row = $result->fetch_assoc()) {
        print('<p class="postBlock">');
        print('<b>Title: </b>');
        print("<b>". $row['title'] . "</b>");
        print('<br />');
        print('By: '. $creators[$row['creator']]);
        print('<br />');
        print($row['content']);
        print('</p>');
      }
    }
    ?>
  </section>

  <!-- Checks if user is logged in and if so, allows the user to make a post via a form -->
  <p id='createpost'>
    <?php if (isset($_SESSION['username'])): ?>
        <form method="post" action="do_index.php" id="myForm">
          <?php
            $username = $_SESSION['username'];
            print('<b>Create a post as </b>');
            print("<b>" . $username . "</b><br />");
          ?>
          Title <input type="text" id="title" name="title" /><br />
          Content <br /><textarea id='content' name="content" rows="10" cols="50"></textarea><br />
          <input type="submit" value="Submit post" />
        </form>
    <?php else:?>
      <?php print('<br />You need to log in to make a post<br />'); ?>
    <?php endif; ?>
  </p>

  <script>

  //This function dynamically appends a new post into the posts section
  function showPosts(data) {
    if($('#noPosts').length) {
      $('#noPosts').remove();
    }
    $('#previousposts').append(data);
  }

  //To submit a new post to the PHP post database
  $("#myForm").submit(function(event) {
    if($.trim($('#title').val()) == ''||$.trim($('#content').val()) == ''){
            alert('A post must be complete before submission');
            return false;
    }
    event.preventDefault();
    var form = $(this);
    $.ajax({
      method: form.attr("method"),
      url: form.attr("action"),
      data: {title: $('#title').val(),
             content: $('#content').val()
              }
    }).done(function(result) {
      $('#title').val('');
      $('#content').val('');
      showPosts(result);
    })
  })

  function endSession() {
    alert("bye");
  }
  </script>
</body>
</html>
