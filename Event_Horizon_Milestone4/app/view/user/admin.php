<?php $u = $_SESSION['user'] ?? ['username'=>'admin']; ?>
<nav style="width: 100%; padding: 1.25rem 2rem; background: var(--primary-gradient); color: white; border-radius: 16px; margin-bottom: 2rem; box-shadow: var(--shadow-lg);">
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <strong style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
      <span>⚡</span> Admin Control Center
    </strong>
    <span style="display: flex; align-items: center; gap: 1.5rem;">
      <span style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600;">
        👤 <?= htmlspecialchars($u['username']) ?>
      </span>
      <a href="<?= PROJECT_URL ?>/user/logout"
         style="color: white; text-decoration: none; background: rgba(255,255,255,0.2); padding: 0.5rem 1.25rem; border-radius: 25px; font-weight: 600; transition: all 0.3s ease;">
        🚪 Sign Out
      </a>
    </span>
  </div>
</nav>

<main style="padding: 0;">
  <div class="card" style="max-width: 100%; margin: 0;">
    <h2 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem;">
      <span>📅</span> Event Management Dashboard
    </h2>

    <?php if (empty($events)): ?>
      <div class="alert"><p>No events have been created yet. Start by adding your first event!</p></div>
    <?php else: ?>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Event Name</th><th>Start Date</th><th>End Date</th><th>Venue</th><th>Registration Status</th></tr></thead>
          <tbody>
          <?php foreach ($events as $e): ?>
            <tr>
              <td><strong style="color: var(--accent-purple);">🎯 <?= htmlspecialchars($e['event_name']) ?></strong></td>
              <td>📅 <?= htmlspecialchars($e['start_date']) ?></td>
              <td>🏁 <?= htmlspecialchars($e['end_date']) ?></td>
              <td>📍 <?= htmlspecialchars($e['venue_name']) ?></td>
              <td>
                <a href="<?= PROJECT_URL ?>/event/attendees/<?= (int)$e['event_id'] ?>"
                   style="display:inline-block;padding:0.5rem 1rem;background:<?= ($e['registered'] >= $e['allowed_number']) ? 'linear-gradient(135deg, #f56565 0%, #ed8936 100%)' : 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)' ?>;color:white;border-radius:25px;text-decoration:none;font-weight:600;transition:all .3s;">
                  👥 <?= (int)$e['registered'] ?>/<?= (int)$e['allowed_number'] ?> Registered
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</main>
