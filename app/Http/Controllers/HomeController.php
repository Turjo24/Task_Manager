<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return "Welcome to Laravel Bootcamp 🚀";
    }

    public function about()
    {
        return "About Us";
    }

    public function contact()
    {
        return "Contact Us";
    }
}