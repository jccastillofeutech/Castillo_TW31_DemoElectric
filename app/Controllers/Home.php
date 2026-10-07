<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'PowerFlow Electric - Reliable Energy Solutions',
            'page' => 'home'
        ];
        return view('home', $data);
    }

    public function dashboard(): \CodeIgniter\HTTP\RedirectResponse
    {
        return redirect()->to('http://localhost/ci4_pagination/');
    }
}
