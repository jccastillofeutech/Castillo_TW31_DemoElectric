<?php

namespace App\Controllers;

use App\Models\User;

class Register extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Register - PowerFlow Electric',
            'page' => 'register',
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'validation' => session()->getFlashdata('validation'),
        ];

        return view('register', $data);
    }

    public function create()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'address' => 'required|min_length[5]|max_length[255]',
            'city' => 'required|min_length[2]|max_length[100]',
            'state' => 'required|min_length[2]|max_length[50]',
            'zip_code' => 'required|min_length[5]|max_length[10]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'terms' => 'required',
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            session()->setFlashdata('validation', $validation->getErrors());

            return redirect()->back()->withInput();
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));

        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $email,
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip_code' => $this->request->getPost('zip_code'),
            'password' => $this->request->getPost('password'),
            'user_type' => 'customer',
            'is_active' => true,
            'email_verified' => false,
        ];

        $db = db_connect();

        try {
            if ($db->table('user_accounts')
                ->where('username', $email)
                ->countAllResults() > 0) {
                session()->setFlashdata('error', 'This email address is already registered.');

                return redirect()->back()->withInput();
            }

            $db->transBegin();
            $userId = $this->userModel->insert($userData);

            if ($userId) {
                // The User model hashes the password during its insert callback.
                // Reuse that generated hash instead of hashing the password again.
                $savedUser = $this->userModel->find($userId);
                if ($savedUser === null || empty($savedUser['password'])) {
                    $db->transRollback();
                    throw new \RuntimeException('The registered user could not be read back.');
                }

                $accountInserted = $db->table('user_accounts')->insert([
                    'username' => $email,
                    'password' => $savedUser['password'],
                ]);

                if (! $accountInserted || $db->transStatus() === false) {
                    $db->transRollback();
                    throw new \RuntimeException('The login account could not be created.');
                }

                $db->transCommit();
                session()->setFlashdata(
                    'success',
                    'Registration successful! Welcome to PowerFlow Electric. You can now contact us for your electrical needs.'
                );

                return redirect()->to('/register');
            }

            $db->transRollback();
            session()->setFlashdata('error', 'Registration failed. Please try again.');

            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            if ($db->transStatus() !== false) {
                $db->transRollback();
            }

            session()->setFlashdata(
                'error',
                'Registration failed: ' . $e->getMessage()
            );

            return redirect()->back()->withInput();
        }
    }
}
