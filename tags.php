<?php
include('includes/init.php');
?>

<!DOCTYPE html>


<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="styles/all.css">
    <?php include('includes/navbar.php');
    ?>
    <h1>The Master Class Visitors - Tags</h1>
</head>

<body>
<ul>
  <?php
  $tags = exec_sql_query($db, "SELECT * FROM tags")->fetchAll(PDO::FETCH_ASSOC);
  foreach($tags as $tag) {
    echo '<li><a href="tag_images.php?' . http_build_query(array('id' => $tag['id'])) . '">' . $tag['tag_name'] . '</a></li>';
  }
  ?>
</ul>
</body>

</html>
