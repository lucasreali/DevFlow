<title>Register</title>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body p-4 d-flex flex-column">
            <h4 class="card-title fw-bold">Register</h4>
            <h6 class="card-subtitle mb-2 text-body-secondary">Welcome to DevFlow</h6>

            <form action="/register" method="post" class="">
                <div class="mb-1">
                    <label for="name" class="form-label">Your name: <span class="text-danger">*</span></label></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" style="<?php if (isset($errors['error_name'])) {echo 'border-color: red;';}?>">
                    <div style="color: red;">
                        <?php if (isset($errors['error_name'])) {echo $errors['error_name'];} ?>
                    </div>
                </div>
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

            <a href="/login" class="align-self-center mt-2">I already have an account</a>

        </div>
    </div>
</div>
