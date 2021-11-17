<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//Codeigniter default routes
$route['default_controller'] = 'page';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

//Login Controller
$route['login'] = 'User Service/login';
$route['login/(:any)'] = 'User Service/login/$1';
$route['login/(:any)/(:any)'] = 'User Service/login/$1/$2';
//Register Controller
$route['register'] = 'User Service/register';
$route['register/(:any)'] = 'User Service/register/$1';
$route['register/(:any)/(:any)'] = 'User Service/register/$1/$2';
//Admin Controller
$route['admin'] = 'User Service/admin';
$route['admin/(:any)'] = 'User Service/admin/$1';
$route['admin/(:any)/(:any)'] = 'User Service/admin/$1/$2';
//Profile Controller
$route['profile'] = 'User Service/profile';
$route['profile/(:any)'] = 'User Service/profile/$1';
$route['profile/(:any)/(:any)'] = 'User Service/profile/$1/$2';
//Goods Controller
$route['goods'] = 'Goods Service/goods';
$route['goods/(:any)'] = 'Goods Service/goods/$1';
$route['goods/(:any)/(:any)'] = 'Goods Service/goods/$1/$2';
//Pharma Controller
$route['pharma'] = 'Pharma Service/pharma';
$route['pharma/(:any)'] = 'Pharma Service/pharma/$1';
$route['pharma/(:any)/(:any)'] = 'Pharma Service/pharma/$1/$2';
//Foods Controller
$route['foods'] = 'Foods Service/foods';
$route['foods/(:any)'] = 'Foods Service/foods/$1';
$route['foods/(:any)/(:any)'] = 'Foods Service/foods/$1/$2';
//Pets Controller
$route['pet'] = 'Pet Service/pet';
$route['pet/(:any)'] = 'Pet Service/pet/$1';
$route['pet/(:any)/(:any)'] = 'Pet Service/pet/$1/$2';
//Payment Controller
$route['payment'] = 'Payments Service/payment';
$route['payment/(:any)'] = 'Payments Service/payment/$1';
$route['payment/(:any)/(:any)'] = 'Payments Service/payment/$1/$2';
//Tracking Controller
$route['tracking'] = 'Tracking Service/tracking';
$route['tracking/(:any)'] = 'Tracking Service/tracking/$1';
$route['tracking/(:any)/(:any)'] = 'Tracking Service/tracking/$1/$2';
//Order Controller
$route['order'] = 'User Service/order';
$route['order/(:any)'] = 'User Service/order/$1';
$route['order/(:any)/(:any)'] = 'User Service/order/$1/$2';
$route['order/(:any)/(:any)/(:any)'] = 'User Service/order/$1/$2/$3';
$route['order/(:any)/(:any)/(:any)/(:any)'] = 'User Service/order/$1/$2/$3/$4';

//Crud Test
$route['crud'] = 'Crud Service/crud';
$route['crud/(:any)'] = 'Crud Service/crud/$1';
$route['crud/(:any)/(:any)'] = 'Crud Service/crud/$1/$2';