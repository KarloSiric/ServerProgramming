<?php
$event = $event ?? null;
if (!$event) {
    header('Location: ?user/dashboard');
    exit;
}
?>

<div class="main-content">
    <!-- Event Detail Modal Style -->
    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb; max-width: 800px; margin: 0 auto; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        
        <!-- Event Header Image -->
        <div style="position: relative;">
            <div style="width: 100%; height: 300px; background-image: url('/~ks9700/iste-341/Project1/public/img/Project1_image1.png'); background-size: cover; background-position: center;">
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(0, 0, 0, 0.7); color: white; padding: 8px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">
                    <?= htmlspecialchars($event['type']) ?>
                </div>
                <div style="position: absolute; top: 16px; right: 56px; background: rgba(0, 0, 0, 0.7); color: white; padding: 8px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">
                    $<?= $event['price'] ?? 299 ?>
                </div>
                <button onclick="history.back()" style="position: absolute; top: 16px; right: 16px; background: rgba(0, 0, 0, 0.6); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    ×
                </button>
            </div>
        </div>

        <!-- Event Content -->
        <div style="padding: 32px;">
            <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 16px; color: #1e293b; line-height: 1.2;">
                <?= htmlspecialchars($event['name']) ?>
            </h1>

            <div style="color: #64748b; font-size: 16px; margin-bottom: 32px; line-height: 1.6;">
                <span>👤</span> Organized by <strong><?= htmlspecialchars($event['organizer'] ?? 'Event Foundation') ?></strong>
            </div>

            <!-- Event Meta Information -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px; padding: 24px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: #3b82f6; font-size: 20px;">📅</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 4px; color: #374151;">
                            <?= date('l, F j, Y', strtotime($event['date'])) ?>
                        </h4>
                        <p style="font-size: 14px; color: #64748b; margin: 0;">
                            <?= $event['time'] ?? '9:00 AM' ?> - <?= $event['end_time'] ?? '6:00 PM' ?>
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: #10b981; font-size: 20px;">📍</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 4px; color: #374151;">
                            <?= htmlspecialchars($event['venue_name']) ?>
                        </h4>
                        <p style="font-size: 14px; color: #64748b; margin: 0;">
                            <?= $event['registration_count'] ?? 0 ?>/<?= $event['venue_capacity'] ?> registered
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: #f59e0b; font-size: 20px;">💰</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 4px; color: #374151;">
                            Event Price
                        </h4>
                        <p style="font-size: 14px; color: #64748b; margin: 0;">
                            $<?= $event['price'] ?? 299 ?>
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: #8b5cf6; font-size: 20px;">📊</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 4px; color: #374151;">
                            Availability
                        </h4>
                        <p style="font-size: 14px; color: #64748b; margin: 0;">
                            <?php 
                            $remaining = ($event['venue_capacity'] ?? 200) - ($event['registration_count'] ?? 0);
                            echo $remaining > 0 ? "$remaining spots left" : "Fully booked";
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Event Description -->
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 16px; color: #1e293b;">About This Event</h3>
                <p style="font-size: 16px; color: #475569; line-height: 1.7; margin-bottom: 16px;">
                    <?= htmlspecialchars($event['description']) ?>
                </p>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; padding-top: 24px; border-top: 1px solid #e2e8f0;">
                <?php $user = $user ?? null; ?>
                <?php if ($user): ?>
                    <a href="?event/register/<?= $event['id'] ?>" 
                       class="btn btn-primary" 
                       style="flex: 1; background: #3b82f6; color: white; padding: 14px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; border: none; cursor: pointer; font-size: 16px; display: block;">
                        Register for Event
                    </a>
                    <button onclick="history.back()" 
                            class="btn btn-outline" 
                            style="flex: 1; background: transparent; color: #64748b; padding: 14px; border-radius: 8px; border: 1px solid #d1d5db; font-weight: 600; cursor: pointer; font-size: 16px;">
                        Back to Events
                    </button>
                <?php else: ?>
                    <a href="?user/login" 
                       class="btn btn-primary" 
                       style="flex: 1; background: #3b82f6; color: white; padding: 14px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; font-size: 16px; display: block;">
                        Login to Register
                    </a>
                    <button onclick="history.back()" 
                            class="btn btn-outline" 
                            style="flex: 1; background: transparent; color: #64748b; padding: 14px; border-radius: 8px; border: 1px solid #d1d5db; font-weight: 600; cursor: pointer; font-size: 16px;">
                        Back
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn-outline:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
}
</style>
