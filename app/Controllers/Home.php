<?php

namespace App\Controllers;

class Home extends BaseController
{
<<<<<<< HEAD
    public function __construct()
    {
        helper('url'); 
    }

=======
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
    public function index(): string
    {
        return view('index');
    }

    public function about(): string
    {
        return view('about');
    }

    public function contact(): string
    {
        return view('contact');
    }
}
