<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session = session();
            $session->set('user_id', $user['id']);
            $session->set('user_email', $user['email']);
            return redirect()->to('dashboard')->with('success', 'Login successful!');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerPost()
    {
        // Implement registration logic here
        // For now, we'll just redirect to the login page
        return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
    }

    public function logout()
    {
        // Implement logout logic here
        return redirect()->to('/');
    }
}