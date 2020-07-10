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
</head>

<body>
<?php
$checkbox = "checkbox";

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $sql = "SELECT id, extension FROM images WHERE id = :id;";

    $parameterz = array(
        ':id' => $id
    );

    $result = exec_sql_query($db, $sql, $parameterz);

    if ($result) {
        $image = $result->fetchAll();
    }

    foreach($image as $i)
        echo "<img src=/uploads/images/" . $i[0] . "." . $i[1] .">";

    $sql2 = "SELECT * FROM tags INNER JOIN image_tags ON image_tags.img_id = :id AND image_tags.tag_id = tags.id;";

    $parameterz2 = array(
        ':id' => $id
    );

    $result2 = exec_sql_query($db, $sql2, $parameterz2);

    if ($result2) {
        $tags = $result2->fetchAll();

    ?>
    <ul>
    <?php
    echo "<h2>Tags:</h2>";
    foreach($tags as $tag)
        echo "<li>$tag[1]</li>";
    }
    ?>
    </ul>

    <form id="addtag" action="image_tags.php?id=<?php echo $id; ?>" method="post">
        <ul>
          <li>
            <label for="addtag">Add a tag to this image</label><br>
            <input type="text" id="addtag" name="addtag">
          </li>
          <li>
            <button name="add" type="submit">Add</button>
          </li>
        </ul>
    </form>

    <?php
    if (is_user_logged_in()) {
        $userquery = "SELECT user_id FROM images WHERE id = :id;";

        $paramz = array(
            ':id' => $id
        );

        $useresult = exec_sql_query($db, $userquery, $paramz);

        if ($useresult) {
            foreach ($useresult as $u)
              $user_id = $u;
        }

        if ($currentuser['id'] == $user_id[0]) {

    ?>

    <form id="removetag" action="image_tags.php?id=<?php echo $id; ?>" method="post">
        <ul>
          <li>
            <label for="removetag">Remove a tag from this image</label><br>
              <?php
              foreach($tags as $tag)
                echo "<input type=$checkbox name=$tag[0] value=$tag[0]>$tag[1]<br>";
              ?>
          </li>
          <li>
            <button type="submit" name="remove">Remove</button>
          </li>
        </ul>
    </form>

    <form id="deleteimage" action="image_tags.php?id=<?php echo $id; ?>" method="post">
        <button type="submit" name="delete">Delete this image</button>
    </form>

    <?php
    }
}
    ?>

  <?php
  if (isset($_POST['remove'])) {
      foreach($tags as $tag)
        if (isset($_POST[$tag[0]])) {
            $delete = "DELETE FROM image_tags WHERE img_id = :id AND tag_id = :tag_id;";

            $parameters = array(
                ':id' => $id,
                ':tag_id' => $tag[0]
            );

            $update = exec_sql_query($db, $delete, $parameters);
        }
  }
  if (isset($_POST['add'])) {
    $addtag = filter_input(INPUT_POST, 'addtag', FILTER_SANITIZE_STRING);

    $testquery = "SELECT * FROM tags WHERE tag_name = :addtag;"; //Does this tag exist?

    $testparams = array(
        ':addtag' => $addtag
    );

    $testresult = exec_sql_query($db, $testquery, $testparams);

    if ($testresult) {
        $existingtag = $testresult->fetchAll();
        if (count($existingtag) == 0) {
            $addnewtag = "INSERT INTO tags (tag_name) VALUES (:addtag)";

            $params = array(
                ':addtag' => $addtag
            );

            $addresult = exec_sql_query($db, $addnewtag, $params);
        }
        }
    $testquery2 = "SELECT * FROM image_tags INNER JOIN tags ON tags.tag_name = :addtag AND tags.id = image_tags.tag_id AND image_tags.img_id = :id;"; // Does this image already have this tag?

    $testparams2 = array(
        ':addtag' => $addtag,
        ':id' => $id
    );

    $testresult2 = exec_sql_query($db, $testquery2, $testparams2);

    $tagid = "SELECT id FROM tags WHERE tag_name = :addtag;";

    $tagparams = array(
        ':addtag' => $addtag
    );

    $tagidresult = exec_sql_query($db, $tagid, $tagparams);
    $tag_id = $tagidresult->fetchAll();

    if (count($tag_id) == 1) {
        $newtagid = $tag_id[0];
    }

    foreach($tag_id as $tid)
        $newtagid = $tid[0];

    if ($testresult2 && is_user_logged_in()) {
        $hastag = $testresult2->fetchAll();
        if (count($hastag) == 0) {
            $addthistag = "INSERT INTO image_tags (img_id, tag_id, user_id) VALUES (:id, :tag_id, :user_id);";

            $addparams = array(
                ':id' => $id,
                ':tag_id' => $newtagid,
                ':user_id' => $currentuser['id']
            );

            $addresult = exec_sql_query($db, $addthistag, $addparams);
        }
    }

    if ($testresult2 && !is_user_logged_in()) {
        $hastag = $testresult2->fetchAll();
        if (count($hastag) == 0) {
            $addthistag = "INSERT INTO image_tags (img_id, tag_id, user_id) VALUES (:id, :tag_id, :user_id);";

            $addparams = array(
                ':id' => $id,
                ':tag_id' => $newtagid,
                ':user_id' => 0
            );

            $addresult = exec_sql_query($db, $addthistag, $addparams);
        }
    }
  }
  if (isset($_POST['delete'])) {
      $deleteimage = "DELETE FROM images WHERE id = :id;";

      $parameters2 = array(
        ':id' => $id
      );

      $deletetheimage = exec_sql_query($db, $deleteimage, $parameters2);

      $query = "SELECT id, extension FROM images WHERE id = :id;";

      $parameters3 = array(
          ':id' => $id
      );

      $imageresult = exec_sql_query($db, $query, $parameters3);

      $deleteimage2 = "DELETE FROM image_tags WHERE img_id = :id;";

      $deleteparams = array(
          ':id' => $id
      );

      $deletetheimage2 = exec_sql_query($db, $deleteimage2, $deleteparams);

      foreach($imageresult as $i)
        unlink('/uploads/images/' . $i['id'] . "." . $i['extension']);
  }

}
    ?>
</body>

</html>
