<?php
/**
 * @file home.php
 * @brief Public landing page view
 * 
 * The main entry point for visitors to EventHorizon.
 * Shows different CTAs based on authentication status.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Called by SiteController::home()
 * @see SiteController::home()
 */
?>
<!-- Main Landing Page Container -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Hero Section Card -->
            <div class="p-5 rounded-3 bg-body-tertiary text-center">
                <!-- Main Heading -->
                <h1 class="display-5 fw-bold mb-3">Welcome to EventHorizon</h1>
                
                <!-- Tagline -->
                <p class="lead text-secondary mb-4">Browse events, register, and manage your schedule.</p>
                
                <!-- Dynamic CTAs based on auth status -->
                <div class="d-flex gap-2 justify-content-center">
                    <?php if (empty($_SESSION['user'])): ?>
                        <!-- Guest User CTAs -->
                        <a class="btn btn-primary btn-lg" href="<?php echo PROJECT_URL; ?>/Index.php?user/login">Login</a>
                        <a class="btn btn-outline-primary btn-lg" href="<?php echo PROJECT_URL; ?>/Index.php?user/register">Register</a>
                    <?php else: ?>
                        <!-- Logged-in User CTAs -->
                        <a class="btn btn-primary btn-lg" href="<?php echo PROJECT_URL; ?>/Index.php?event/index">View Events</a>
                        
                        <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                            <!-- Additional Admin CTA -->
                            <a class="btn btn-outline-secondary btn-lg" href="<?php echo PROJECT_URL; ?>/Index.php?admin/overview">Admin Dashboard</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
