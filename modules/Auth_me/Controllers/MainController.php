<?php
/**
 *** MainController ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

namespace Modules\AuthMe\Controllers;

use Modules\AuthMe\Libraries\AuthGate;
use CodeIgniter\Controller;

class MainController extends Controller
{
	/**
	 * @desc - Our login form directly calls this method.
	 * 		   request type and form inputs are collected and stored in a temporary session for later use by processor class
	 * 		   Login begins processing by AuthGate library [Authentication genesis]
	 */
	public function login()
	{
		helper(['session']);	// Session helper
        $session = \Config\Services::session();	// Load session service.

		# Array to hold request method and post data <if any>
		# Set the array in the temporary session
		$authMeData = [
			'public'	=> $this->request->getVar('public_key'),
			'private'	=> $this->request->getVar('private_key'),
			'method'	=> $this->request->getMethod(),
		];
		$session->set($authMeData);

		# Load AuthGate library and call its penetrate method for login
		$Auth = new AuthGate();
		$Auth->penetrate('login');
	}

	

}
