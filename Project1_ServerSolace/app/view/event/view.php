<?php
$event = $event ?? null;
if (!$event) {
    header('Location: /user/dashboard');
    exit;
}
?>

<div class="main-content">
    <!-- Event Detail Modal Style -->
    <div style="background: var(--bg-secondary); border-radius: 16px; overflow: hidden; border: 1px solid var(--border-color); max-width: 800px; margin: 0 auto;">
        
        <!-- Event Header Image -->
        <div style="position: relative;">
            <div style="width: 100%; height: 300px; background-image: url('/~ks9700/iste-341/Project1/public/img/Project1_image1.png'); background-size: cover; background-position: center;">
                <div style="position: absolute; top: 12px; left: 12px; background: rgba(0, 0, 0, 0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                    <?= htmlspecialchars($event['type']) ?>
                </div>
                <button onclick="history.back()" style="position: absolute; top: 16px; right: 16px; background: rgba(0, 0, 0, 0.5); border: none; color: white; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    ✕
                </button>
            </div>
        </div>

        <!-- Event Content -->
        <div style="padding: 32px;">
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 24px; color: var(--text-primary);">
                <?= htmlspecialchars($event['name']) ?>
            </h1>

            <!-- Event Meta Information -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: var(--text-muted);">📅</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 2px; color: var(--text-primary);">
                            <?= date('l, F j, Y', strtotime($event['date'])) ?>
                        </h4>
                        <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
                            <?= $event['time'] ?> - <?= $event['end_time'] ?>
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: var(--text-muted);">📍</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 2px; color: var(--text-primary);">
                            <?= htmlspecialchars($event['venue_name']) ?>
                        </h4>
                        <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
                            <?= $event['registration_count'] ?>/<?= $event['venue_capacity'] ?> registered
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: var(--text-muted);">👥</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 2px; color: var(--text-primary);">
                            <?= $event['registration_count'] ?>/<?= $event['venue_capacity'] ?> registered
                        </h4>
                        <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
                            <?= $event['venue_capacity'] - $event['registration_count'] ?> spots remaining
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: var(--text-muted);">💰</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 2px; color: var(--text-primary);">
                            $<?= $event['price'] ?>
                        </h4>
                        <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
                            Registration fee
                        </p>
                    </div>
                </div>
            </div>

            <!-- Organizer -->
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                <span style="color: var(--text-muted);">👤</span>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 2px; color: var(--text-primary);">Organized by</h4>
                    <p style="font-size: 14px; color: var(--text-secondary); margin: 0;"><?= $event['organizer'] ?></p>
                </div>
            </div>

            <!-- About Section -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; color: var(--text-primary);">About this event</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    <?= htmlspecialchars($event['description']) ?>
                </p>
            </div>

            <!-- What you'll learn -->
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; color: var(--text-primary);">What you'll learn</h3>
                <ul style="color: var(--text-secondary); line-height: 1.6; padding-left: 20px;">
                    <li>Latest industry trends and best practices</li>
                    <li>Hands-on experience with cutting-edge technologies</li>
                    <li>Networking opportunities with industry experts</li>
                    <li>Practical insights you can apply immediately</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 16px; justify-content: center;">
                <button onclick="history.back()" style="flex: 1; max-width: 200px; padding: 12px 24px; background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border-color); border-radius: 6px; cursor: pointer;">
                    Close
                </button>
                <button style="flex: 1; max-width: 200px; padding: 12px 24px; background: var(--accent-blue); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                    Already Registered
                </button>
            </div>
        </div>
    </div>
</div>
