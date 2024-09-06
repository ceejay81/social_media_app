<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        // Make sure user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        // Load the dashboard view
        return view('dashboard');
    }
}
