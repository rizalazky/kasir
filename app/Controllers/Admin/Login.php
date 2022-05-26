<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('admin/login');
    }

    public function login(){
        $session = session();
        $model = new UserModel();
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => ['label'=>'Userame','rules'=>'required'],
            'password' => ['label'=>'Password','rules'=>'required']
        ]);
        $response=[
            "status" => false,
            "message" => "The Username or Password is incorrect"
        ];
        $isDataValid = $validation->withRequest($this->request)->run();
        if($isDataValid){

            
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");
            $data = $model->where('username', $username)->first();
            if($data){
                $pass = $data['password'];
                $verify_pass = password_verify($password, $pass);
                if($verify_pass){
                    $ses_data = [
                        'id'       => $data['id'],
                        'username'     => $data['username'],
                        'name'    => $data['name'],
                        'adress'     => $data['adress']
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/admin');
                }else{
                    $session->setFlashdata('msg', 'Wrong Password');
                    return redirect()->to('admin/login');
                }
            }else{
                $session->setFlashdata('msg', 'Username not Found');
                return redirect()->to('/admin/login');
            }
           
        }else{
            $session->setFlashdata('msg', implode("<br/>",$validation->getErrors()));
            return redirect()->to('/admin/login');
        }
    }


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/admin/login');
    }

}
