<?php

namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('login');
        }

        // Fetch user data
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        $data = [
            'user' => $user,
            'success' => session()->getFlashdata('success')
        ];

        return view('dashboard', $data);
    }

    public function profile()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        $data = [
            'user' => $user,
        ];

        return view('profile_edit', $data);
    }

    public function updateProfile()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        if (!$user) {
            return redirect()->to('login')->with('error', 'User not found. Please login again.');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'email'      => 'required|valid_email',
            'bio'        => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $newData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'bio'        => $this->request->getPost('bio'),
        ];

        // Handle profile picture upload
        $profilePic = $this->request->getFile('profile_picture');
        if ($profilePic->isValid() && !$profilePic->hasMoved()) {
            $newFileName = $profilePic->getRandomName();
            $profilePic->move(FCPATH . 'uploads', $newFileName);
            $newData['profile_picture'] = $newFileName;
        }

        // Handle background picture upload
        $backgroundPic = $this->request->getFile('background_picture');
        if ($backgroundPic->isValid() && !$backgroundPic->hasMoved()) {
            $newFileName = $backgroundPic->getRandomName();
            $backgroundPic->move(FCPATH . 'uploads', $newFileName);
            $newData['background_picture'] = $newFileName;
        }

        $userModel->update($user['id'], $newData);

        return redirect()->to('profile')->with('success', 'Profile updated successfully');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('login')->with('success', 'You have been successfully logged out.');
    }
}
