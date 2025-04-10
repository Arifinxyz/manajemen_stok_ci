<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('name', value: $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'name'   => $user['name'],
                'role'       => $user['role'],
            ]);

            // Redirect berdasarkan role

                    return redirect()->to('/');
            
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}