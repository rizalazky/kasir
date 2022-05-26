<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if user not logged in
        if(empty(session()->get('username'))){
        // then redirct to login page
        return redirect()->to('/admin/login'); 
    }
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    // Do something here
    }
}