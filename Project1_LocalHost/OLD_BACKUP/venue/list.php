    <div class="main-content">
        <div class="content-card">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Venues</h1>
                    <p class="page-subtitle">Find and book the perfect venue for your event</p>
                </div>
                <?php if ($data['user']['role'] === 'organizer' || $data['user']['role'] === 'admin'): ?>
                <button class="btn" onclick="showAddVenueModal()">+ Add Venue</button>
                <?php endif; ?>
            </div>
            
            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Venue added successfully!</div>
            <?php endif; ?>
            
            <!-- Search and Filter -->
            <div class="search-filter-bar">
                <div class="search-box">
                    <input type="text" placeholder="Search venues..." class="search-input">
                </div>
                <select class="filter-select">
                    <option value="">All Capacities</option>
                    <option value="small">Small (1-50)</option>
                    <option value="medium">Medium (51-200)</option>
                    <option value="large">Large (201+)</option>
                </select>
            </div>
            
            <!-- Venues Grid -->
            <div class="venues-grid">
                <?php foreach ($data['venues'] as $venue): ?>
                <div class="venue-card" data-capacity="<?php echo $venue['capacity']; ?>">
                    <div class="venue-image">
                        <div class="venue-placeholder">🏢</div>
                        <div class="venue-rating">
                            <span>⭐ <?php echo $venue['rating']; ?></span>
                        </div>
                        <?php if (!$venue['available']): ?>
                        <div style="position: absolute; top: 10px; left: 10px; background: #ef4444; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            Unavailable
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="venue-info">
                        <h3><?php echo htmlspecialchars($venue['name']); ?></h3>
                        <p style="color: #6b7280; font-size: 14px; margin: 4px 0;"><?php echo htmlspecialchars($venue['type']); ?></p>
                        <div class="venue-details">
                            <div class="venue-detail">
                                <span class="detail-icon">📍</span>
                                <span><?php echo htmlspecialchars($venue['address']); ?></span>
                            </div>
                            <div class="venue-detail">
                                <span class="detail-icon">👥</span>
                                <span>Up to <?php echo $venue['capacity']; ?> people</span>
                            </div>
                            <div class="venue-detail">
                                <span class="detail-icon">💰</span>
                                <span>$<?php echo number_format($venue['price_per_day'], 2); ?>/day</span>
                            </div>
                        </div>
                        <div class="amenities">
                            <?php foreach (array_slice($venue['amenities'], 0, 3) as $amenity): ?>
                                <span class="amenity-tag"><?php echo htmlspecialchars($amenity); ?></span>
                            <?php endforeach; ?>
                            <?php if (count($venue['amenities']) > 3): ?>
                                <span class="amenity-tag">+<?php echo count($venue['amenities']) - 3; ?> more</span>
                            <?php endif; ?>
                        </div>
                        <div class="venue-actions">
                            <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=venue&action=view&id=<?php echo $venue['id']; ?>" class="btn btn-outline">View Details</a>
                            <?php if ($venue['available']): ?>
                                <?php if ($data['user']['role'] === 'organizer' || $data['user']['role'] === 'admin'): ?>
                                <button class="btn">Book Now</button>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($data['user']['role'] === 'admin'): ?>
                            <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=venue&action=delete&id=<?php echo $venue['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php if ($data['user']['role'] === 'organizer' || $data['user']['role'] === 'admin'): ?>
    <!-- Add Venue Modal -->
    <div id="addVenueModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Venue</h3>
                <button class="close-btn" onclick="hideAddVenueModal()">&times;</button>
            </div>
            <form class="modal-form" method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=venue&action=store">
                <div class="form-group">
                    <input type="text" name="name" class="form-input" placeholder="Venue name" required>
                </div>
                <div class="form-group">
                    <select name="type" class="form-input" required>
                        <option value="">Select venue type</option>
                        <option value="Conference Hall">Conference Hall</option>
                        <option value="Meeting Room">Meeting Room</option>
                        <option value="Event Hall">Event Hall</option>
                        <option value="Workshop Area">Workshop Area</option>
                        <option value="Tech Space">Tech Space</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="number" name="capacity" class="form-input" placeholder="Capacity" min="1" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="price_per_day" class="form-input" placeholder="Price per day" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="address" class="form-input" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <textarea name="amenities" class="form-input" placeholder="Amenities (comma separated)" rows="2"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="hideAddVenueModal()">Cancel</button>
                    <button type="submit" class="btn">Add Venue</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script src="<?php echo PROJECT_URL; ?>/public/js/venues.js"></script>
    <script>
        function showAddVenueModal() {
            document.getElementById('addVenueModal').style.display = 'flex';
        }
        
        function hideAddVenueModal() {
            document.getElementById('addVenueModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        const modal = document.getElementById('addVenueModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideAddVenueModal();
                }
            });
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const venueCards = document.querySelectorAll('.venue-card');
            
            venueCards.forEach(card => {
                const venueName = card.querySelector('h3').textContent.toLowerCase();
                const venueAddress = card.querySelector('.venue-detail span:nth-child(2)').textContent.toLowerCase();
                
                if (venueName.includes(searchTerm) || venueAddress.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Filter by capacity
        document.querySelector('.filter-select').addEventListener('change', function(e) {
            const filter = e.target.value;
            const venueCards = document.querySelectorAll('.venue-card');
            
            venueCards.forEach(card => {
                const capacity = parseInt(card.dataset.capacity);
                let show = false;
                
                if (!filter) {
                    show = true;
                } else if (filter === 'small' && capacity <= 50) {
                    show = true;
                } else if (filter === 'medium' && capacity > 50 && capacity <= 200) {
                    show = true;
                } else if (filter === 'large' && capacity > 200) {
                    show = true;
                }
                
                card.style.display = show ? 'block' : 'none';
            });
        });
    </script>
