<?php
/**
 *** Configurations ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

namespace Modules\AuthMe\Config;

use Codeigniter\Config\BaseConfig;

/**
 * Define all the configurations that will grant passage in checkpoints
 * ---DB Table attributes
 * ---Error Pages 
 * ---Success Pages
 * ---Session var name
 * 
 */
class Config extends BaseConfig {

    # Gate pass for auth access
    # This defines all the authentication constraints for login authentication eg. to login admin with email and password, to login user with username and pin
    # table = The database table you want your auth to query data from,  
    # public_key = This should be your public login info eg. email, username etc and should be named after the database column you are querying that info from.
    # private_key = This should be your private login info eg. password, pin etc and should be named after the database column you are querying that info from.
    # public $loginConstraints = [
    #   'admin' =>[
    #       'table'       => 'admin',
    #       'public_key'  =>  'email',
    #       'private_key' => 'pass',
    #   ],
    #
    #   'user' =>[
    #    'table'       => 'users',
    #    'public_key'  =>  'username',
    #    'private_key' => 'pin',
    #   ]  
    # ];
    # To query a particular record in DB(to set a login condition) eg. If a users account is active or not, DB column = is_active
    #  and its value for active account is 1, and 0 for inactive account. NOTE: using the above user login constraint
    #   'user' =>[
    #       'table'       => 'users',
    #       'public_key'  =>  'username',
    #       'private_key' => 'pin',
    #       '?is_active?'  => '1', DB column should be inbetween question mark
    #   ];
    public $loginConstraints = [
        'admin' =>[
            'table'       => 'admin',
            'public_key'  => 'email',
            'private_key' => 'pass',
            '?is_active?'     => '1',
        ], 
    ];



    # Languages used by this module
    # {value} in incorrect_pubKey & incorrect_pvtKey will be substituted with whatever is before the pipe symbol (|)
    public $langs = [
        'login' => [
            'error'             => 'An error occoured while trying to process your request<br>Please try again.',
            'incorrect_default' => 'The credentials submitted does not match our record.',
            'incorrect_pubKey'  => 'email address|The {value} you submitted does not match our record',
            'incorrect_pvtKey'  => 'password|The {value} you have entered is incorrect, Click on the forgot password link below to reset your password',
            'is_active'         => 'This account have not been activated, please do so and try again.',
            'successful_login'  => 'Login details correct, redirecting....',
        ],
    ];


    # Callbacks
    # Pages or function to call on success or error
    public $callbacks = [
        'login' => [
            'pages' => [
                'success' => 'successpage',
                'error'   => 'testlogin',
            ],


            'functions' => [
                'success'   => 'loginSuccessFunction',
                'error'     => 'loginErrorFunction',
            ],
        ],
    ];


    # Session data after successful login
    # The variable you want to hold session should be the key and session value should point to the db column you 
    # Default value is = auth_me_session_data
    public $sessionVar = 'auth_me_session_data';

}



    