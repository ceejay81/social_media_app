<?php

// In app/Http/Controllers/HelpController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('help.index'); // Create this view
    }
}
