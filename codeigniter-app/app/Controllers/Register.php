<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        return view('auth/register');
    }

    public function process()
    {
        // Validate form data
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'terms'      => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create new user
        $userModel = new UserModel();
        $user = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $userModel->insert($user);

        // Log the user in
        $session = session();
        $session->set('user_id', $userModel->getInsertID());
        $session->set('user_email', $user['email']);

        // Redirect to dashboard
        return redirect()->to('dashboard')->with('success', 'Registration successful! Welcome to FakeBook.');
    }
}
