<title>Login</title>

<div class="d-flex flex-column justify-content-center align-items-center vh-100">
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger" style="width: 400px;">
            <?= $errors['error'] ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" style="width: 400px;">
            <?= $success ?>
        </div>
    <?php endif; ?>
    <div class="card shadow" style="width: 400px;">
        <div class="card-body p-4 d-flex flex-column">
            <h4 class="card-title fw-bold">Login</h4>
            <h6 class="card-subtitle mb-2 text-body-secondary">Welcome back to DevFlow</h6>

            <form action="/login" method="post">

            <div class="mb-1">
                    <label for="email" class="form-label">Email address: <span class="text-danger">*</span></label></label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="mail@example.com" style="<?php if (isset($errors['error_email'])) {echo 'border-color: red;';}?>">
                    <div style="color: red;">
                        <?php if (isset($errors['error_email'])) {echo $errors['error_email'];} ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password: <span class="text-danger">*</span></label></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="*********" style="<?php if (isset($errors['error_password'])) {echo 'border-color: red;';}?>">
                    <div style="color: red;">
                        <?php if (isset($errors['error_password'])) {echo $errors['error_password'];} ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>

            <a href="/register" class="align-self-center mt-2">I don't have an account</a>
        </div>
    </div>
</div>