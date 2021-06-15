<?php
/**
 *** Events ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use Modules\AuthMe\Controllers\Checkpoints;
use Modules\AuthMe\Controllers\Processor;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

#~~~~~~~~~~~~~~~~~~~~~AUTH & AUTH RELATED EVENTS~~~~~~~~~~~~~~~~~~~~~~~~~~~~~#
 	# Login Event Registerer
	$Login = new Checkpoints;
	Events::on('authLogin', [$Login, 'login']);

	# Login Processor Event Registerer
	$processLogin = new Processor;
	Events::on('processLogin', [$processLogin, 'processLogin']);

	# Logout Processor Event Register
	$processLogout = new Processor;
	Events::on('processLogout', [$processLogin, 'processLogout']);



#~~~~~~~~~~~~~~~AUTH SUCCESS & AUTH ERROR CALLBACK FUNCTIONS~~~~~~~~~~~~~~~~~~~#
# Assign all success and error callback function here as defined in your config folder
/**
 * Events::on('loginSuccessFunction', [new App\Controllers\PostLogin, 'registerLoginTime']);
 */