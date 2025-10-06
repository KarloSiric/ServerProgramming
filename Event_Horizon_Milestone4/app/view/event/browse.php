<div class="browse-events-container">
  <!-- Enhanced User Hero with Stats -->
  <div class="user-hero">
    <div class="hero-content-wrapper">
      <div class="hero-text">
        <h1>🎊 Discover Amazing Events</h1>
        <p>Browse and register for upcoming events</p>
      </div>
      <div class="user-stats-mini">
        <div class="mini-stat">
          <span class="mini-stat-number"><?= count($registeredEventIds) ?></span>
          <span class="mini-stat-label">My Events</span>
        </div>
        <div class="mini-stat">
          <span class="mini-stat-number"><?= count($events) ?></span>
          <span class="mini-stat-label">Available</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Tabs -->
  <div class="filter-tabs">
    <button class="filter-tab active" onclick="filterEvents('all')">All Events</button>
    <button class="filter-tab" onclick="filterEvents('registered')">My Registrations</button>
    <button class="filter-tab" onclick="filterEvents('available')">Available</button>
  </div>

  <!-- Events Grid -->
  <div class="events-grid" id="eventsGrid">
    <?php if (empty($events)): ?>
      <div class="no-events">
        <span class="no-events-icon">📭</span>
        <h3>No Events Available</h3>
        <p>Check back later for upcoming events!</p>
      </div>
    <?php else: ?>
      <?php foreach ($events as $event): ?>
        <?php
        $isRegistered = in_array($event['event_id'], $registeredEventIds);
        $isFull = $event['attendee_count'] >= $event['allowed_number'];
        $percentage = ($event['allowed_number'] > 0) ?
          round(($event['attendee_count'] / $event['allowed_number']) * 100) : 0;
        
        $statusClass = $isRegistered ? 'registered' : ($isFull ? 'full' : 'available');
        ?>
        <div class="event-card <?= $statusClass ?>" data-status="<?= $statusClass ?>">
          <div class="event-card-ribbon <?= $isRegistered ? 'ribbon-green' : ($isFull ? 'ribbon-red' : '') ?>">
            <?php if ($isRegistered): ?>
              ✅ Registered
            <?php elseif ($isFull): ?>
              🚫 Full
            <?php endif; ?>
          </div>

          <div class="event-card-header">
            <h3><?= htmlspecialchars($event['name']) ?></h3>
            <div class="event-id-badge">ID: #<?= $event['event_id'] ?></div>
          </div>

          <div class="event-card-body">
            <div class="event-info-row">
              <span class="info-icon">📅</span>
              <div class="info-content">
                <strong>Starts</strong>
                <span><?= date('M d, Y @ g:i A', strtotime($event['start_date'])) ?></span>
              </div>
            </div>

            <div class="event-info-row">
              <span class="info-icon">🏁</span>
              <div class="info-content">
                <strong>Ends</strong>
                <span><?= date('M d, Y @ g:i A', strtotime($event['end_date'])) ?></span>
              </div>
            </div>

            <div class="event-info-row">
              <span class="info-icon">📍</span>
              <div class="info-content">
                <strong>Venue</strong>
                <span><?= htmlspecialchars($event['venue_name']) ?></span>
              </div>
            </div>

            <div class="event-capacity-section">
              <div class="capacity-header">
                <span class="capacity-icon">👥</span>
                <span class="capacity-text"><?= $event['attendee_count'] ?> / <?= $event['allowed_number'] ?> Attendees</span>
              </div>
              <div class="capacity-bar-wrapper">
                <div class="capacity-bar">
                  <div class="capacity-fill" style="width: <?= $percentage ?>%; background: <?= $percentage >= 90 ? '#f56565' : ($percentage >= 70 ? '#ed8936' : '#48bb78') ?>;"></div>
                </div>
                <span class="capacity-percent"><?= $percentage ?>%</span>
              </div>
            </div>
          </div>

          <div class="event-card-footer">
            <?php if ($isRegistered): ?>
              <form method="post" action="<?= PROJECT_URL ?>/event/unregister" onsubmit="return confirm('Are you sure you want to unregister from this event?');">
                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                <button type="submit" class="btn-unregister">
                  <span class="btn-icon">❌</span>
                  <span>Unregister</span>
                </button>
              </form>
            <?php else: ?>
              <?php if ($isFull): ?>
                <button class="btn-full" disabled>
                  <span class="btn-icon">🚫</span>
                  <span>Event Full</span>
                </button>
              <?php else: ?>
                <form method="post" action="<?= PROJECT_URL ?>/event/register">
                  <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                  <button type="submit" class="btn-register">
                    <span class="btn-icon">✨</span>
                    <span>Register Now</span>
                  </button>
                </form>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<script>
function filterEvents(filter) {
  const cards = document.querySelectorAll('.event-card');
  const tabs = document.querySelectorAll('.filter-tab');
  
  tabs.forEach(tab => tab.classList.remove('active'));
  event.target.classList.add('active');
  
  cards.forEach(card => {
    const status = card.dataset.status;
    
    if (filter === 'all') {
      card.style.display = 'block';
    } else if (filter === 'registered' && status === 'registered') {
      card.style.display = 'block';
    } else if (filter === 'available' && status === 'available') {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
</script>

<style>
.browse-events-container {
  padding: 0;
  animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.user-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 24px;
  padding: 3rem;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
  position: relative;
  overflow: hidden;
}

.user-hero::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 60%;
  height: 200%;
  background: rgba(255, 255, 255, 0.1);
  transform: rotate(15deg);
}

.hero-content-wrapper {
  position: relative;
  z-index: 1;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 2rem;
}

.hero-text h1 {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  font-weight: 900;
}

.hero-text p {
  font-size: 1.1rem;
  opacity: 0.95;
}

.user-stats-mini {
  display: flex;
  gap: 1.5rem;
}

.mini-stat {
  background: rgba(255, 255, 255, 0.2);
  padding: 1rem 1.5rem;
  border-radius: 16px;
  text-align: center;
  backdrop-filter: blur(10px);
}

.mini-stat-number {
  display: block;
  font-size: 2rem;
  font-weight: 900;
  margin-bottom: 0.25rem;
}

.mini-stat-label {
  font-size: 0.9rem;
  opacity: 0.9;
}

.filter-tabs {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  background: white;
  padding: 1rem;
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.filter-tab {
  flex: 1;
  padding: 0.75rem 1.5rem;
  border: 2px solid var(--border-light);
  background: white;
  border-radius: 12px;
  font-weight: 600;
  color: var(--text-secondary);
  cursor: pointer;
  transition: all 0.3s ease;
}

.filter-tab:hover {
  border-color: #667eea;
  color: #667eea;
}

.filter-tab.active {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-color: transparent;
}

.events-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  gap: 2rem;
}

.event-card {
  background: white;
  border-radius: 20px;
  padding: 0;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  border: 2px solid var(--border-light);
  overflow: hidden;
  position: relative;
  animation: cardEntry 0.4s ease;
}

@keyframes cardEntry {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

.event-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.event-card.registered {
  border-color: #48bb78;
}

.event-card.full {
  opacity: 0.7;
}

.event-card-ribbon {
  position: absolute;
  top: 15px;
  right: -35px;
  background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
  color: white;
  padding: 0.5rem 3rem;
  font-weight: 700;
  font-size: 0.85rem;
  transform: rotate(45deg);
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
  z-index: 10;
}

.event-card-ribbon.ribbon-red {
  background: linear-gradient(135deg, #f56565 0%, #ed8936 100%);
}

.event-card-header {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
  padding: 1.75rem;
  border-bottom: 2px solid var(--border-light);
}

.event-card-header h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.4rem;
  color: var(--text-primary);
}

.event-id-badge {
  display: inline-block;
  background: rgba(102, 126, 234, 0.1);
  padding: 0.25rem 0.75rem;
  border-radius: 50px;
  font-size: 0.85rem;
  color: #667eea;
  font-weight: 600;
}

.event-card-body {
  padding: 1.75rem;
}

.event-info-row {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.25rem;
  padding: 1rem;
  background: var(--bg-main);
  border-radius: 12px;
  transition: all 0.3s ease;
}

.event-info-row:hover {
  background: rgba(102, 126, 234, 0.05);
  transform: translateX(5px);
}

.info-icon {
  font-size: 1.75rem;
  line-height: 1;
}

.info-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.info-content strong {
  color: var(--text-primary);
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-content span {
  color: var(--text-secondary);
  font-size: 1rem;
}

.event-capacity-section {
  margin-top: 1.5rem;
  padding: 1.25rem;
  background: linear-gradient(135deg, rgba(72, 187, 120, 0.05) 0%, rgba(56, 161, 105, 0.05) 100%);
  border-radius: 16px;
  border: 2px solid rgba(72, 187, 120, 0.2);
}

.capacity-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 0.75rem;
}

.capacity-icon {
  font-size: 1.5rem;
}

.capacity-text {
  font-weight: 700;
  color: var(--text-primary);
  font-size: 1.05rem;
}

.capacity-bar-wrapper {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.capacity-bar {
  flex: 1;
  height: 12px;
  background: var(--border-light);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.capacity-fill {
  height: 100%;
  transition: width 0.8s ease;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(72, 187, 120, 0.5);
}

.capacity-percent {
  font-weight: 700;
  color: var(--text-secondary);
  font-size: 0.95rem;
  min-width: 45px;
  text-align: right;
}

.event-card-footer {
  padding: 1.5rem 1.75rem;
  background: var(--bg-main);
  border-top: 2px solid var(--border-light);
}

.event-card-footer form {
  width: 100%;
}

.event-card-footer button {
  width: 100%;
  padding: 1.1rem;
  border: none;
  border-radius: 14px;
  font-weight: 700;
  font-size: 1.05rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
}

.btn-icon {
  font-size: 1.2rem;
}

.btn-register {
  background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
  color: white;
  box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
}

.btn-register:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
}

.btn-register:active {
  transform: translateY(-1px);
}

.btn-unregister {
  background: linear-gradient(135deg, #f56565 0%, #ed8936 100%);
  color: white;
  box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
}

.btn-unregister:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(245, 101, 101, 0.4);
}

.btn-full {
  background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
  color: white;
  cursor: not-allowed;
  opacity: 0.6;
}

.no-events {
  grid-column: 1 / -1;
  text-align: center;
  padding: 5rem 2rem;
  background: white;
  border-radius: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.no-events-icon {
  font-size: 6rem;
  display: block;
  margin-bottom: 1.5rem;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

.no-events h3 {
  font-size: 2rem;
  color: var(--text-primary);
  margin-bottom: 0.75rem;
}

.no-events p {
  color: var(--text-secondary);
  font-size: 1.1rem;
}

@media (max-width: 768px) {
  .hero-content-wrapper { flex-direction: column; text-align: center; }
  .hero-text h1 { font-size: 2rem; }
  .user-stats-mini { justify-content: center; }
  .events-grid { grid-template-columns: 1fr; }
  .filter-tabs { flex-direction: column; }
}
</style>
