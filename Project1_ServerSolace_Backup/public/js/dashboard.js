// EventFlow Dashboard JavaScript
// Handles dashboard interactions and animations

document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard features
    initUserDropdown();
    initStatsAnimation();
    initActivityUpdates();
    
    // Add smooth animations to cards
    animateCards();
});

// User dropdown functionality
function initUserDropdown() {
    const userToggle = document.querySelector('.user-toggle');
    const userMenu = document.querySelector('.user-menu');
    
    if (userToggle && userMenu) {
        let isOpen = false;
        
        userToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (isOpen) {
                closeUserMenu();
            } else {
                openUserMenu();
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (isOpen && !userToggle.contains(e.target) && !userMenu.contains(e.target)) {
                closeUserMenu();
            }
        });
        
        function openUserMenu() {
            userMenu.style.opacity = '1';
            userMenu.style.visibility = 'visible';
            userMenu.style.transform = 'translateY(0)';
            isOpen = true;
        }
        
        function closeUserMenu() {
            userMenu.style.opacity = '0';
            userMenu.style.visibility = 'hidden';
            userMenu.style.transform = 'translateY(-10px)';
            isOpen = false;
        }
    }
}

// Animate stats cards on load
function initStatsAnimation() {
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animate numbers
    animateNumbers();
}

// Animate counting numbers in stats
function animateNumbers() {
    const numberElements = document.querySelectorAll('.stat-content h3');
    
    numberElements.forEach(element => {
        const target = parseInt(element.textContent.replace(/[^\d]/g, ''));
        if (isNaN(target)) return;
        
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = formatNumber(target);
                clearInterval(timer);
            } else {
                element.textContent = formatNumber(Math.floor(current));
            }
        }, 40);
    });
}

// Format numbers with proper separators
function formatNumber(num) {
    if (num >= 1000) {
        return num.toLocaleString();
    }
    return num.toString();
}

// Simulate real-time activity updates
function initActivityUpdates() {
    // Simulate new activities every 30 seconds
    setInterval(() => {
        addNewActivity();
    }, 30000);
}

// Add new activity item
function addNewActivity() {
    const activities = [
        {
            icon: 'fas fa-user-plus',
            text: '<strong>Jane Smith</strong> registered for "Web Development Bootcamp"',
            time: 'Just now'
        },
        {
            icon: 'fas fa-calendar-plus',
            text: 'New event <strong>"AI Workshop"</strong> was created',
            time: '1 minute ago'
        },
        {
            icon: 'fas fa-edit',
            text: '<strong>"Marketing Workshop"</strong> details updated',
            time: '2 minutes ago'
        }
    ];
    
    const activityList = document.querySelector('.activity-list');
    if (!activityList) return;
    
    const randomActivity = activities[Math.floor(Math.random() * activities.length)];
    
    const activityItem = document.createElement('div');
    activityItem.className = 'activity-item';
    activityItem.style.opacity = '0';
    activityItem.style.transform = 'translateX(-20px)';
    
    activityItem.innerHTML = `
        <div class="activity-icon">
            <i class="${randomActivity.icon}"></i>
        </div>
        <div class="activity-content">
            <p>${randomActivity.text}</p>
            <span class="activity-time">${randomActivity.time}</span>
        </div>
    `;
    
    // Add to top of list
    activityList.insertBefore(activityItem, activityList.firstChild);
    
    // Animate in
    setTimeout(() => {
        activityItem.style.transition = 'all 0.3s ease-out';
        activityItem.style.opacity = '1';
        activityItem.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove oldest if more than 5 activities
    const activityItems = activityList.querySelectorAll('.activity-item');
    if (activityItems.length > 5) {
        const oldest = activityItems[activityItems.length - 1];
        oldest.style.transition = 'all 0.3s ease-out';
        oldest.style.opacity = '0';
        oldest.style.transform = 'translateX(20px)';
        
        setTimeout(() => {
            activityList.removeChild(oldest);
        }, 300);
    }
}

// Animate cards on scroll or load
function animateCards() {
    const cards = document.querySelectorAll('.dashboard-section, .event-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `all 0.6s ease-out ${index * 0.1}s`;
        
        observer.observe(card);
    });
}

// Quick action handlers
function initQuickActions() {
    const createEventBtn = document.querySelector('.quick-actions .btn-primary');
    const addVenueBtn = document.querySelector('.quick-actions .btn-outline');
    
    if (createEventBtn) {
        createEventBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showCreateEventModal();
        });
    }
    
    if (addVenueBtn) {
        addVenueBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showAddVenueModal();
        });
    }
}

// Mock modal functions (would be replaced with actual modals)
function showCreateEventModal() {
    alert('Create Event modal would open here');
}

function showAddVenueModal() {
    alert('Add Venue modal would open here');
}

// Utility function to format dates
function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Utility function to format time
function formatTime(time) {
    return new Date(`1970-01-01T${time}`).toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}
