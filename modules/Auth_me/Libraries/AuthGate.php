<?php
/**
 *** AuthGate ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

 namespace Modules\AuthMe\Libraries;


class AuthGate {
    
    /**
     * @desc - This method serves as a gate between the users controller and this module to access the authentication services
     * @param String $authType - The type of authentication request coming in eg. login, logout, forgot password
     * @param String $passer - The passer constraint to consider for the auth as set in config class
     */
    public function penetrate(String $authType, String $passer = null)
    {
        switch ($authType) {
            # If the request coming in is for login
            case 'login':
                # Load config and get default passer {to be used if $passer arg is not set}
                $config = Config('Config');
                $default_passer = array_key_first($config->loginConstraints);

                # Set passer objet {default value is the first key of the loginConstraints array in the config class}
                $passer = ($passer == null)? $default_passer : $passer;

                # Load session service and store passer as tmp session
                $session = \Config\Services::session();
			    $session->set('authMePasser', $passer);
                
                # Call the login event
                \Codeigniter\Events\Events::trigger('authLogin');
                
                break;
            
            default:
                # If $authType value is invalid
                throw new \InvalidArgumentException("Invalid agrument passed to penetrate() method.");
                break;
        }
    }


}