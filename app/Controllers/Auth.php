<?php

namespace App\Controllers;

use App\Models\LoginUser;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLogged') === true) return redirect()->to(base_url('account-dashboard'));

        if ($this->request->getMethod() === 'POST') {
            $email = strtolower(trim((string) $this->request->getPost('email')));
            $password = (string) $this->request->getPost('password');
            $user = (new LoginUser())->where('username', $email)->first();

            if ($user === null || ! password_verify($password, (string) $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid email address or password.');
            }

            session()->regenerate(true);
            session()->set(['isLogged' => true, 'user_id' => (int) $user['id'], 'username' => $user['username']]);
            return redirect()->to(base_url('account-dashboard'));
        }

        return view('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url())->with('success', 'You have been logged out.');
    }
}
