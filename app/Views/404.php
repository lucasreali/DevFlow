<div class="d-flex flex-column justify-content-center align-items-center vh-100 text-center">
    <h1 class="fw-bold">404</h1>
    <p class="display-6">Page "<?= htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" not found</h>
    <p class="lead">Sorry, the page you are looking for does not exist.</p>
    <a href="/" class="btn btn-primary mt-3">Back to Home</a>
</div>