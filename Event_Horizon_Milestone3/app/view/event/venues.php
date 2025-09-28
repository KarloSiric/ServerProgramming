<section class="card" style="max-width: 100%; margin: 2rem 0;">
  <h2>🏛️ Event Venues Directory</h2>
  <?php if (empty($venues)): ?>
    <div class="alert">
      <p>No venues are currently available in the system.</p>
    </div>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Venue Location</th>
          <th>Guest Capacity</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($venues as $v): ?>
          <tr>
            <td>
              <strong>🏢 <?= htmlspecialchars($v['name']) ?></strong>
            </td>
            <td>
              <span style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                👥 <?= (int)$v['capacity'] ?> guests
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</section>
