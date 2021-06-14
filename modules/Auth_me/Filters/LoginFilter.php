<?php 

namespace Modules\Admin\Filters;

use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments=NULL)
    {
        // Load Session Library
		$session = \Config\Services::session();
        # Get Called Page Url
        $uri = uri_string();
        # Set to temporary session :(
        $session->set('uri', $uri);
        # Redirect Not Logged In User To Login Page
        $x = session('admin_data');
		if(! isset($x)) {
            return redirect()->to(site_url('admin-secure/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments=NULL)
    {
        # code...
    }
}


