<?php
echo view('account_dashboard/account_form', [
    'pageTitle' => 'Edit Customer Account',
    'formAction' => base_url('account/' . $account['id'] . '/update'),
    'account' => $account,
]);
