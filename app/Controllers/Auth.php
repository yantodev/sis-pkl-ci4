<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Model;

class Auth extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => "login page",
            'data' => $this->usersModel->findAll()
        ];
        return view('auth/index', $data);
    }

    public function register()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $session = session();
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[6]|max_length[200]'
        ];

        if ($this->validate($rules)) {
            $data = [
                'role_id' => $this->request->getVar('role'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'image' => "default.png"
            ];
            $this->usersModel->save($data);
            $session->setFlashdata('success', 'Register successfull!!!');
            return redirect()->to('/auth');
        } else {
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }

    public function login()
    {
        $session = session();
        $model = new UsersModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role_id' => $data['role_id'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                $session->setFlashdata('login', $data['name']);
                // if ($data['role_id'] == 3)
                return redirect()->to('/admin');
                // return redirect()->to('/auth');
            } else {
                $session->setFlashdata('error', 'Password salah!!!');
                return redirect()->to('/auth');
            }
        } else {
            $session->setFlashdata('warning', 'Email tidak ditemukan!!!');
            return redirect()->to('/auth');
        }
    }
    public function logout()
    {
        $session = session();
        $session->setFlashdata('success', 'Logout berhasil!!!');
        $session->destroy();
        return redirect()->to('/auth');
    }
}