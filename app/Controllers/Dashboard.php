<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Dashboard extends BaseController
{
    protected CustomerAccountModel $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    protected function loginRedirect()
    {
        return session()->get('isLogged') === true ? null : redirect()->to(base_url('login'));
    }

    public function index()
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $keyword = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $accounts = $this->customerModel->filtered($keyword ?: null, $status ?: null, $type ?: null);

        return view('account_dashboard/index', [
            'accounts' => $accounts,
            'pager' => $this->customerModel->pager,
            'total_accounts' => $this->customerModel->countAllResults(false),
            'active_accounts' => $this->customerModel->countStatus('active'),
            'inactive_accounts' => $this->customerModel->countStatus('inactive'),
            'suspended_accounts' => $this->customerModel->countStatus('suspended'),
            'search_keyword' => $keyword,
            'filter_status' => $status,
            'filter_type' => $type,
            'current_page' => (int) ($this->request->getGet('page') ?? 1),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        return view('account_dashboard/create_account');
    }

    public function store()
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $data = $this->request->getPost(['customer_name', 'address', 'phone', 'email', 'meter_number', 'connection_type', 'status']);
        $data['account_number'] = $this->customerModel->nextAccountNumber();
        if (! $this->customerModel->insert($data)) return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        return redirect()->to(base_url('account-dashboard'))->with('success', 'Customer account created successfully.');
    }

    public function viewAccount(int $id)
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $account = $this->customerModel->find($id);
        if (! $account) return redirect()->to(base_url('account-dashboard'))->with('error', 'Account not found.');
        return view('account_dashboard/view_account', ['account' => $account]);
    }

    public function edit(int $id)
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $account = $this->customerModel->find($id);
        if (! $account) return redirect()->to(base_url('account-dashboard'))->with('error', 'Account not found.');
        return view('account_dashboard/edit_account', ['account' => $account]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $data = $this->request->getPost(['customer_name', 'address', 'phone', 'email', 'meter_number', 'connection_type', 'status']);
        if (! $this->customerModel->update($id, $data)) return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        return redirect()->to(base_url('account/' . $id))->with('success', 'Customer account updated successfully.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $this->customerModel->delete($id);
        return redirect()->to(base_url('account-dashboard'))->with('success', 'Customer account deleted successfully.');
    }

    public function bulkDelete()
    {
        if ($redirect = $this->loginRedirect()) return $redirect;
        $ids = $this->request->getPost('selected_accounts');
        if (! is_array($ids) || empty($ids)) return redirect()->back()->with('error', 'No accounts selected.');
        foreach (array_unique(array_filter(array_map('intval', $ids), static fn ($id) => $id > 0)) as $id) $this->customerModel->delete($id);
        return redirect()->to(base_url('account-dashboard'))->with('success', 'Selected accounts deleted successfully.');
    }
}
