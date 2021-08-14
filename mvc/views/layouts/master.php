<?php include('./mvc/views/include/header.php'); ?>
<?php if (isset($dataViews)) {
    require_once('./mvc/views/'.$dataViews['views'].'.php');
} ?>
<?php include('./mvc/views/include/footer.php'); ?>