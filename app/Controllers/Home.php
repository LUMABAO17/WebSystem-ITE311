<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['content'] = view('home');
        return view('template', $data);
    }
}
