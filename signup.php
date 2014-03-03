<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:35 AM
 * To change this template use File | Settings | File Templates.
 */

require_once "Controllers/SignupController.php";

$signupController = new SignupController();

$signupController->signUpRequestHandler();