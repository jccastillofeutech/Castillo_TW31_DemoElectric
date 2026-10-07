<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electric Company - Customer Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 20px auto;
        }

        .dashboard-header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-left {
            justify-self: start;
        }

        .header-title {
            text-align: center;
        }

        .header-title h1 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header-right {
            justify-self: end;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-section h1 {
            color: #667eea;
            font-weight: bold;
        }

        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        .stats-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .card-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-active {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .card-inactive {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        }

        .card-suspended {
            background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        }

        .search-filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .search-filter-section button {
            height: 42px;
            white-space: nowrap;
        }

        #openDeleteModal {
            width: 90px;
        }

        .select-column {
            display: none;
        }

        .selection-mode .select-column {
            display: table-cell;
        }

        #bulkToolbar {
            display: none;
            margin-top: 15px;
            margin-bottom: 15px;
            gap: 8px;
            align-items: center;
        }

        #bulkToolbar span {
            margin-left: auto;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
        }

        .bulk-toolbar {
            background: #fff4f4;
            border: 1px solid #f5c2c7;
            border-radius: 10px;
            padding: 12px 15px;
        }

        .table-container {
            overflow-x: auto;
        }


        .table tbody tr {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f4f6ff;
        }

        .badge-active {
            background-color: #28a745;
        }

        .badge-inactive {
            background-color: #dc3545;
        }

        .badge-suspended {
            background-color: #ffc107;
            color: #000;
        }

        .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li a {
            display: block;
            min-width: 34px;
            padding: 6px 10px;
            text-align: center;
            text-decoration: none;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            color: #667eea;
            background: #ffffff;
        }

        .pagination li.active a {
            color: #ffffff;
            background: #667eea;
            border-color: #667eea;
        }

        .pagination li a:hover {
            background: #eef0ff;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                grid-template-columns: 1fr;
                gap: 15px;
                text-align: center;
            }

            .header-left,
            .header-right {
                justify-self: center;
            }

            .header-left {
                order: 2;
            }

            .header-title {
                order: 1;
            }

            .header-right {
                order: 3;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-container">
            <!-- Header -->
            <div class="dashboard-header">
                <div class="header-left">
                    <a href="<?= base_url('accounts/create') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Add Account
                    </a>
                </div>

                <div class="header-title">
                    <h1>
                        <i class="bi bi-lightning-charge-fill text-warning"></i>
                        Puihaha Electric Company
                    </h1>

                    <p class="text-muted mb-0">
                        Customer Account Management System
                    </p>
                </div>

                <div class="header-right">
                    <form method="post" action="<?= base_url('logout') ?>">
                        <?= csrf_field() ?>

                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= esc(session('success')) ?>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= esc(session('error')) ?>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card card-total">
                        <h3><?= $total_accounts ?></h3>
                        <p>Total Accounts</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card card-active">
                        <h3><?= $active_accounts ?></h3>
                        <p>Active Accounts</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card card-inactive">
                        <h3><?= $inactive_accounts ?></h3>
                        <p>Inactive Accounts</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card card-suspended">
                        <h3><?= $suspended_accounts ?></h3>
                        <p>Suspended Accounts</p>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                    <form method="GET" action="<?= base_url('account-dashboard') ?>">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="Search by name, account, email, phone..." value="<?= esc($search_keyword ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?= ($filter_status ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($filter_status ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="suspended" <?= ($filter_status ?? '') == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="residential" <?= ($filter_type ?? '') == 'residential' ? 'selected' : '' ?>>Residential</option>
                                <option value="commercial" <?= ($filter_type ?? '') == 'commercial' ? 'selected' : '' ?>>Commercial</option>
                                <option value="industrial" <?= ($filter_type ?? '') == 'industrial' ? 'selected' : '' ?>>Industrial</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                            <button type="button" id="openSelectionButton" class="btn btn-danger"><i class="bi bi-trash"></i>Delete</button>
                        </div>
                    </div>
                </form>
                <?php if ($search_keyword || $filter_status || $filter_type): ?>
                    <div class="mt-2">
                        <a href="<?= base_url('account-dashboard') ?>" class="btn btn-sm btn-secondary"><i class="bi bi-x-circle"></i> Clear Filters</a>
                    </div>
                <?php endif; ?>
            </div>

            <div id="bulkToolbar">
                <button type="button" class="btn btn-danger" id="bulkDeleteButton" disabled>Delete Selected</button>
                <button type="button" class="btn btn-secondary" id="cancelSelection">Cancel</button>
                <span><strong id="selectedCount">0</strong> selected</span>
            </div>

            <form method="post"
                action="<?= base_url('accounts/bulk-delete') ?>"
                id="bulkDeleteForm">

                <?= csrf_field() ?>

                <!-- Customer Accounts Table -->
                <div class="table-container">
                    <table class="table table-hover" id="accountsTable">
                        <thead class="table-dark">
                            <tr>
                                <th class="select-column">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Account Number</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Connection Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($accounts)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                        No accounts found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($accounts as $account): ?>
                                    <tr>
                                        <td class="select-column">
                                            <input type="checkbox" name="selected_accounts[]" value="<?= esc($account['id']) ?>" class="account-checkbox">
                                        </td>

                                        <td>
                                            <strong><?= esc($account['account_number']) ?></strong>
                                        </td>

                                        <td><?= esc($account['customer_name']) ?></td>
                                        <td><?= esc($account['email']) ?></td>
                                        <td><?= esc($account['phone']) ?></td>

                                        <td>
                                            <span class="badge bg-info">
                                                <?= ucfirst(esc($account['connection_type'])) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge badge-<?= esc($account['status']) ?>">
                                                <?= ucfirst(esc($account['status'])) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <a href="<?= base_url('account/' . $account['id']) ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- Pagination -->
            <?php if ($pager): ?>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing page <?= $current_page ?> of <?= $pager->getPageCount() ?>
                    </div>
                    <div>
                        <?= $pager->links() ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle"></i>
                        Confirm Deletion
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="modalSelectedCount">0</strong> selected account(s)?</p>

                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-danger" form="bulkDeleteForm"><i class="bi bi-trash"></i>Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const openSelectionButton = document.getElementById('openSelectionButton');
        const cancelSelection = document.getElementById('cancelSelection');
        const bulkToolbar = document.getElementById('bulkToolbar');
        const accountsTable = document.getElementById('accountsTable');
        const deleteButton = document.getElementById('bulkDeleteButton');
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.account-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const modalSelectedCount = document.getElementById('modalSelectedCount');
        let deleteConfirmModal;

        function updateSelection() {
            const selected = document.querySelectorAll('.account-checkbox:checked').length;

            selectedCount.textContent = selected;
            deleteButton.disabled = selected === 0;
        }

        openSelectionButton.addEventListener('click', function() {
            accountsTable.classList.add('selection-mode');
            bulkToolbar.style.display = 'flex';
            openSelectionButton.style.display = 'none';
        });

        cancelSelection.addEventListener('click', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            selectAll.checked = false;
            updateSelection();

            accountsTable.classList.remove('selection-mode');
            bulkToolbar.style.display = 'none';
            openSelectionButton.style.display = 'inline-block';
        });

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAll.checked;
            });

            updateSelection();
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', updateSelection);
        });

        deleteButton.addEventListener('click', function() {
            const selected = document.querySelectorAll('.account-checkbox:checked').length;

            if (selected === 0) {
                return;
            }

            modalSelectedCount.textContent = selected;
            deleteConfirmModal ??= new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteConfirmModal.show();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
