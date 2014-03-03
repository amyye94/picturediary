<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 1:55 PM
 * To change this template use File | Settings | File Templates.
 */

require_once "/var/www/html/picturediary/Controllers/LoginController.php";

$loginController = new LoginController();

$loginController->loginHandler();
