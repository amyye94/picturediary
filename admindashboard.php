<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:36 AM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Controllers/AdminDashBoardController.php";

$adminDashBoardController = new AdminDashBoardController();

$adminDashBoardController->adminDashBoardHandler();