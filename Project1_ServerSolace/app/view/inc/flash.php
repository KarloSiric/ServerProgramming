<?php
/**
 * @file flash.php
 * @brief Display one-time flash messages from session
 * 
 * Flash messages are temporary notifications shown once and then cleared.
 * Used for success messages, errors, warnings after form submissions.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Messages are set using flash() function in header.php
 * @see flash() in header.php
 */

/**
 * Check if flash messages exist in session
 * Messages are stored as: $_SESSION['flash'][type][] = message
 */
if (!empty($_SESSION['flash'])): ?>
    <?php 
    /**
     * Loop through each message type (success, danger, warning, info)
     */
    foreach ($_SESSION['flash'] as $type => $messages): ?>
        <?php 
        /**
         * Loop through all messages of this type
         * Cast to array in case single message stored as string
         */
        foreach ((array)$messages as $m): ?>
            <!-- Display Bootstrap alert with appropriate styling -->
            <div class="alert alert-<?= htmlspecialchars($type) ?> mb-3">
                <?= htmlspecialchars($m) ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; 
    
    /**
     * Clear flash messages after display
     * This ensures messages only show once
     */
    unset($_SESSION['flash']); 
    ?>
<?php endif; ?>
