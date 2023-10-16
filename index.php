<?php

require_once './sys/autoload.php';

error_reporting(0);

Session::begin();

//Request processing
$request = Http::getRequestedPath();

//Route detection
$routes = require_once './routes.php';
$args = $foundRoute = null;
foreach ($routes as $route) {
	if ($route->isMatched($request, $args)) {
		$foundRoute = $route;
		break;
	}
}

//Instantiating the controller class
$className = $foundRoute->getController() . 'Controller';
$worker = new $className;

//Calling the __before method
if (method_exists($worker, '__pre')) {
	call_user_func([$worker, '__pre']);
}

//Calling the appropriate controller method
if (!method_exists($worker, $foundRoute->getMethod())) {
	ob_clean();
	die('CONTROLLER: Method not found.');
}
$methodName = $foundRoute->getMethod();
call_user_func_array([$worker, $methodName], $args);

//Calling the __post method
if (method_exists($worker, '__post')) {
	call_user_func([$worker, '__post']);
}

//Downloading global data
$DATA = $worker->getData();

//The Path to Templates
$headerView = './app/views/_global/header.php';
$footerView = './app/views/_global/footer.php';
$view = './app/views/' . $foundRoute->getController() . '/' . $foundRoute->getMethod() . '.php';

//Loading headers
if (!file_exists($headerView)) {
	ob_clean();
	die('VIEW: Header file not found.');
}

//Loading the main display template
if (!file_exists($view)) {
	ob_clean();
	die('VIEW: Main template file not found.');
}

//Loading footer
if (!file_exists($footerView)) {
	ob_clean();
	die('VIEW: Footer file not found.');
}

//Additional JavaScript module
$jsModule = sprintf('assets/js/modules/%s_%s.js', $foundRoute->getController(), $foundRoute->getMethod());
if (file_exists($jsModule)) {
	$DATA['JAVASCRIPT_MODULE'] = $jsModule;
}

require_once $headerView;
require_once $view;
require_once $footerView;
