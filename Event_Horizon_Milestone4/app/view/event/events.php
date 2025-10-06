<div class="admin-dashboard">
  <!-- Enhanced Admin Hero -->
  <div class="admin-hero">
    <div class="admin-hero-content">
      <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 50%; backdrop-filter: blur(10px);">
          <span style="font-size: 2.5rem;">⚡</span>
        </div>
        <div>
          <h1 class="hero-title">Admin Control Center</h1>
          <p class="hero-subtitle">Manage all events, venues, and attendees</p>
        </div>
      </div>
      <div class="admin-user-badge">
        👑 Logged in as: <strong><?= htmlspecialchars($user['username'] ?? 'Admin') ?></strong>
      </div>
    </div>
  </div>

  <!-- Admin Stats Grid -->
  <div class="admin-stats-grid">
    <div class="admin-stat-card purple">
      <div class="stat-icon">📅</div>
      <div class="stat-info">
        <div class="stat-number"><?= count($events ?? []) ?></div>
        <div class="stat-label">Total Events</div>
      </div>
    </div>
    <div class="admin-stat-card blue">
      <div class="stat-icon">👥</div>
      <div class="stat-info">
        <div class="stat-number"><?= array_sum(array_column($events ?? [], 'attendee_count')) ?></div>
        <div class="stat-label">Total Registrations</div>
      </div>
    </div>
    <div class="admin-stat-card green">
      <div class="stat-icon">🏢</div>
      <div class="stat-info">
        <div class="stat-number"><?= count(array_unique(array_column($events ?? [], 'venue_name'))) ?></div>
        <div class="stat-label">Active Venues</div>
      </div>
    </div>
    <div class="admin-stat-card pink">
      <div class="stat-icon">🔥</div>
      <div class="stat-info">
        <div class="stat-number"><?= count(array_filter($events ?? [], fn($e) => $e['attendee_count'] >= $e['allowed_number'])) ?></div>
        <div class="stat-label">Sold Out Events</div>
      </div>
    </div>
  </div>

  <!-- Quick Actions Bar -->
  <div class="admin-actions-bar">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
      <h3 style="margin: 0;">⚡ Quick Admin Actions</h3>
      <span style="background: rgba(102, 126, 234, 0.1); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; color: #667eea;">
        <?= count($events ?? []) ?> Events Active
      </span>
    </div>
    <div class="admin-action-buttons">
      <a href="<?= PROJECT_URL ?>/event/create" class="admin-action-btn create">
        <span class="btn-icon">➕</span>
        <span>Create Event</span>
      </a>
      <a href="<?= PROJECT_URL ?>/venue/index" class="admin-action-btn venues">
        <span class="btn-icon">🏢</span>
        <span>Manage Venues</span>
      </a>
      <button onclick="window.print()" class="admin-action-btn print">
        <span class="btn-icon">🖨️</span>
        <span>Print Report</span>
      </button>
      <a href="<?= PROJECT_URL ?>/user/logout" class="admin-action-btn logout">
        <span class="btn-icon">🚪</span>
        <span>Sign Out</span>
      </a>
    </div>
  </div>

  <!-- Events Management Card -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2>📋 Event Management</h2>
      <span class="admin-badge"><?= count($events ?? []) ?> Events</span>
    </div>

    <?php if (empty($events)): ?>
      <div class="admin-empty-state">
        <span class="empty-icon">📭</span>
        <h3>No Events Yet</h3>
        <p>Create your first event to get started managing your event portfolio!</p>
        <a href="<?= PROJECT_URL ?>/event/create" class="admin-btn-primary">Create First Event</a>
      </div>
    <?php else: ?>
      <div class="admin-table-container">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Event Details</th>
              <th>Schedule</th>
              <th>Location</th>
              <th>Registration Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($events as $event): ?>
              <?php
              $percentage = ($event['allowed_number'] > 0) ?
                round(($event['attendee_count'] / $event['allowed_number']) * 100) : 0;
              $statusClass = $percentage >= 90 ? 'critical' : ($percentage >= 70 ? 'warning' : 'good');
              ?>
              <tr class="admin-table-row">
                <td>
                  <div class="event-details">
                    <strong class="event-name">🎯 <?= htmlspecialchars($event['name'] ?? '') ?></strong>
                    <span class="event-meta">ID: #<?= htmlspecialchars($event['event_id'] ?? '0') ?></span>
                  </div>
                </td>
                <td>
                  <div class="schedule-info">
                    <div style="margin-bottom: 0.25rem;">📅 <strong>Start:</strong> <?= date('M d, Y g:i A', strtotime($event['start_date'] ?? '')) ?></div>
                    <div>🏁 <strong>End:</strong> <?= date('M d, Y g:i A', strtotime($event['end_date'] ?? '')) ?></div>
                  </div>
                </td>
                <td>
                  <span class="venue-badge">📍 <?= htmlspecialchars($event['venue_name'] ?? '') ?></span>
                </td>
                <td>
                  <a href="<?= PROJECT_URL ?>/event/attendees/<?= (int)($event['event_id'] ?? 0) ?>" class="status-link">
                    <div class="registration-status <?= $statusClass ?>">
                      <div class="status-numbers">
                        <span class="current"><?= htmlspecialchars($event['attendee_count'] ?? '0') ?></span>
                        <span class="separator">/</span>
                        <span class="total"><?= htmlspecialchars($event['allowed_number'] ?? '') ?></span>
                      </div>
                      <div class="status-bar">
                        <div class="status-fill" style="width: <?= $percentage ?>%"></div>
                      </div>
                      <div class="status-label"><?= $percentage ?>% Full</div>
                    </div>
                  </a>
                </td>
                <td>
                  <div class="admin-actions">
                    <a href="<?= PROJECT_URL ?>/event/attendees/<?= (int)$event['event_id'] ?>" 
                       class="admin-icon-btn view" title="View Attendees">
                      👁️
                    </a>
                    <a href="<?= PROJECT_URL ?>/event/edit/<?= (int)$event['event_id'] ?>" 
                       class="admin-icon-btn edit" title="Edit Event">
                      ✏️
                    </a>
                    <form method="post" 
                          action="<?= PROJECT_URL ?>/event/destroy"
                          onsubmit="return confirm('⚠️ Delete this event permanently? This cannot be undone!');"
                          style="display:inline">
                      <input type="hidden" name="id" value="<?= (int)$event['event_id'] ?>">
                      <button type="submit" class="admin-icon-btn delete" title="Delete Event">🗑️</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<style>
.admin-dashboard { padding: 0; animation: fadeIn 0.5s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

.admin-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 24px;
  padding: 2.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
  position: relative;
  overflow: hidden;
}

.admin-hero::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 60%;
  height: 200%;
  background: rgba(255, 255, 255, 0.1);
  transform: rotate(15deg);
}

.admin-hero-content { position: relative; z-index: 1; }
.hero-title { font-size: 2rem; margin: 0; font-weight: 900; }
.hero-subtitle { font-size: 1rem; opacity: 0.95; margin: 0; }
.admin-user-badge {
  display: inline-block;
  background: rgba(255, 255, 255, 0.2);
  padding: 0.75rem 1.5rem;
  border-radius: 50px;
  backdrop-filter: blur(10px);
  font-size: 0.95rem;
  margin-top: 1rem;
}

.admin-stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.admin-stat-card {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.admin-stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.admin-stat-card.purple { border-color: #667eea; }
.admin-stat-card.blue { border-color: #4299e1; }
.admin-stat-card.green { border-color: #48bb78; }
.admin-stat-card.pink { border-color: #f093fb; }

.stat-icon { font-size: 3rem; line-height: 1; }
.stat-info { flex: 1; }
.stat-number { font-size: 2.5rem; font-weight: 900; color: var(--text-primary); display: block; line-height: 1; margin-bottom: 0.5rem; }
.stat-label { font-size: 0.9rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

.admin-actions-bar {
  background: white;
  border-radius: 20px;
  padding: 1.5rem 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.admin-actions-bar h3 {
  color: var(--text-primary);
  font-size: 1.3rem;
}

.admin-action-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.admin-action-btn {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.85rem 1.5rem;
  border-radius: 14px;
  font-weight: 600;
  transition: all 0.3s ease;
  text-decoration: none;
  border: 2px solid var(--border-light);
  background: white;
  color: var(--text-primary);
  cursor: pointer;
  font-size: 0.95rem;
}

.admin-action-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.admin-action-btn.create:hover { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; border-color: transparent; }
.admin-action-btn.venues:hover { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-color: transparent; }
.admin-action-btn.print:hover { background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; border-color: transparent; }
.admin-action-btn.logout:hover { background: linear-gradient(135deg, #f56565 0%, #ed8936 100%); color: white; border-color: transparent; }

.btn-icon { font-size: 1.2rem; }

.admin-card {
  background: white;
  border-radius: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

.admin-card-header {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
  padding: 2rem 2.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid var(--border-light);
}

.admin-card-header h2 { margin: 0; font-size: 1.5rem; }
.admin-badge { background: var(--primary-gradient); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 700; font-size: 0.9rem; }

.admin-table-container { overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; }
.admin-table thead tr { background: var(--bg-main); }
.admin-table th { text-align: left; padding: 1.25rem 1.5rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
.admin-table-row { border-bottom: 1px solid var(--border-light); transition: all 0.3s ease; }
.admin-table-row:hover { background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(240, 147, 251, 0.05) 100%); }
.admin-table td { padding: 1.5rem 1.5rem; }

.event-details { display: flex; flex-direction: column; gap: 0.5rem; }
.event-name { font-size: 1.05rem; color: var(--text-primary); }
.event-meta { color: var(--text-secondary); font-size: 0.85rem; }

.schedule-info { display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem; }
.venue-badge { display: inline-block; background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; color: var(--text-primary); border: 2px solid var(--border-light); }

.status-link { text-decoration: none; display: block; }
.registration-status { display: flex; flex-direction: column; gap: 0.5rem; padding: 0.75rem; border-radius: 12px; transition: all 0.3s ease; }
.registration-status:hover { transform: scale(1.05); }
.registration-status.good { background: rgba(72, 187, 120, 0.1); }
.registration-status.warning { background: rgba(237, 137, 54, 0.1); }
.registration-status.critical { background: rgba(245, 101, 101, 0.1); }

.status-numbers { display: flex; align-items: baseline; gap: 0.25rem; font-weight: 700; font-size: 1.1rem; }
.status-bar { width: 100%; height: 8px; background: var(--border-light); border-radius: 10px; overflow: hidden; }
.status-fill { height: 100%; transition: width 0.5s ease; border-radius: 10px; }
.registration-status.good .status-fill { background: #48bb78; }
.registration-status.warning .status-fill { background: #ed8936; }
.registration-status.critical .status-fill { background: #f56565; }
.status-label { font-size: 0.8rem; color: var(--text-secondary); font-weight: 600; }

.admin-actions { display: flex; gap: 0.5rem; }
.admin-icon-btn { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--border-light); background: white; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease; text-decoration: none; }
.admin-icon-btn.view:hover { background: var(--primary-gradient); border-color: transparent; transform: scale(1.15); }
.admin-icon-btn.edit:hover { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-color: transparent; transform: scale(1.15); }
.admin-icon-btn.delete:hover { background: linear-gradient(135deg, #f56565 0%, #ed8936 100%); border-color: transparent; transform: scale(1.15); }

.admin-empty-state { padding: 4rem 2rem; text-align: center; }
.empty-icon { font-size: 5rem; display: block; margin-bottom: 1.5rem; }
.admin-empty-state h3 { font-size: 1.75rem; color: var(--text-primary); margin-bottom: 0.75rem; }
.admin-empty-state p { color: var(--text-secondary); margin-bottom: 2rem; }
.admin-btn-primary { display: inline-block; padding: 1rem 2rem; background: var(--primary-gradient); color: white; text-decoration: none; border-radius: 50px; font-weight: 700; transition: all 0.3s ease; }
.admin-btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); }

@media (max-width: 768px) {
  .hero-title { font-size: 1.75rem; }
  .admin-stats-grid { grid-template-columns: 1fr; }
  .admin-action-buttons { flex-direction: column; }
}
</style>
