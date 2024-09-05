<?php

// In app/Http/Controllers/TrendingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrendingController extends Controller
{
    public function index()
    {
        return view('trending.index'); // Create this view
    }
}
