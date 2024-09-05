<?php

// In app/Http/Controllers/FeedbackController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.index'); // Create this view
    }
}
