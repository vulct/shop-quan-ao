<?php 
define("MAIN_URL_ADMIN","admin/public/");

require_once("./mvc/core/App.php");
require_once("./mvc/core/Connection.php");
date_default_timezone_set('Asia/Ho_Chi_Minh');
$myApp = new App();
$myApp->action();
