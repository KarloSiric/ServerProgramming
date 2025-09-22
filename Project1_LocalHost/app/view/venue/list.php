<?php $u = $user ?? ['username' => 'user']; ?>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>All Venues</h2>
        </div>
        <div class="card-body">
            <?php if (($u['role'] ?? '') === 'admin'): ?>
                <a href="/venue/create" class="btn btn-success">Add New Venue</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($venues)): ?>
        <div class="card">
            <div class="card-body">
                <p>No venues found.</p>
                <?php if (($u['role'] ?? '') === 'admin'): ?>
                    <a href="/venue/create" class="btn btn-success">Add First Venue</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-3">
            <?php foreach ($venues as $venue): ?>
                <div class="card">
                    <div class="card-header">
                        <h3><?= htmlspecialchars($venue['name']) ?></h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Type:</strong> <?= htmlspecialchars($venue['type']) ?></p>
                        <p><strong>Capacity:</strong> <?= number_format($venue['capacity']) ?> people</p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($venue['location']) ?></p>
                        
                        <?php if (!empty($venue['description'])): ?>
                            <p><?= htmlspecialchars(substr($venue['description'], 0, 100)) ?>...</p>
                        <?php endif; ?>

                        <div style="margin-top: 15px;">
                            <a href="/venue/view?id=<?= $venue['id'] ?>" class="btn btn-outline">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
