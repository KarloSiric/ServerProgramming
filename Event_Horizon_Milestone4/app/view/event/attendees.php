<section class="card" style="max-width: 100%; margin: 2rem 0;">
  <h2>👥 Attendees for "<?= htmlspecialchars($event['name']) ?>"</h2>

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
  </div>

  <?php if (empty($attendees)): ?>
    <p style="text-align:center;padding:3rem;color:var(--text-secondary);">
      No attendees registered yet.
    </p>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attendees as $att): ?>
          <tr>
            <td><?= (int)$att['attendee_id'] ?></td>
            <td><?= htmlspecialchars($att['first_name'] . ' ' . $att['last_name']) ?></td>
            <td><?= htmlspecialchars($att['username']) ?></td>
            <td><?= htmlspecialchars($att['email']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <div style="margin-top:2rem;">
    <a href="<?= PROJECT_URL ?>/event/all" class="btn">← Back to All Events</a>
  </div>
</section>
