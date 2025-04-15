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

    // Menampilkan daftar semua user (khusus HRD)
    public function index()
    {
        requireLogin();

        if (hrdRole()) {
            $data['users'] = $this->userModel->findAll();
            return view('Account/index', $data);
        }

        return redirect()->route('/');
    }
    public function createForm()
    {
        requireLogin();
    
        if (hrdRole()) {
            return view('Account/create');
        }
    
        return redirect()->route('/');
    }
    
    public function store()
    {
        requireLogin();
    
        if (hrdRole()) {
            if ($this->request->getMethod() === 'post') {
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'name' => 'required|min_length[3]|max_length[50]',
                    'email' => 'required|valid_email|is_unique[users.email]',
                    'password' => 'required|min_length[6]',
                ]);
    
                if (!$validation->withRequest($this->request)->run()) {
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }
    
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];
    
                if ($this->userModel->save($data)) {
                    return redirect()->to('/users')->with('success', 'User created successfully.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Failed to save user.');
                }
            }
        }
    
        return redirect()->route('/');
    }
    // Menampilkan form edit user
    public function edit($id)
    {
        requireLogin();

        if (hrdRole()) {
            $user = $this->userModel->find($id);

            if (!$user) {
                return redirect()->to('/users')->with('error', 'User not found.');
            }

            return view('Account/edit', ['user' => $user]);
        }

        return redirect()->route('/');
    }

    // Menyimpan update data user
    public function update($id)
    {
        requireLogin();

        if (hrdRole()) {
            if ($this->request->getMethod() === 'post') {
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'name' => 'required|min_length[3]|max_length[50]',
                    'email' => 'required|valid_email',
                    'password' => 'permit_empty|min_length[6]',
                ]);

                if (!$validation->withRequest($this->request)->run()) {
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }

                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                ];

                if ($this->request->getPost('password')) {
                    $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }

                $this->userModel->update($id, $data);

                return redirect()->to('/users')->with('success', 'User updated successfully.');
            }
        }

        return redirect()->route('/');
    }

    // Menghapus user
    public function delete($id)
    {
        requireLogin();

        if (hrdRole()) {
            $user = $this->userModel->find($id);

            if (!$user) {
                return redirect()->to('/users')->with('error', 'User not found.');
            }

            $this->userModel->delete($id);

            return redirect()->to('/users')->with('success', 'User deleted successfully.');
        }

        return redirect()->route('/');
    }
}
