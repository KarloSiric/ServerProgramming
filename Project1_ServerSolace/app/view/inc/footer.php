<?php
/**
 * @file footer.php
 * @brief Main layout footer included in all pages
 * 
 * Closes the HTML structure started in header.php.
 * Includes Bootstrap JavaScript and closes all open tags.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Included by Controller::view() method
 * @see Controller::view()
 * @see app/view/inc/header.php
 */
?>
    </main><!-- Close main content wrapper from header.php -->
    
    <!-- Site Footer -->
    <footer class="mt-auto py-3 bg-light border-top">
        <div class="container text-center">
            <p class="text-muted mb-0 small">
                © <?= date('Y') ?> EventHorizon - Event Management System. All rights reserved.
            </p>
        </div>
    </footer>
    
    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
