<?php require_once('./mvc/views/include/header.php'); ?>
<?php
    if (!is_null($cssFile)){
        foreach ($cssFile as $css){
            echo "
    ";
            echo '<link rel="stylesheet" href="'.$css.'">
    ';
        }
    }
?>
</head>
<?php require_once('./mvc/views/include/sidebar.php'); ?>
<?php if (isset($dataViews)) {
    require_once('./mvc/views/'.$dataViews['views'].'.php');
}
?>
<?php require_once('./mvc/views/include/footer.php'); ?>
