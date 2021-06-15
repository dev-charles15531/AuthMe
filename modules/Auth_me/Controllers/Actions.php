<?php
/**
 *** Actions ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

namespace Modules\AuthMe\Controllers;
use CodeIgniter\Controller;

/**
 * This class handles processor actions {redirection pages, messages, callback functions}.
 */
class Actions extends Controller
{
    private $session;
    private $config;

	function __construct() {
        helper(['url', 'session']);
        $this->session = \Config\Services::session();
        $this->config = Config('Config');
    }


    /**
     * @desc - Error message to display if an error occours with request
     *         Most times, this error is shown if the request submitting the form for authentication is not a post request
     * @return String - The error message
     * @throws UnexpectedValueException - If the error message is not set in our config class
     */
    public function getErrorMssg()
    {
        $mssg = $this->config->langs[$this->session->get('authMePasser')]['error'];
        # Check if the error message is set in config
        if (!empty($mssg)) {
            return $mssg;
        }
        else {
            throw new \UnexpectedValueException('empty page value for '.$this->session->get('authMePasser').' callback. Please check your config settings');
        }
        
    }


     /**
     * @desc - Error message to display if key is incorrect
     *         This error is shown if the key submitted dosen't match the database record
     *         The messages are saved in our config class
     * @param String $key - The specific key(private or public) error message you want to call. Returns the default message if nothing is set.
     * @return String - The error message
     * @throws UnexpectedValueException - If the default error message and the specific key error message is not set in our config class
     * @throws InvalidArgumentException - If the argument provided is not = public or private
     */
    public function getInvalidKeyMssg(String $key)
    {
        $defaultMssg = $this->config->langs[$this->session->get('authMePasser')]['incorrect_default'];
        $publicKeyMssg = $this->config->langs[$this->session->get('authMePasser')]['incorrect_pubKey'];
        $privateKeyMssg = $this->config->langs[$this->session->get('authMePasser')]['incorrect_pvtKey'];

        # if values are not set in our config class
        if (empty($defaultMssg) && (empty($publicKeyMssg) || empty($privateKeyMssg))) {
            throw new \UnexpectedValueException('Please set the default error message or one of the specific key error message.');
        }
        # if the argument provided is != private or public
        if($key != 'public' && $key != 'private') {
            throw new \InvalidArgumentException('invalid argument passed to the getInvalidKeyMssg() method.');
        }    
        # if the argument = public, 
        if($key == 'public') {
            if (!empty($publicKeyMssg)) {
                $coded_mssg = explode("|", $publicKeyMssg);
                $mssg = $coded_mssg[1];
                $mssg_f = str_replace('{value}', $coded_mssg[0], $mssg);
                return $mssg_f;
            }
            return $defaultMssg;
        }

        # if the argument = private, 
        if($key == 'private') {
            if (!empty($privateKeyMssg)) {
                $coded_mssg = explode("|", $privateKeyMssg);
                $mssg = $coded_mssg[1];
                $mssg_f = str_replace('{value}', $coded_mssg[0], $mssg);
                return $mssg_f;
            }
            return $defaultMssg;
        }      
    }


    /**
     * @desc - This method returns in string format, the current passer error page
     * @return String - The current passer error page
     */
    public function getLoignErrorPage()
    {
        return $this->config->callbacks[$this->session->get('authMePasser')]['pages']['error'];
    }


    /**
     * @desc - This method returns in string format, the current passer error function
     * @return String - The current passer error function
     */
    public function getLoignErrorFunction()
    {
        return $this->config->callbacks[$this->session->get('authMePasser')]['functions']['error'];
    }


    /**
     * @desc - This method returns in string format, the current passer success page
     * @return String - The current passer success page
     */
    public function getLoignSuccessPage()
    {
        return $this->config->callbacks[$this->session->get('authMePasser')]['pages']['success'];
    }


    /**
     * @desc - This method returns in string format, the current passer error function
     * @return String - The current passer success function
     */
    public function getLoignSuccessFunction()
    {
        return $this->config->callbacks[$this->session->get('authMePasser')]['functions']['success'];
    }


    /**
     * @desc - This method returns in string format, the session variable name
     * @return String - The variable to hold session data
     * @throws UnexpectedValueException - If the session variable name is not set in our config class
     */
    public function getSessionVar()
    {
        $sess_var = $this->config->sessionVar[$this->session->get('authMePasser')];
        # Check if the error message is set in config
        if (!empty($sess_var)) {
            return $sess_var;
        }
        else {
            throw new \UnexpectedValueException('empty session variable value for '.$this->session->get('authMePasser').'. Please check your config settings');
        }
    }


    /**
     * @desc - This method returns the login conditions eg. if account is active or not
     * @return array - The login conditions(array key for db column, array value for condition satisfied value) as set in our Config class
     */
    public function getLoginCondition()
    {
        # Get login constraints for current passer
        $constraints = $this->config->loginConstraints[$this->session->get('authMePasser')];

        # Array to hold conditions column as set in our Config class
        $conditions = [];
        foreach ($constraints as $key => $value) {
            # Remove the question mark at the begining and end of the condition column and push to the above initialized array
            if ($key[0] == '?' && $key[strlen($key)-1] == '?') {
               $conditions += [substr($key, 1, -1) => $value];
            }
        }

        return $conditions;
    }


    /**
     * @desc - This method returns the error message on a particular login condition on faliure 
     * @return String - The error message
     */
    public function getLoginConditionError(int $index)
    {
        $keys = array_keys($this->getLoginCondition());
        $selected_key = $keys[$index];
        $error_lang = $this->config->langs[$this->session->get('authMePasser')][$selected_key];
        return $error_lang;
    }


    /**
     * @desc - This method returns the success message if a particular login request is successful
     * @return String - The success message
     */
    public function getLoginSuccessMssg()
    {
        $mssg = $this->config->langs[$this->session->get('authMePasser')]['successful_login'];
        # Check if the error message is set in config
        if (!empty($mssg)) {
            return $mssg;
        }
        #else {
        #    throw new \UnexpectedValueException('empty value for login success messgae. Please check your config settings');
        #}
    }


    /**
     * @desc - This method returns in string format, the current passer success page on logout
     * @return String - The current passer success page on logout
     */
    public function getLogoutSuccessPage()
    {
        return $this->config->logout[$this->session->get('authMePasser')]['page']['success'];
    }


    /**
     * @desc - This method returns in string format, the current passer on logout function
     * @return String - The current passer function on logout
     */
    public function getLogoutSuccessFunction()
    {
        return $this->config->logout[$this->session->get('authMePasser')]['function']['success'];
    }


}
