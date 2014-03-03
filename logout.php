<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/19/14
 * Time: 12:12 PM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Controllers/LogoutController.php";

$logoutController = new LogoutController();
$logoutController->logoutHandler();