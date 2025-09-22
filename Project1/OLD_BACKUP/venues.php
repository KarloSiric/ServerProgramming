<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];

// Sample venues data
$venues = [
    [
        'id' => 1,
        'name' => 'Grand Convention Center',
        'capacity' => 500,
        'location' => 'Downtown District',
        'price' => 1200,
        'rating' => 4.8,
        'amenities' => ['WiFi', 'Parking', 'Catering', 'A/V Equipment']
    ],
    [
        'id' => 2,
        'name' => 'Business Hub',
        'capacity' => 100,
        'location' => 'Business District',
        'price' => 300,
        'rating' => 4.5,
        'amenities' => ['WiFi', 'Projector', 'Coffee', 'Whiteboard']
    ],
    [
        'id' => 3,
        'name' => 'Creative Space',
        'capacity' => 50,
        'location' => 'Arts Quarter',
        'price' => 150,
        'rating' => 4.9,
        'amenities' => ['WiFi', 'Art Supplies', 'Natural Light', 'Flexible Layout']
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venues - EventPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">EventPro</a>
            <ul class="nav-links">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="venues.php" class="active">Venues</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <div class="content-card">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Venues</h1>
                    <p class="page-subtitle">Find and book the perfect venue for your event</p>
                </div>
                <button class="btn" onclick="showAddVenueModal()">+ Add Venue</button>
            </div>
            
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
                <?php foreach ($venues as $venue): ?>
                <div class="venue-card">
                    <div class="venue-image">
                        <div class="venue-placeholder">🏢</div>
                        <div class="venue-rating">
                            <span>⭐ <?php echo $venue['rating']; ?></span>
                        </div>
                    </div>
                    <div class="venue-info">
                        <h3><?php echo htmlspecialchars($venue['name']); ?></h3>
                        <div class="venue-details">
                            <div class="venue-detail">
                                <span class="detail-icon">📍</span>
                                <span><?php echo htmlspecialchars($venue['location']); ?></span>
                            </div>
                            <div class="venue-detail">
                                <span class="detail-icon">👥</span>
                                <span>Up to <?php echo $venue['capacity']; ?> people</span>
                            </div>
                            <div class="venue-detail">
                                <span class="detail-icon">💰</span>
                                <span>$<?php echo $venue['price']; ?>/day</span>
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
                            <button class="btn btn-outline">View Details</button>
                            <button class="btn">Book Now</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add Venue Modal -->
    <div id="addVenueModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Venue</h3>
                <button class="close-btn" onclick="hideAddVenueModal()">&times;</button>
            </div>
            <form class="modal-form">
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Venue name" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="number" class="form-input" placeholder="Capacity" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-input" placeholder="Price per day" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Location" required>
                </div>
                <div class="form-group">
                    <textarea class="form-input" placeholder="Amenities (comma separated)" rows="2"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="hideAddVenueModal()">Cancel</button>
                    <button type="submit" class="btn">Add Venue</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddVenueModal() {
            document.getElementById('addVenueModal').style.display = 'flex';
        }
        
        function hideAddVenueModal() {
            document.getElementById('addVenueModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        document.getElementById('addVenueModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideAddVenueModal();
            }
        });
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const venueCards = document.querySelectorAll('.venue-card');
            
            venueCards.forEach(card => {
                const venueName = card.querySelector('h3').textContent.toLowerCase();
                const venueLocation = card.querySelector('.venue-detail span:nth-child(2)').textContent.toLowerCase();
                
                if (venueName.includes(searchTerm) || venueLocation.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
