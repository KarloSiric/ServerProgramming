<div class="events-container">
  <!-- Hero Section -->
  <div class="hero-banner">
    <div class="hero-content">
      <h1 class="hero-title">
        <span class="gradient-text">🎊 Event Horizon</span>
      </h1>
      <p class="hero-subtitle">Discover Amazing Events & Experiences</p>
      <div class="stats-row">
        <div class="stat-card">
          <span class="stat-number"><?= count($events ?? []) ?></span>
          <span class="stat-label">Active Events</span>
        </div>
        <div class="stat-card">
          <span class="stat-number"><?= array_sum(array_column($events ?? [], 'attendee_count')) ?></span>
          <span class="stat-label">Total Attendees</span>
        </div>
        <div class="stat-card">
          <span class="stat-number"><?= count(array_unique(array_column($events ?? [], 'venue_name'))) ?></span>
          <span class="stat-label">Venues</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Events Card -->
  <div class="card" style="max-width: 100%; margin: 2rem 0; padding: 0; overflow: hidden;">
    <div class="card-header">
      <h2>🎯 Upcoming Events</h2>
      <div class="filter-buttons">
        <button class="filter-btn active">All Events</button>
        <button class="filter-btn">This Week</button>
        <button class="filter-btn">This Month</button>
      </div>
    </div>

    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Location</th>
            <th>Capacity Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $event): ?>
            <?php
            $percentage = ($event['allowed_number'] > 0) ?
              round(($event['attendee_count'] / $event['allowed_number']) * 100) : 0;
            $statusColor = $percentage >= 90 ? 'var(--danger)' : ($percentage >= 70 ? 'var(--warning)' : 'var(--success)');
            ?>
            <tr class="event-row">
              <td>
                <div class="event-name-cell">
                  <span class="event-icon">🎪</span>
                  <div>
                    <strong><?= htmlspecialchars($event['name'] ?? '') ?></strong>
                    <small class="event-id">ID: #<?= htmlspecialchars($event['event_id'] ?? '0') ?></small>
                  </div>
                </div>
              </td>
              <td>
                <div class="date-cell">
                  📅 <?= htmlspecialchars($event['start_date'] ?? '') ?>
                </div>
              </td>
              <td>
                <div class="date-cell">
                  🏁 <?= htmlspecialchars($event['end_date'] ?? '') ?>
                </div>
              </td>
              <td>
                <div class="location-cell">
                  📍 <?= htmlspecialchars($event['venue_name'] ?? '') ?>
                </div>
              </td>
              <td>
                <div class="capacity-cell">
                  <a href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=event&action=attendees&id=<?= (int)($event['event_id'] ?? 0) ?>"
                    class="capacity-link"
                    style="text-decoration: none; display: block;">
                    <div class="capacity-info">
                      <span class="capacity-text" style="color: <?= $statusColor ?>">
                        👥 <?= htmlspecialchars($event['attendee_count'] ?? '0') ?> / <?= htmlspecialchars($event['allowed_number'] ?? '') ?>
                      </span>
                      <div class="capacity-bar">
                        <div class="capacity-fill" style="width: <?= $percentage ?>%; background: <?= $statusColor ?>;"></div>
                      </div>
                      <span class="capacity-percentage"><?= $percentage ?>% Full</span>
                    </div>
                  </a>
                </div>
              </td>
              <td>
                <div class="action-buttons">
                  <a href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=event&action=attendees&id=<?= (int)$event['event_id'] ?>"
                    class="action-btn view-btn" title="View Attendees">👁️</a>

                  <a href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=event&action=edit&id=<?= (int)$event['event_id'] ?>"
                    class="action-btn edit-btn" title="Edit Event">✏️</a>

                  <form method="post"
                    action="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=event&action=destroy"
                    onsubmit="return confirm('Delete this event? This cannot be undone.');"
                    style="display:inline">
                    <input type="hidden" name="id" value="<?= (int)$event['event_id'] ?>">
                    <button type="submit" class="action-btn delete-btn" title="Delete Event">🗑️</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (empty($events)): ?>
      <div class="empty-state">
        <span class="empty-icon">📭</span>
        <h3>No Events Found</h3>
        <p>There are currently no events scheduled. Check back later!</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Quick Actions Card -->
  <div class="quick-actions">
    <h3>⚡ Quick Actions</h3>
    <div class="action-grid">
      <button class="quick-action-card" onclick="window.location.href='<?= BASE_PATH ?>/Index.php?controller=event&action=create'">
        <span class="action-icon">➕</span>
        <span class="action-text">Create New Event</span>
      </button>
      <button class="quick-action-card" onclick="window.location.href='<?= BASE_PATH ?>/Index.php?controller=venue&action=index'">
        <span class="action-icon">🏢</span>
        <span class="action-text">Manage Venues</span>
      </button>
      <button class="quick-action-card" onclick="alert('Export feature coming soon!')">
        <span class="action-icon">📊</span>
        <span class="action-text">Export Report</span>
      </button>
      <button class="quick-action-card" onclick="alert('Settings feature coming soon!')">
        <span class="action-icon">⚙️</span>
        <span class="action-text">Event Settings</span>
      </button>
    </div>
  </div>
</div>

<style>
  /* Events Page Specific Styles */
  .events-container {
    animation: fadeIn 0.5s ease-out;
  }

  .hero-banner {
    background: var(--primary-gradient);
    border-radius: 24px;
    padding: 3rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
  }

  .hero-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 60%;
    height: 200%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(45deg);
  }

  .hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: white;
  }

  .hero-title {
    font-size: 3rem;
    margin-bottom: 0.5rem;
    font-weight: 900;
  }

  .hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.95;
    margin-bottom: 2rem;
  }

  .stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
  }

  .stat-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.25);
  }

  .stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
  }

  .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem 2.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-bottom: 2px solid var(--border-light);
  }

  .card-header h2 {
    margin: 0;
  }

  .filter-buttons {
    display: flex;
    gap: 0.5rem;
  }

  .filter-btn {
    padding: 0.5rem 1rem;
    border: 2px solid var(--border-light);
    background: white;
    border-radius: 25px;
    font-weight: 600;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
  }

  .filter-btn:hover,
  .filter-btn.active {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
  }

  .event-row {
    transition: all 0.3s ease;
  }

  .event-row:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(240, 147, 251, 0.05) 100%);
  }

  .event-name-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .event-icon {
    font-size: 1.5rem;
  }

  .event-id {
    display: block;
    color: var(--text-secondary);
    font-size: 0.8rem;
    font-weight: normal;
    margin-top: 0.25rem;
  }

  .date-cell,
  .location-cell {
    font-weight: 500;
  }

  .capacity-cell {
    position: relative;
  }

  .capacity-link {
    transition: all 0.3s ease;
  }

  .capacity-link:hover .capacity-info {
    transform: scale(1.05);
  }

  .capacity-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    transition: all 0.3s ease;
  }

  .capacity-text {
    font-weight: 700;
    font-size: 1rem;
  }

  .capacity-bar {
    width: 120px;
    height: 8px;
    background: var(--border-light);
    border-radius: 10px;
    overflow: hidden;
  }

  .capacity-fill {
    height: 100%;
    transition: width 0.5s ease;
    border-radius: 10px;
  }

  .capacity-percentage {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: 600;
  }

  .action-buttons {
    display: flex;
    gap: 0.5rem;
  }

  .action-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid var(--border-light);
    background: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    text-decoration: none;
  }

  .view-btn:hover {
    background: var(--primary-gradient);
    border-color: transparent;
    transform: scale(1.1);
  }

  .edit-btn:hover {
    background: var(--secondary-gradient);
    border-color: transparent;
    transform: scale(1.1);
  }

  .empty-state {
    padding: 4rem 2rem;
    text-align: center;
  }

  .empty-icon {
    font-size: 4rem;
    display: block;
    margin-bottom: 1rem;
  }

  .empty-state h3 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: var(--text-secondary);
  }

  .quick-actions {
    background: white;
    border-radius: 24px;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
  }

  .quick-actions h3 {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
  }

  .action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
  }

  .quick-action-card {
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border: 2px solid var(--border-light);
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
  }

  .quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
  }

  .action-icon {
    font-size: 2rem;
  }

  .action-text {
    font-weight: 600;
    font-size: 0.95rem;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (max-width: 768px) {
    .hero-title {
      font-size: 2rem;
    }

    .card-header {
      flex-direction: column;
      gap: 1rem;
      align-items: stretch;
    }

    .filter-buttons {
      justify-content: center;
    }

    .capacity-bar {
      width: 80px;
    }

    .action-grid {
      grid-template-columns: 1fr 1fr;
    }
  }
</style>
