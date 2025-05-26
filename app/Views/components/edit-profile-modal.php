<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="/user/update" method="POST">
                    <!-- Form fields for editing profile -->
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" 
                               value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" 
                               value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editCurrentPassword" class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="editCurrentPassword" name="password" 
                               required placeholder="Enter your current password to save changes">
                        <div class="invalid-feedback" id="currentPasswordError"></div>
                        <div class="form-text">Required to confirm any changes</div>
                    </div>
                    
                    <hr>
                    <h6 class="mb-3">Change Password (Optional)</h6>
                    
                    <div class="mb-3">
                        <label for="editNewPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="editNewPassword" name="new_password" 
                               placeholder="Leave blank to keep current password">
                        <div class="invalid-feedback" id="newPasswordError"></div>
                        <div class="form-text">Leave blank if you don't want to change your password</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editNewPasswordConfirm" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="editNewPasswordConfirm" name="new_password_confirm"
                               placeholder="Confirm new password">
                        <div class="invalid-feedback" id="confirmPasswordError"></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const editProfileForm = document.getElementById('editProfileForm');
    if (editProfileForm) {
        // Reset all inputs on modal open
        $('#editProfileModal').on('show.bs.modal', function() {
            // Reset validation
            const inputs = editProfileForm.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            // Clear error messages
            const errorDivs = editProfileForm.querySelectorAll('.invalid-feedback');
            errorDivs.forEach(div => {
                div.textContent = '';
            });
            
            // Reset password fields
            document.getElementById('editNewPassword').value = '';
            document.getElementById('editNewPasswordConfirm').value = '';
            document.getElementById('editCurrentPassword').value = '';
        });
        
        editProfileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('editName');
            const email = document.getElementById('editEmail');
            const currentPassword = document.getElementById('editCurrentPassword');
            const newPassword = document.getElementById('editNewPassword');
            const confirmPassword = document.getElementById('editNewPasswordConfirm');
            
            // Reset validation state
            [name, email, currentPassword, newPassword, confirmPassword].forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            let isValid = true;
            
            // Validate name
            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                document.getElementById('nameError').textContent = 'Name is required';
                isValid = false;
            }
            
            // Validate email
            if (!email.value.trim()) {
                email.classList.add('is-invalid');
                document.getElementById('emailError').textContent = 'Email is required';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
                email.classList.add('is-invalid');
                document.getElementById('emailError').textContent = 'Invalid email format';
                isValid = false;
            }
            
            // Validate current password
            if (!currentPassword.value.trim()) {
                currentPassword.classList.add('is-invalid');
                document.getElementById('currentPasswordError').textContent = 'Current password is required to save changes';
                isValid = false;
            }
            
            // Only validate new password fields if a new password is being set
            if (newPassword.value.trim()) {
                // Check new password length
                if (newPassword.value.length < 8) {
                    newPassword.classList.add('is-invalid');
                    document.getElementById('newPasswordError').textContent = 'Password must be at least 8 characters long';
                    isValid = false;
                }
                
                // Check that passwords match
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.classList.add('is-invalid');
                    document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                    isValid = false;
                }
            } else if (confirmPassword.value.trim()) {
                // If confirm is filled but new password is empty
                newPassword.classList.add('is-invalid');
                document.getElementById('newPasswordError').textContent = 'Please enter a new password';
                isValid = false;
            }
            
            if (isValid) {
                this.submit();
            }
        });
    }
});
</script>
