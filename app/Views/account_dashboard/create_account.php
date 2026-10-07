<?php
echo view('account_dashboard/account_form', [
    'pageTitle' => 'Create Customer Account',
    'formAction' => base_url('accounts/store'),
    'account' => null,
]);
