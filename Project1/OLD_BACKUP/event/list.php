    <div class="main-content">
        <div class="content-card">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Events</h1>
                    <p class="page-subtitle">
                        <?php if ($data['user']['role'] === 'organizer'): ?>
                        Manage and organize your events
                        <?php else: ?>
                        Browse and join upcoming events
                        <?php endif; ?>
                    </p>
                </div>
                <?php if ($data['user']['role'] === 'organizer' || $data['user']['role'] === 'admin'): ?>
                <button class="btn" onclick="showCreateModal()">+ Create Event</button>
                <?php endif; ?>
            </div>
            
            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Event created successfully!</div>
            <?php endif; ?>
            
            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <button class="tab-btn active" onclick="filterEvents('all', this)">All Events</button>
                <button class="tab-btn" onclick="filterEvents('upcoming', this)">Upcoming</button>
                <button class="tab-btn" onclick="filterEvents('completed', this)">Completed</button>
            </div>
            
            <!-- Events Grid -->
            <div class="events-grid">
                <?php if (empty($data['events'])): ?>
                    <p>No events found. <?php echo ($data['user']['role'] === 'organizer') ? 'Create your first event!' : 'Check back later!'; ?></p>
                <?php else: ?>
                    <?php foreach ($data['events'] as $event): ?>
                    <div class="event-card" data-status="<?php echo $event['status']; ?>">
                        <div class="event-header">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <span class="status-badge status-<?php echo $event['status']; ?>">
                                <?php echo ucfirst($event['status']); ?>
                            </span>
                        </div>
                        <div class="event-details">
                            <div class="event-detail">
                                <span class="detail-icon">📅</span>
                                <span><?php echo date('M j, Y', strtotime($event['date'])); ?></span>
                            </div>
                            <div class="event-detail">
                                <span class="detail-icon">⏰</span>
                                <span><?php echo date('g:i A', strtotime($event['time'])); ?></span>
                            </div>
                            <div class="event-detail">
                                <span class="detail-icon">📍</span>
                                <span><?php echo htmlspecialchars($event['location']); ?></span>
                            </div>
                            <div class="event-detail">
                                <span class="detail-icon">👥</span>
                                <span><?php echo $event['attendees']; ?> / <?php echo $event['max_attendees']; ?> attendees</span>
                            </div>
                            <?php if ($event['price'] > 0): ?>
                            <div class="event-detail">
                                <span class="detail-icon">💰</span>
                                <span>$<?php echo number_format($event['price'], 2); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="event-actions">
                            <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=view&id=<?php echo $event['id']; ?>" class="btn-small btn-outline">View</a>
                            <?php if ($data['user']['role'] === 'organizer' || $data['user']['role'] === 'admin'): ?>
                            <button class="btn-small btn-outline">Edit</button>
                            <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=delete&id=<?php echo $event['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                            <?php elseif ($data['user']['role'] === 'attendee'): ?>
                            <button class="btn-small">Register</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($data['user']['role'] === 'organizer' || $data['user']['role'] === 'admin'): ?>
    <!-- Create Event Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Event</h3>
                <button class="close-btn" onclick="hideCreateModal()">&times;</button>
            </div>
            <form class="modal-form" method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=store">
                <div class="form-group">
                    <input type="text" name="title" class="form-input" placeholder="Event title" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="date" name="date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <input type="time" name="time" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="location" class="form-input" placeholder="Location" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="number" name="max_attendees" class="form-input" placeholder="Max attendees" min="1" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="price" class="form-input" placeholder="Price ($)" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="description" class="form-input" placeholder="Event description" rows="3"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="hideCreateModal()">Cancel</button>
                    <button type="submit" class="btn">Create Event</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script src="<?php echo PROJECT_URL; ?>/public/js/events.js"></script>
    <script>
        function showCreateModal() {
            document.getElementById('createModal').style.display = 'flex';
        }
        
        function hideCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }
        
        function filterEvents(status, button) {
            const cards = document.querySelectorAll('.event-card');
            const tabs = document.querySelectorAll('.tab-btn');
            
            // Update active tab
            tabs.forEach(tab => tab.classList.remove('active'));
            button.classList.add('active');
            
            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        // Close modal when clicking outside
        const modal = document.getElementById('createModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideCreateModal();
                }
            });
        }
    </script>
