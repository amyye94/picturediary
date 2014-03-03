<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:35 AM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Controllers/MyDashBoardController.php";

$myDashboardController = new MyDashBoardController();

$myDashboardController->myDashBoardHandler();

