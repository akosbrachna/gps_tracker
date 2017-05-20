<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller']     = 'authorization/login/sign_in';
$route['password_reset']         = 'authorization/reset_account/forgot_password';
$route['change_password/(:any)'] = 'authorization/reset_account/reset_password/$1';
$route['register']               = 'users/user/register';
$route['signup']                 = 'authorization/registration/register';
$route['confirm/(:any)']         = 'authorization/registration/confirm/$1';
$route['phone']                  = 'phone/main_phone/index';
$route['404_override'] = '';
