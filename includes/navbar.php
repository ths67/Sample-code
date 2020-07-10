<header>

<?php $currentpages = [['index.php', 'Image Gallery'],['tags.php', 'Tags'],['upload.php', 'Log in and/or upload a new image to the gallery']]; ?>

<nav>
    <ul>
    <?php
    foreach ($currentpages as $currentpage)
        echo "<li><a href=$currentpage[0]>$currentpage[1]</a></li>";
    ?>
    </ul>
</nav>

<?php
if (is_user_logged_in()) {
    $logout = htmlspecialchars($_SERVER['PHP_SELF']) . '?' . http_build_query(array('logout' => ''));
    echo '<a href="' . $logout . '">Log out, ' . htmlspecialchars($currentuser['user_name']) . '</a>';
}
?>

</header>
