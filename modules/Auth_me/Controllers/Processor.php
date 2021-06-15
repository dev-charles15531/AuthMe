<?php
/**
 *** Processor ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

namespace Modules\AuthMe\Controllers;
use CodeIgniter\Controller;
use Modules\AuthMe\Models\CustomModel;
use Modules\AuthMe\Controllers\Actions;


/**
 * This class processes the request, queries post data and execute callbacks.
 */
class Processor extends Controller
{
    private $session;
    protected $response;
    private $config;
    private $custom_model;
    private $action;

	function __construct() {
        helper(['url', 'session']);
        $this->session = \Config\Services::session();
        $this->response = \Config\Services::response();
        $this->config = Config('Config');
        $this->custom_model = new CustomModel();
        $this->action = new Actions();
    }

    /**
     * Process login request
     */
    public function processLogin()
    {
        # Get request data saved in tmp session
        $public_key = $this->session->get('public');
        $private_key = $this->session->get('private');
        $requestMethod = $this->session->get('method');
        # Delete this tmp session data
        $authMeData = ['public', 'private', 'method'];
		$this->session->remove($authMeData);

        # If the request which submitted the login form is a post request
        if($requestMethod != 'post') {
			 # Error message if request is not coming from 'post' method
             $this->session->setTempdata('error', $this->action->getErrorMssg(), 3);
		}

		# Validate in our custom model
		$loginator = $this->custom_model->can_login($public_key, $private_key, $this->action->getLoginCondition());
		if($loginator == 1) {
			# Invalid public key

			$this->session->setTempdata('error', $this->action->getInvalidKeyMssg('public'), 3);

            # callback function on error
            if (!empty($this->action->getLoignErrorFunction())) {
                \Codeigniter\Events\Events::trigger($this->action->getLoignErrorFunction());
            }
            # callback page on error
            if (!empty($this->action->getLoignErrorPage())) {
                $this->response->redirect(site_url($this->action->getLoignErrorPage()));
            }
		}
		elseif($loginator == 2) {
			# Invalid private key

			$this->session->setTempdata('error', $this->action->getInvalidKeyMssg('private'), 3);

            # callback function on error
            if (!empty($this->action->getLoignErrorFunction())) {
                \Codeigniter\Events\Events::trigger($this->action->getLoignErrorFunction());
            }
            # callback page on error
            if (!empty($this->action->getLoignErrorPage())) {
                $this->response->redirect(site_url($this->action->getLoignErrorPage()));
            }
		}
		elseif($loginator == 10) {
			# If the first login condition is set and not met

			$this->session->setTempdata('error', $this->action->getLoginConditionError(0), 3);

            # callback function on error
            if (!empty($this->action->getLoignErrorFunction())) {
                \Codeigniter\Events\Events::trigger($this->action->getLoignErrorFunction());
            }
            # callback page on error
            if (!empty($this->action->getLoignErrorPage())) {
                $this->response->redirect(site_url($this->action->getLoignErrorPage()));
            }
		}
        elseif($loginator == 11) {
			# If the second login condition is set and not met

            $this->session->setTempdata('error', $this->action->getLoginConditionError(1), 3);

            # callback function on error
            if (!empty($this->action->getLoignErrorFunction())) {
                \Codeigniter\Events\Events::trigger($this->action->getLoignErrorFunction());
            }
            # callback page on error
            if (!empty($this->action->getLoignErrorPage())) {
                $this->response->redirect(site_url($this->action->getLoignErrorPage()));
            }
		}
        elseif($loginator == 12) {
			# If the third login condition is set and not met

            $this->session->setTempdata('error', $this->action->getLoginConditionError(2), 3);

            # callback function on error
            if (!empty($this->action->getLoignErrorFunction())) {
                \Codeigniter\Events\Events::trigger($this->action->getLoignErrorFunction());
            }
            # callback page on error
            if (!empty($this->action->getLoignErrorPage())) {
                $this->response->redirect(site_url($this->action->getLoignErrorPage()));
            }
		}
		elseif($loginator == 0) {
			# Login Successfull
            
            $this->session->setTempdata('success', $this->action->getLoginSuccessMssg(), 3);

			$this->session->set($this->action->getSessionVar(), $public_key); // Set auth passer session
			# callback function on success
            if (!empty($this->action->getLoignSuccessFunction())) {
                \Codeigniter\Events\Events::trigger($this->action->getLoignSuccessFunction());
            }
            # callback page on success
            if (!empty($this->action->getLoignSuccessPage())) {
                $this->response->redirect(site_url($this->action->getLoignSuccessPage()));
            }
		}   
    }



    /**
     * Process logout request
     */
    public function processLogout()
    {
        $this->session->remove($this->action->getSessionVar());  //Remove session data
        # logout function on success
        if (!empty($this->action->getLogoutSuccessFunction())) {
            \Codeigniter\Events\Events::trigger($this->action->getLogoutSuccessFunction());
        }
        # logout page on success
        if (!empty($this->action->getLogoutSuccessPage())) {
            $this->response->redirect(site_url($this->action->getLogoutSuccessPage()));
        }

        $this->session->remove('authMePasser');  //Remove tmp session
    }
}
