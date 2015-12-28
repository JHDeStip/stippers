<?php

/**
 * This file is part of the Stippers project (available here: https://github.com/Stannieman/stippers/).
 * The license and all terms en conditions that apply to Stippers also apply to this file.
 * 
 * @author Stan Wijckmans
 * 
 * The router. This makes sure all requests get handled by the right controller.
 */

require_once 'config/DomainConfig.php';

//Isolate the URL part that says which page is requested
$requestData['requestedPage'] = explode('?', str_replace(DomainConfig::DOMAINSUFFIX, '', strtolower($_SERVER['REQUEST_URI'])), 2)[0];

//Add middleware
//Session is started in authorization, so always run that first
$middleware = array();
require_once 'middleware/Authorization.php';
require_once 'middleware/SessionCleanup.php';
array_push($middleware, 'Authorization');
array_push($middleware, 'SessionCleanup');

//Aliases, with these you can define alternative names for pages
switch ($requestData['requestedPage']) {
    case '':
        $requestData['requestedPage'] = 'home';
        break;
}

//Assign controllers
$pageNotFound = false;
switch ($requestData['requestedPage']) {
    case 'home':
        require_once('controllers/home/HomeController.php');
        $controller = 'HomeController';
        break;
    case 'manageuser':
        require_once('controllers/manageUser/ManageUserController.php');
        $controller = 'ManageUserController';
        break;
    case 'edituser':
        require_once('controllers/editUser/EditUserController.php');
        $controller = 'EditUserController';
        break;
    case 'weeklywinner':
        require_once('controllers/weeklyWinner/WeeklyWinnerController.php');
        $controller = 'WeeklyWinnerController';
        break;
    case 'checkin':
        require_once('controllers/checkIn/CheckInController.php');
        $controller = 'CheckInController';
        break;
    case 'addorrenewuser':
        require_once('controllers/addRenewUser/addOrRenewUser/AddOrRenewUserController.php');
        $controller = 'AddOrRenewUserController';
        break;
    case 'adduser':
        require_once('controllers/addRenewUser/addUser/AddUserController.php');
        $controller = 'AddUserController';
        break;
    case 'renewusersearch':
        require_once('controllers/addRenewUser/renewUserSearch/RenewUserSearchController.php');
        $controller = 'RenewUserSearchController';
        break;
    case 'renewuser':
        require_once('controllers/addRenewUser/renewUser/RenewUserController.php');
        $controller = 'RenewUserController';
        break;
    case 'managebrowser':
        require_once('controllers/manageBrowser/ManageBrowserController.php');
        $controller = 'ManageBrowserController';
        break;
    case 'addbrowser':
        require_once('controllers/manageBrowser/AddBrowserController.php');
        $controller = 'AddBrowserController';
        break;
    case 'editbrowser':
        require_once('controllers/manageBrowser/EditBrowserController.php');
        $controller = 'EditBrowserController';
        break;
    case 'logout':
        require_once('controllers/authorization/LogoutController.php');
        $controller = 'LogoutController';
        break;
    case 'login':
        require_once('controllers/authorization/LoginController.php');
        $controller = 'LoginController';
        break;
    default:
        $pageNotFound = true;
        require_once('controllers/pageNotFound/PageNotFoundController.php');
        $controller = 'PageNotFoundController';
        $requestData['requestedPage'] = 'pagenotfound';
        break;
}

//Run the middleware
$mwPass = true;
for ($i = 0; $i < count($middleware) && $mwPass; $i++) {
    echo ($middleware[$i]);
    $mwPass = $middleware[$i]::run($requestData);
}

//If all middleware gave their OK we can show the page!
if ($mwPass) {
    if($_SERVER['REQUEST_METHOD'] === 'POST')
        $controller::post();
    else
        $controller::get();
}