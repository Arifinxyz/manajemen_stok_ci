<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function index()
    {
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();
    
        return view('Account/index', ['users' => $users]);
    }

    public function create()
    {
        return view('Account/create');
    }

    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[petugas,hrd,pabrik]'
        ])) {
            return redirect()->to('/user/create')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data inputan
        $userModel = new UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT), // Hash password
            'role' => $this->request->getPost('role')
        ];

        // Simpan data user ke database
        $userModel->save($data);

        return redirect()->to('/user/create')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
{
    $userModel = new UserModel();
    $user = $userModel->find($id);

    if (!$user) {
        return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
    }

    return view('Account/edit', ['user' => $user]);
}

public function delete($id)
{
    $userModel = new UserModel();
    $userModel->delete($id);

    return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
}


}
