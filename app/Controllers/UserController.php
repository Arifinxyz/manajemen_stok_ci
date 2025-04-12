<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        requireLogin();

        if (hrdRole()) {
           $data['users'] = $this->userModel->findAll();
           return view('Acount/index', $data);
        } else {
            return redirect('')->route();
        }
        
    }

    public function create()
    {
        requireLogin();

        if (hrdRole()) {
            if ($this->request->getMethod() === 'post') {
                $this->userModel->save([
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ]);
                return redirect()->to('/users');
            }
            return view('Acount/create');
        }  else {
            return redirect('')->route();
        }
      
    }

    public function edit($id)
    {
        requireLogin();

        if (hrdRole()) {
            $data['user'] = $this->userModel->find($id);
            return view('Acount/edit', $data);
        } else {
            return redirect('')->route();
        }

       
    }

    public function update($id)
    {
        requireLogin();
        if (hrdRole()) {
            if ($this->request->getMethod() === 'post') {
                $this->userModel->update($id, [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ]);
                return redirect()->to('/users');
            }
        } else {
            return redirect('')->route();
        }
       
    }

    public function delete($id)
    {
        requireLogin();
        if (hrdRole()) {
            $this->userModel->delete($id);
                return redirect()->to('/users');
        } else {
            return redirect('')->route();
        }
        
    }
}