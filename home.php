<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/27/14
 * Time: 4:41 PM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Controllers/UserHomePageController.php";

$userHomeController = new UserHomePageController();
$userHomeController->userHomePageHandler();