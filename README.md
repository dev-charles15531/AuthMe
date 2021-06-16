# AuthMe
Lightweight & easy to use codeigniter 4 authentication module

![License](https://img.shields.io/github/license/dev-charles15531/AuthMe) ![version](https://img.shields.io/github/v/release/dev-charles15531/AuthMe) 

> This module let you perform login | logout authentication with custom configurations in your codeigniter 4 application.

## Features
- Swift login authentication based on configurations
- User defined login conditions (max: 3 conditions)
- User defined error messages
- Loging out functionality

## Requirements
- PHP 7.3+, 8.0+
- CodeIgniter 4.0.4+

## Installation 
 Download or clone this repository, edit app/Config/Autoload.php and add the Modules\AuthMe namespace to the $psr4 array. i.e, if this repo was downloaded in app/:
    ````php
    $psr4 = [
        'Config'      => APPPATH . 'Config',
        APP_NAMESPACE => APPPATH,
        'App'         => APPPATH,
        'Modules\AuthMe'  => APPPATH .'AuthMe/modules/Auth_me',
    ];
	````

## Configurations for use
 After successful installation, go to the AuthMe/modules/Auth_me/Config.php file, as thats where you all configurations for this module to 
 use will be saved. This class is already populated with configurations for running the test/example auth(More details about this below) and also serve as a guide to you when working with your own auth.
 - **$loginConstraints** 
	This contains multidimensional array of constraints you will want to use for login. eg: to log in users,
	````php
    'users' =>[
		'table'       => 'users_table',
		'public_key'  => 'email',
		'private_key' => 'pass',
		'?is_active?'     => '1',
    ], 
	````
	The above is the format of subarray the $loginConstraints holds. Where,<br/> 
	'users' is the name(any name can be used) holding the sub-configurations of who you want to login.<br/>
	'table' array key will have the value of the database table name of the users (this key & value is required).<br/>
	'public_key' array key will have the value of the table column name from which you want to query form public key (this key & value is required).<br/>
	'private_key' array key will have the value of the table column name from which you want to query form private key (this key & value is required).<br/>
	'?is_active?' array key(in between question marks) is a condition we are setting for login which should be the database column name where the condition should be checked <br/>
				  and its value must be the column value that satisfies that condition. You can set at most 3 login conditions and must be in the correct format just as you have seen above.<br/>
				  (this key and value is optional).<br/>
				  
	
	You can have more than one $loginConstraints, that means you can have for 'users', 'admin', 'moderators'...etc
	
- **$langs** 
   This contains multidimensional array of language each constraints will use for login. eg: to set languages for users,
	````php
    'users' => [
            'error'             => 'An error occoured while trying to process your request<br>Please try again.',
            'incorrect_default' => 'The credentials submitted does not match our record.',
            'incorrect_pubKey'  => 'email address|The {value} you submitted does not match our record',
            'incorrect_pvtKey'  => 'password|The {value} you have entered is incorrect, Click on the forgot password link below to reset your password',
            'is_active'         => 'This account have not been activated, please do so and try again.',
            'successful_login'  => 'Login details correct, redirecting....',
        ],
	````
	The above is the format of subarray the $langs holds. Where, <br/>
	'users' is the name of the specific login constraint you're setting the languages for.<br/>
	'error' array key will have the value of the error message to display if form http request is not post(this key & value is required).<br/>
	'incorrect_default' array key will have the value of the default error message to display if that of public and private key is not set(this key is required but value can be empty).<br/>
	'incorrect_pubKey' array key will have the value of the error message to display if submitted public key dosent match what's in the database record(this key is required but value can be empty).<br/>
	'incorrect_pvtKey' array key will have the value of the error message to display if submitted private key dosent match what's in the database record(this key is required but value can be empty).<br/>
	'is_active' array key which must bear similar name(without question marks) as its login condition key name in the above login constraint will have the value of the error message to display if the login condition fails(this key & value is required if its login condition is set above).<br/>
	'successful_login' array key will have the value of the success message to display if login was successful (this key is required but value can be empty).<br/>
	***Note:*** the {value} seen in 'incorrect_pubKey' & 'incorrect_pvtKey' will be replaced by whatever is before the pipe sign(|) when the message is displayed.
	
- **$callbacks** 
   This contains multidimensional array of callbacks each constraints will use for login. eg: to set callbacks for users,
	````php
    'users' => [
		'pages' => [
			'success' => 'loginsuccesspage',
			'error'   => 'login',
		],


		'functions' => [
			'success'   => 'loginSuccessFunction',
			'error'     => 'loginErrorFunction',
		],
	],
	````
	The above is the format of subarray the $callbacks holds. Where, <br/>
	'users' is the name of the specific login constraint you're setting the callbacks for.<br/>
	'pages' array key is another array with 'success' and 'error' which holds the value of success and error pages your auth will redirect to on auth-error or auth-success(values for 'error' and 'success' key can be left empty).<br/>
	'functions' array key is another array with 'success' and 'error' which holds the value of success and error functions your auth will call on auth-error or auth-success(values for 'error' and 'success' key can be left empty).<br/>
				this function success and error value must be registered as an event in AuthMe/modules/Auth_me/Config/Events.php.<br/>
				
- **$logout** 
   This contains multidimensional array of actions each constraints will use for logout. eg: for users logout,
	````php
    'users' => [
		'page' => [
			'success' => 'login',
		],


		'function' => [
			'success'   => 'logoutSuccessFunction',
		],
	],
	````
	The above is the format of subarray the $logout holds. Where, <br/>
	'users' is the name of the specific login constraint you're setting the logout action for.<br/>
	'page' array key is another array with 'success' which holds the value of success pages your auth will redirect to on logout (value for 'success' key can be left empty).<br/>
	'function' array key is another array with 'success' which holds value of the function your auth will call on logout(value for 'success' key can be left empty).<br/>
				this function success value must be registered as an event in AuthMe/modules/Auth_me/Config/Events.php.<br/>

- **$sessionVar** 
   This contains keys and values of session variable name each constraints will use on successful login. eg: for users login,
	````php
    'users' => 'users_data'
	````
	The above is the format of keys and values $sessionVar holds. Where, <br/>
	'users' array key is the name of the specific login constraint you're setting the session variable for which holds the session variable name($users_data in this case).<br/>
	***Note:*** the session data created is the value of the login public_key so your public_key must be unique.<br/>
	
## Usage
 When you are through with all configurations, your login form should look like this:
 ````html
	<?php if(session()->getTempdata('error')): ?>
	<div class="form-notify-error">
		<span class="error-text info-text text-sm">
			<?= session()->getTempdata('error') ?>
		</span>
	</div><br>
	<?php elseif(session()->getTempdata('incorrect')): ?>
	<div class="form-notify-error">
		<span class="error-text info-text text-sm">
			<?= session()->getTempdata('incorrect') ?>
		</span>
	</div><br>
	<?php endif; ?>

	<br><br>
	<form action="<?= base_url() ?>/auth-secure/login/users" method="post">
		<input type="email" name="public_key" id="" placeholder="Enter email">
		<input type="password" name="private_key" id="" placeholder="Enter password">

		<br><br>
		<input type="submit" value="log in">
	</form>
 ````
 ***Note:*** 
 - Your login action should submit to the url <?= base_url() ?>/auth-secure/login/users
   where the third URI 'users' shoul be the login constraint you previously configured in your configuration class.
 - Form errors are set in codeigniter's session tmp data as session()->getTempdata('error') and session()->getTempdata('incorrect').
 
## Update
 The next version currently under development will include forgot password, reset password and change password flow.

##  License
- **AuthMe** is released under the [MIT License](https://github.com/dev-charles15531/AuthMe/blob/master/LICENSE).

Created by **[Charles Paul](https://github.com/dev-charles15531)** 