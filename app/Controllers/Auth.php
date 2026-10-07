<?php

namespace App\Controllers;

use App\Models\LoginUser;
use App\Models\User;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLogged') === true) return redirect()->to(base_url('account-dashboard'));

        if ($this->request->getMethod() === 'POST') {
            $email = strtolower(trim((string) $this->request->getPost('email')));
            $password = (string) $this->request->getPost('password');

            try {
                // Registration stores the canonical account in `users`.
                // Keep the legacy login table as a fallback for existing data.
                try {
                    $user = (new User())->where('email', $email)->first();
                } catch (\Throwable $exception) {
                    // A legacy deployment may not have the unified users table.
                    $user = null;
                }

                if ($user === null) {
                    $user = (new LoginUser())->where('username', $email)->first();
                }

                if ($user === null || ! password_verify($password, (string) $user['password'])) {
                    return redirect()->to(base_url('login'))->withInput()->with('error', 'Invalid email address or password.');
                }

                // Keep the existing session data while rotating its ID. This
                // is safer for Render's file-based production sessions.
                session()->regenerate(false);
                session()->set([
                    'isLogged' => true,
                    'user_id' => (int) $user['id'],
                    'username' => $user['username'] ?? $user['email'] ?? $email,
                ]);

                return redirect()->to(base_url('account-dashboard'));
            } catch (\Throwable $exception) {
                log_message('critical', 'Login failed: {message}', ['message' => $exception->getMessage()]);

                return redirect()->to(base_url('login'))->withInput()->with(
                    'error',
                    'Login is temporarily unavailable. Please try again.'
                );
            }
        }

        return view('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url())->with('success', 'You have been logged out.');
    }
}
