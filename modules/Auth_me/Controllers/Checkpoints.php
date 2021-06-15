<?php
/**
 *** Checkpoint ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

namespace Modules\AuthMe\Controllers;
use CodeIgniter\Controller;

/**
 * Just like normal millitary checkpoints, all credentials are validated(available | correct format) here.
 * If cleared, passage is allowed and login process begins. Else, throws error
 */
class Checkpoints extends Controller
{
    private $credentials;

    function __construct() {
        # Load cofigurations ...
        $this->credentials = Config('Config');
    }
	
    /**
     * For login request clarification (Check if all conditions necessary for login authentication is met)
     */
    public function login()
    {
        # Check each constraint provided in config 
        foreach ($this->credentials->loginConstraints as $passer => $value) {
            
            # Validate login constraints {table, public_key and private_key}
            $table = $this->credentials->loginConstraints[$passer]['table'];
            $pub_key = $this->credentials->loginConstraints[$passer]['public_key'];
            $pvt_key = $this->credentials->loginConstraints[$passer]['private_key'];

            if(empty($table) || !isset($table)) 
                throw new \UnexpectedValueException('table value for '.$passer.' constraint not recognized');
            if(empty($pub_key) || !isset($pub_key))
                throw new \UnexpectedValueException('public_key value for '.$passer.' constraint not recognized');
            if(empty($pub_key) || !isset($pub_key)) 
                throw new \UnexpectedValueException('private_key value for '.$passer.' constraint not recognized');
        }
        
        # Call login processor event
        \Codeigniter\Events\Events::trigger('processLogin');
    }

}
