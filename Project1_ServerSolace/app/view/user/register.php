<?php
/**
 * @file register.php
 * @brief User registration form view
 * 
 * Provides registration form for new users to create accounts.
 * Handles both attendee and admin role selection.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Called by UserController::register()
 * @see UserController::register()
 * @see UserController::createaccount() Processes this form
 */
?>
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5">
            <!-- Registration Card -->
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <!-- Header Section -->
                    <div class="text-center mb-4">
                        <!-- Application Logo -->
                        <img src="<?= PROJECT_URL; ?>/public/img/Project1_LogoImage.png" 
                             alt="EventHorizon" 
                             style="width: 60px; height: 60px; border-radius: 12px;" 
                             class="mb-3">
                        
                        <!-- Welcome Text -->
                        <h2 class="h3 fw-bold">Create Your Account</h2>
                        <p class="text-muted">Join EventHorizon to start managing events</p>
                    </div>

                    <?php 
                    /**
                     * Display flash messages if any
                     * Shows validation errors or other messages
                     */
                    if (!empty($_SESSION['flash'])): ?>
                        <?php require 'app/view/inc/flash.php'; ?>
                    <?php endif; ?>

                    <!-- Registration Form -->
                    <!-- Submits to UserController::createaccount() -->
                    <form method="post" action="<?= PROJECT_URL; ?>/Index.php?user/createaccount">
                        
                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold">Full Name</label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="name" 
                                   name="name" 
                                   placeholder="John Doe" 
                                   required>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold">Email Address</label>
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   id="email" 
                                   name="email" 
                                   placeholder="john@example.com" 
                                   required>
                            <small class="text-muted">We'll use this for your username</small>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold">Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Choose a strong password" 
                                   required>
                            <small class="text-muted">Demo: Any password works</small>
                        </div>

                        <!-- Admin Role Checkbox (for demo) -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="admin_role" 
                                   name="admin_role">
                            <label class="form-check-label" for="admin_role">
                                Register as Admin (Demo Only)
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            Create Account
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Login Link -->
                    <p class="text-center mb-0">
                        <small class="text-muted">Already have an account?</small><br>
                        <a href="<?= PROJECT_URL; ?>/Index.php?user/login" class="text-decoration-none">Sign In</a>
                    </p>
                </div>
            </div>
            
            <!-- Back to Home Link -->
            <div class="text-center mt-3">
                <a href="<?= PROJECT_URL; ?>/Index.php" class="text-muted text-decoration-none">
                    <small>← Back to Home</small>
                </a>
            </div>
        </div>
    </div>
</div>
