<?php
/**
 * @file login.php
 * @brief User login form view
 * 
 * Provides authentication form for users to sign in.
 * Demo authentication - username "admin" gets admin role.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Called by UserController::login()
 * @see UserController::login()
 * @see UserController::authenticate() Processes this form
 */
?>
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-4">
            <!-- Login Card -->
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <!-- Logo and Header -->
                    <div class="text-center mb-4">
                        <!-- Application Logo -->
                        <img src="<?= PROJECT_URL; ?>/public/img/Project1_LogoImage.png" 
                             alt="EventHorizon" 
                             style="width: 60px; height: 60px; border-radius: 12px;" 
                             class="mb-3">
                        
                        <!-- Welcome Text -->
                        <h2 class="h3 fw-bold">Welcome Back</h2>
                        <p class="text-muted">Sign in to manage your events</p>
                    </div>

                    <?php 
                    /**
                     * Display flash messages if any
                     * Shows success/error messages from registration or logout
                     */
                    if (!empty($_SESSION['flash'])): ?>
                        <?php require 'app/view/inc/flash.php'; ?>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="post" action="<?= PROJECT_URL; ?>/Index.php?user/authenticate">
                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-semibold">Username</label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Enter username" 
                                   required 
                                   autofocus>
                            <!-- Help text for demo -->
                            <small class="text-muted">Use "admin" for admin access</small>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label small fw-semibold">Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter password" 
                                   required>
                            <!-- Help text for demo -->
                            <small class="text-muted">Any password works for demo</small>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            Sign In
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Sign Up Link -->
                    <p class="text-center mb-0">
                        <small class="text-muted">Don't have an account?</small><br>
                        <a href="<?= PROJECT_URL; ?>/Index.php?user/register" class="text-decoration-none">Create New Account</a>
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
