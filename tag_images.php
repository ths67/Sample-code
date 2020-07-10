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
<ul>
<?php
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $sql = "SELECT images.id, images.extension FROM images INNER JOIN image_tags ON image_tags.tag_id = :id AND image_tags.img_id = images.id;";

    $parameterz = array(
        ':id' => $id
    );

    $result = exec_sql_query($db, $sql, $parameterz);

    if ($result) {
        $images = $result->fetchAll();

    foreach($images as $image)
        echo '<li><img src=/uploads/images/' . $image['id'] . "." . $image['extension'] . '>' . '</li>';
    }
}
?>
</ul>


</html>
