<?php
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="stylesheet" href="styles/all.css">
  <?php include('includes/navbar.php'); ?>

  <title>The Master Class Visitors</title>
  <h1>The Master Class Visitors</h1>
</head>

<body>

<h1>Image Gallery</h1>

<h3>Four masters of their crafts are visiting Cornell and giving master classes to Cornell apprentices. Follow along here!</h3>

<ul>
  <?php
  $images = exec_sql_query($db, "SELECT * FROM images")->fetchAll(PDO::FETCH_ASSOC);
  foreach($images as $image) {
    echo htmlspecialchars($image['img_description']) . '<li><a href="image_tags.php?' . http_build_query(array('id' => $image['id'])) . '"><img src="/uploads/images/' . $image['id'] . "." . $image['extension'] . '"/></a></li>';
  }
  ?>
</ul>
</body>

</html>
