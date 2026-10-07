<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/assets/login/loginview_cs.css') ?>">

<main class="login-page">
    <?php if ($error = session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= esc($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success = session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="status">
            <?= esc($success) ?>
        </div>
    <?php endif; ?>

    <section class="login-card" aria-labelledby="company-name">
        <header class="login-brand">
            <span class="login-brand__icon" aria-hidden="true">
                <i class="fa-solid fa-bolt"></i>
            </span>
            <h1 id="company-name">Puihaha Electric Company</h1>
            <p>Customer Account Management System</p>
        </header>

        <form class="login-form" action="<?= base_url('login'); ?>" method="POST">
            <?= csrf_field() ?>
            <h2>Welcome back</h2>
            <p class="login-form__intro">Sign in with your account to continue.</p>

            <div class="login-field">
                <label for="email">Email address</label>
                <div class="login-field__control">
                    <i class="fa-solid fa-user" aria-hidden="true"></i>
                    <input type="email" name="email" id="email" placeholder="Enter your email address" value="<?= esc(old('email')) ?>" autocomplete="email" required autofocus>
                </div>
            </div>

            <div class="login-field">
                <label for="password">Password</label>
                <div class="login-field__control">
                    <i class="fa-solid fa-lock" aria-hidden="true"></i>
                    <input type="password" name="password" id="password" placeholder="Enter your password" autocomplete="current-password" required>
                    <button type="button" id="eyePassword" class="toggle-icon" aria-label="Show password" aria-pressed="false" onclick="togglePassword('password', 'eyePassword')">
                        <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <button type="submit" id="sign-in-btn" class="login-submit">
                Log In <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>

        <p class="login-footer">Secure access to your customer account system</p>
    </section>
</main>

<script src="<?= base_url('public/assets/login/login_js.js') ?>"></script>
