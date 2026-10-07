<?php
$isEdit = !empty($account);

$value = static function (string $field) use ($account) {
    return old($field, $account[$field] ?? '');
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($pageTitle) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
        }

        .form-card {
            max-width: 950px;
            margin: auto;
            padding: 32px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 10px 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.2);
        }

        .btn {
            border-radius: 8px;
        }

        @media (max-width: 576px) {
            body {
                padding: 8px 0;
            }

            .container.py-5 {
                padding-top: 16px !important;
                padding-bottom: 16px !important;
            }

            .form-card {
                padding: 20px 16px;
                border-radius: 12px;
            }

            .form-card > .d-flex {
                align-items: stretch !important;
                flex-direction: column;
                gap: 12px;
            }

            .form-card h2 {
                font-size: 1.35rem;
            }

            .form-card > .d-flex .btn,
            .form-card form .mt-4 .btn {
                width: 100%;
            }

            .form-card form .mt-4 {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
<div class="container py-5">
    <div class="form-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><?= esc($pageTitle) ?></h2>

            <a href="<?= base_url('account-dashboard') ?>" class="btn btn-outline-secondary">
                Back
            </a>
        </div>

        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= esc($formAction) ?>">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Account Number</label>
                    <?php if ($isEdit): ?>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= esc($value('account_number')) ?>"
                            style="color: #6c757d;"
                            readonly
                            aria-readonly="true"
                        >
                        <div class="form-text">Account numbers cannot be changed.</div>
                    <?php else: ?>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= esc($generatedAccountNumber ?? '') ?>"
                            style="color: #6c757d;"
                            readonly
                            aria-readonly="true"
                        >
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    <input
                        type="text"
                        name="customer_name"
                        class="form-control"
                        value="<?= esc($value('customer_name')) ?>"
                        required
                    >
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea
                        name="address"
                        class="form-control"
                        rows="3"
                        required
                    ><?= esc($value('address')) ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="<?= esc($value('phone')) ?>"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= esc($value('email')) ?>"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label">Meter Number</label>
                    <input
                        type="text"
                        name="meter_number"
                        class="form-control"
                        value="<?= esc($value('meter_number')) ?>"
                        required
                    >
                </div>

                <div class="col-md-3">
                    <label class="form-label">Connection Type</label>
                    <select name="connection_type" class="form-select" required>
                        <option value="">Choose type</option>

                        <?php foreach (['residential', 'commercial', 'industrial'] as $type): ?>
                            <option value="<?= $type ?>"
                                <?= $value('connection_type') === $type ? 'selected' : '' ?>>
                                <?= ucfirst($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <?php foreach (['active', 'inactive', 'suspended'] as $status): ?>
                            <option value="<?= $status ?>"
                                <?= $value('status') === $status ? 'selected' : '' ?>>
                                <?= ucfirst($status) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? 'Update Account' : 'Save Account' ?>
                </button>

                <a href="<?= base_url('account-dashboard') ?>" class="btn btn-light">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>
</body>
</html>
