<section class="card" style="max-width: 100%; margin: 2rem 0;">
  <h2>👥 Attendees for “<?= htmlspecialchars($event['name']) ?>”</h2>

  <div class="alert" style="display:flex;gap:1rem;flex-wrap:wrap;">
    <span><strong>🆔 Event ID:</strong> #<?= (int)$eventId ?></span>
    <span><strong>📅 Starts:</strong> <?= htmlspecialchars($event['start_date']) ?></span>
    <span><strong>🏁 Ends:</strong> <?= htmlspecialchars($event['end_date']) ?></span>
    <span><strong>📍 Venue:</strong> <?= htmlspecialchars($event['venue_id']) ?></span>
    <span><strong>🎫 Capacity:</strong> <?= (int)$event['allowed_number'] ?></span>
  </div>

  <?php
  $total = count($attendees ?? []);
  $paid  = array_sum(array_map(fn($a) => (int)($a['paid'] ?? 0), $attendees ?? []));
  ?>
  <div class="stats-row" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin:1rem 0;">
    <div class="stat-card" style="background:rgba(102,126,234,0.1);border:1px solid var(--border-light);border-radius:16px;padding:1rem;text-align:center;">
      <div class="stat-number" style="font-size:2rem;font-weight:900;"><?= $total ?></div>
      <div class="stat-label" style="text-transform:uppercase;">Total Attendees</div>
    </div>
    <div class="stat-card" style="background:rgba(72,187,120,0.1);border:1px solid var(--border-light);border-radius:16px;padding:1rem;text-align:center;">
      <div class="stat-number" style="font-size:2rem;font-weight:900;"><?= $paid ?></div>
      <div class="stat-label" style="text-transform:uppercase;">Paid</div>
    </div>
    <div class="stat-card" style="background:rgba(237,137,54,0.1);border:1px solid var(--border-light);border-radius:16px;padding:1rem;text-align:center;">
      <div class="stat-number" style="font-size:2rem;font-weight:900;"><?= max(0, $total - $paid) ?></div>
      <div class="stat-label" style="text-transform:uppercase;">Unpaid</div>
    </div>
  </div>

  <?php if (empty($attendees)): ?>
    <div class="alert">
      <p>No attendees have registered for this event yet.</p>
    </div>
  <?php else: ?>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($attendees as $i => $a): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td>
                <strong><?= htmlspecialchars($a['last_name']) ?>, <?= htmlspecialchars($a['first_name']) ?></strong>
                <small class="event-id" style="display:block;color:var(--text-secondary);">ID: #<?= (int)$a['attendee_id'] ?></small>
              </td>
              <td>
                <a href="mailto:<?= htmlspecialchars($a['email']) ?>"><?= htmlspecialchars($a['email']) ?></a>
              </td>
              <td>
                <?php $isPaid = (int)$a['paid'] === 1; ?>
                <span style="background: <?= $isPaid ? 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)' : 'linear-gradient(135deg, #f56565 0%, #ed8936 100%)' ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 700;">
                  <?= $isPaid ? 'Paid' : 'Unpaid' ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <div style="display:flex;justify-content:space-between;gap:1rem;margin-top:1.25rem;">
    <a class="back-button" href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=event&action=index"
      style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.25rem;background:white;border:2px solid var(--border-light);border-radius:50px;color:var(--text-primary);text-decoration:none;font-weight:600;">
      ← Back to Events
    </a>
  </div>
</section>
