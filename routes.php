<?php

return [
	//Home controller
	new Route('Home', 'index', '|^/?$|'),
	new Route('Home', 'login', '|^login/?$|'),
	new Route('Home', 'logout', '|^logout/?$|'),
	//Task controller
	new Route('Task', 'index', '|^tasks/?$|'),
	new Route('Task', 'create', '|^tasks/create/?$|'),
	new Route('Task', 'update', '|^tasks/update/([0-9]+)/?$|'),
	new Route('Task', 'delete', '|^tasks/delete/([0-9]+)/?$|'),
	//Task api controller
	new Route('TaskApi', 'index', '|^api/tasks/?$|'),
	//Default route
	new Route('Home', 'e404', '|^.*$|'),
];
