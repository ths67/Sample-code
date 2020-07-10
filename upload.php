<?php
include('includes/init.php');

const MAX_FILE_SIZE = 100000000;

$tags = [['1','Cornell'],['2','Central Campus'],['3','North Campus'],['4','West Campus'],['5','East of campus'],['6','social media master class'],['7','football master class'],['8','music master class']];
$checkbox = "checkbox";

if (isset($_POST["upload"]) && is_user_logged_in()) {

    $galleryimage = $_FILES["galleryimage"];
    $description = filter_input(INPUT_POST, 'imgdescription', FILTER_SANITIZE_STRING);

    if ($galleryimage['error'] == UPLOAD_ERR_OK) {

        $name = basename($galleryimage['name']);
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $userid = $currentuser['id'];

        $sql = "INSERT INTO images (img_name, extension, img_description, user_id) VALUES (:img_name, :extension, :img_description, :user_id)";

        $parameterz = array(
            ':img_name' => $name,
            ':extension' => $extension,
            ':img_description' => $description,
            ':user_id' => $userid
        );

        $upload = exec_sql_query($db, $sql, $parameterz);

        if ($upload) {
            $pk = $db->lastInsertId("id");
            $newpath = "uploads/images/" . $pk . ".".$extension;
            $move = move_uploaded_file($galleryimage['tmp_name'], $newpath);
        }

        foreach($tags as $tag) {
            if (isset($_POST[$tag[0]])) {
                $query = "INSERT INTO image_tags (img_id, tag_id, user_id) VALUES (:img_id, :tag_id, :user_id)";

                $params = array(
                    ':img_id' => $pk,
                    ':tag_id' => $tag[0],
                    ':user_id' => $userid
                );

                $update = exec_sql_query($db, $query, $params);
            }
        }
    }
        else {
            echo "Failed to upload.";
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="styles/all.css">
<?php include('includes/navbar.php'); ?>
<title>Upload an image to the gallery</title>
</head>

<body>

<?php if (is_user_logged_in()) {

?>

<h1>Hello, visitor! Here you can upload a new image to the gallery!</h1>

    <form id="uploadimage" action="upload.php" method="post" enctype="multipart/form-data">
        <ul>
          <li>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>

            <label for="galleryimage">Upload an image</label>
            <input id="galleryimage" type="file" name="galleryimage">
          </li>
          <li>
            <label for="imgdescription">Image description</label>
            <textarea id="imgdescription" name="imgdescription"></textarea>
          </li>
          <li>
            <label for="tags">Tag(s):</label><br>
            <?php
            foreach ($tags as $tag)
                echo "<input type=$checkbox name=$tag[0] value=$tag[0]>$tag[1]<br>";
            ?>
          </li>
          <li>
            <button name="upload" type="submit">Upload image</button>
          </li>
        </ul>
    </form>

<?php
} else {
?>
<h2>Please log in to upload a new image to the gallery. </h2>
<?php include('includes/login.php');
}
?>

</body>

</html>
