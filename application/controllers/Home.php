<?php
<<<<<<< HEAD

namespace App\Controllers;

class Home extends BaseController
{
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
=======
            defined('BASEPATH') OR exit('No direct script access allowed');
         class Home extends CI_Controller {
        public function index() {
    $this->load->view('template');
        }
    }
?>
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
