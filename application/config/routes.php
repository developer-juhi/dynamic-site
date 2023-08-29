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

$route['ar'] = 'user/UserController/index';
$route['contact-us-save'] = 'user/UserController/savecontact';


//custome route start User Side 

//custome route over User Slide


// ==================================================================================================
//custome route start Admin Side 

/* Admin Login start*/

$route['admin-login'] = 'admin/LoginController';
$route['login-check'] = 'admin/LoginController/loginCheck';
$route['admin-logout'] = 'admin/LoginController/logout';

/* Admin Login over */

/* Admin dashboard start */

$route['dashboard'] = 'admin/AdminController/index';

/* Admin dashboard over */



/* Admin About us */
$route['admin-aboutus-list'] = 'admin/AboutusController/list';
$route['admin-aboutus-register'] = 'admin/AboutusController/addAboutUs';
$route['admin-aboutus-register-save'] = 'admin/AboutusController/saveAboutUs';
$route['admin-aboutus-fetch'] = 'admin/AboutusController/dataAboutUs';
$route['admin-aboutus-delete'] = 'admin/AboutusController/deleteAboutUs'; 
$route['admin-aboutus-update?(.+)'] = 'admin/AboutusController/editAboutUs';
$route['aboutus-updated-save'] = 'admin/AboutusController/saveEditAboutUs';

//  admin about us over 
/* Admin service */ 
$route['admin-service-list'] = 'admin/ServiceController/list';
$route['admin-service-register'] = 'admin/ServiceController/addService';
$route['admin-service-register-save'] = 'admin/ServiceController/saveService';
$route['admin-service-fetch'] = 'admin/ServiceController/dataService';
$route['admin-service-delete'] = 'admin/ServiceController/deleteService'; 
$route['admin-service-update?(.+)'] = 'admin/ServiceController/editService';
$route['service-update-save'] = 'admin/ServiceController/saveEditService';
// admin Service Over 

/* Admin blog */ 
$route['admin-blog-list'] = 'admin/BlogController/list';
$route['admin-blog-register'] = 'admin/BlogController/addBlog';
$route['admin-blog-register-save'] = 'admin/BlogController/saveBlog';
$route['admin-blog-fetch'] = 'admin/BlogController/dataBlog';
$route['admin-blog-delete'] = 'admin/BlogController/deleteBlog'; 
$route['admin-blog-update?(.+)'] = 'admin/BlogController/editBlog';
$route['blog-update-save'] = 'admin/BlogController/saveEditBlog';
// admin Blog Over 

/* Admin service */ 
$route['admin-portfolio-list'] = 'admin/PortfolioController/list';
$route['admin-portfolio-register'] = 'admin/PortfolioController/addPortfolio';
$route['admin-portfolio-register-save'] = 'admin/PortfolioController/savePortfolio';
$route['admin-portfolio-fetch'] = 'admin/PortfolioController/dataPortfolio';
$route['admin-portfolio-delete'] = 'admin/PortfolioController/deletePortfolio'; 
$route['admin-portfolio-update?(.+)'] = 'admin/PortfolioController/editPortfolio';
$route['portfolio-update-save'] = 'admin/PortfolioController/saveEditPortfolio';
// admin Service Over 


/* Admin client */
$route['admin-client-list'] = 'admin/ClientController/list';
$route['admin-client-register'] = 'admin/ClientController/addClient';
$route['admin-client-register-save'] = 'admin/ClientController/saveClient';
$route['admin-client-fetch'] = 'admin/ClientController/dataClient';
$route['admin-client-delete'] = 'admin/ClientController/deleteClient'; 
$route['admin-client-update?(.+)'] = 'admin/ClientController/editClient';
$route['client-update-save'] = 'admin/ClientController/saveEditClient';
/* Admin client  Over */ 
$route['admin-contactus-list'] = 'admin/ContactusController/list';
$route['admin-inquiry-data'] = 'admin/ContactusController/dataContactus';

//custome route over Admin Slide
// ==================================================================================================


$route['default_controller'] = 'user/UserController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

