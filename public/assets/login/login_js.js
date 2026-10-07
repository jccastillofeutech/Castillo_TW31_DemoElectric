function togglePassword(inputId, buttonId) {
    const passwordField = document.getElementById(inputId);
    const toggleButton = document.getElementById(buttonId);
    const icon = toggleButton?.querySelector('i');

    if (!passwordField || !toggleButton || !icon) {
        return;
    }

    const shouldShow = passwordField.type === 'password';
    passwordField.type = shouldShow ? 'text' : 'password';
    toggleButton.setAttribute('aria-pressed', String(shouldShow));
    toggleButton.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
    icon.classList.toggle('fa-eye', shouldShow);
    icon.classList.toggle('fa-eye-slash', !shouldShow);
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.alert').forEach((alert) => {
        window.setTimeout(() => {
            alert.classList.add('alert--dismissed');
            window.setTimeout(() => alert.remove(), 250);
        }, 3000);
    });
});
