// EventFlow Venues Page JavaScript
// Handles venues page functionality

document.addEventListener('DOMContentLoaded', function() {
    initVenueFilters();
    initVenueSearch();
    initVenueActions();
    initVenueCards();
    initLoadMore();
});

// Initialize search functionality
function initVenueSearch() {
    const searchInput = document.querySelector('.search-box input');
    const venueCards = document.querySelectorAll('.venue-card');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const query = e.target.value.toLowerCase().trim();
            
            searchTimeout = setTimeout(() => {
                filterVenuesBySearch(query, venueCards);
            }, 300);
        });
    }
}

// Filter venues by search query
function filterVenuesBySearch(query, venueCards) {
    let visibleCount = 0;
    
    venueCards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const location = card.querySelector('.venue-location span').textContent.toLowerCase();
        const type = card.querySelector('.venue-type').textContent.toLowerCase();
        const amenities = Array.from(card.querySelectorAll('.amenity-tag')).map(tag => tag.textContent.toLowerCase()).join(' ');
        
        const matches = !query || 
            name.includes(query) || 
            location.includes(query) || 
            type.includes(query) || 
            amenities.includes(query);
        
        if (matches) {
            card.style.display = 'block';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            }, visibleCount * 50);
            
            visibleCount++;
        } else {
            card.style.transition = 'all 0.3s ease-out';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
    
    updateVenueResultsCount(query, visibleCount);
}

// Update results count for venues
function updateVenueResultsCount(query, count) {
    let resultsIndicator = document.querySelector('.venue-search-results');
    if (!resultsIndicator) {
        resultsIndicator = document.createElement('div');
        resultsIndicator.className = 'venue-search-results';
        resultsIndicator.style.cssText = `
            margin: 1rem 0;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        `;
        
        const venuesGrid = document.querySelector('.venues-grid');
        venuesGrid.parentNode.insertBefore(resultsIndicator, venuesGrid);
    }
    
    if (query) {
        resultsIndicator.innerHTML = `
            <i class="fas fa-search" style="margin-right: 0.5rem;"></i>
            Found <strong>${count}</strong> venues matching "<strong>${query}</strong>"
        `;
        resultsIndicator.style.display = 'block';
    } else {
        resultsIndicator.style.display = 'none';
    }
}

// Initialize filter dropdowns
function initVenueFilters() {
    const typeFilter = document.querySelector('.filter-select:first-child');
    const capacityFilter = document.querySelector('.filter-select:nth-child(2)');
    
    if (typeFilter) {
        typeFilter.addEventListener('change', function() {
            filterVenues();
        });
    }
    
    if (capacityFilter) {
        capacityFilter.addEventListener('change', function() {
            filterVenues();
        });
    }
}

// Apply filters to venues
function filterVenues() {
    const typeFilter = document.querySelector('.filter-select:first-child');
    const capacityFilter = document.querySelector('.filter-select:nth-child(2)');
    const venueCards = document.querySelectorAll('.venue-card');
    
    const selectedType = typeFilter ? typeFilter.value.toLowerCase() : '';
    const selectedCapacity = capacityFilter ? capacityFilter.value : '';
    
    let visibleCount = 0;
    
    venueCards.forEach(card => {
        const type = card.querySelector('.venue-type').textContent.toLowerCase().replace(' ', '-');
        const capacityText = card.querySelector('.detail-item:first-child span').textContent;
        const capacity = parseInt(capacityText.match(/\d+/)[0]);
        
        const typeMatch = !selectedType || type.includes(selectedType);
        let capacityMatch = true;
        
        if (selectedCapacity) {
            switch(selectedCapacity) {
                case 'small':
                    capacityMatch = capacity <= 50;
                    break;
                case 'medium':
                    capacityMatch = capacity > 50 && capacity <= 200;
                    break;
                case 'large':
                    capacityMatch = capacity > 200 && capacity <= 500;
                    break;
                case 'xl':
                    capacityMatch = capacity > 500;
                    break;
            }
        }
        
        if (typeMatch && capacityMatch) {
            card.style.display = 'block';
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, visibleCount * 100);
            
            visibleCount++;
        } else {
            card.style.transition = 'all 0.3s ease-out';
            card.style.opacity = '0';
            card.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
}

// Initialize venue card actions
function initVenueActions() {
    const venueCards = document.querySelectorAll('.venue-card');
    
    venueCards.forEach(card => {
        // Book venue button
        const bookBtn = card.querySelector('.btn-primary');
        if (bookBtn) {
            bookBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const venueName = card.querySelector('h3').textContent;
                bookVenue(venueName);
            });
        }
        
        // View details button
        const viewBtn = card.querySelector('.btn:has(.fa-eye)');
        if (viewBtn) {
            viewBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const venueName = card.querySelector('h3').textContent;
                viewVenueDetails(venueName);
            });
        }
        
        // Save button
        const saveBtn = card.querySelector('.btn:has(.fa-heart)');
        if (saveBtn) {
            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSaveVenue(this, card);
            });
        }
        
        // Share button
        const shareBtn = card.querySelector('.btn:has(.fa-share)');
        if (shareBtn) {
            shareBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const venueName = card.querySelector('h3').textContent;
                shareVenue(venueName);
            });
        }
    });
}

// Venue action functions
function bookVenue(venueName) {
    // Create booking modal simulation
    const modal = createBookingModal(venueName);
    document.body.appendChild(modal);
    
    // Animate in
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.querySelector('.booking-modal').style.transform = 'scale(1)';
    }, 10);
}

function createBookingModal(venueName) {
    const modal = document.createElement('div');
    modal.className = 'booking-modal-overlay';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease-out;
    `;
    
    modal.innerHTML = `
        <div class="booking-modal" style="
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease-out;
        ">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: #1e293b;">Book ${venueName}</h3>
                <button class="close-modal" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
            </div>
            <form>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Event Date</label>
                    <input type="date" required style="width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.5rem;">
                </div>
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Start Time</label>
                        <input type="time" required style="width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">End Time</label>
                        <input type="time" required style="width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Expected Attendees</label>
                    <input type="number" min="1" required style="width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.5rem;">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" class="cancel-booking" style="flex: 1; padding: 0.75rem; background: #f1f5f9; color: #64748b; border: none; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="flex: 2; padding: 0.75rem; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 500;">Book Venue</button>
                </div>
            </form>
        </div>
    `;
    
    // Close modal handlers
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = modal.querySelector('.cancel-booking');
    
    closeBtn.addEventListener('click', () => closeModal(modal));
    cancelBtn.addEventListener('click', () => closeModal(modal));
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal(modal);
        }
    });
    
    // Form submission
    const form = modal.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        closeModal(modal);
        showNotification(`Booking request sent for ${venueName}!`, 'success');
    });
    
    return modal;
}

function closeModal(modal) {
    modal.style.opacity = '0';
    modal.querySelector('.booking-modal').style.transform = 'scale(0.9)';
    
    setTimeout(() => {
        if (modal.parentNode) {
            modal.parentNode.removeChild(modal);
        }
    }, 300);
}

function viewVenueDetails(venueName) {
    showNotification(`Opening details for ${venueName}`, 'info');
    // In a real app, this would show detailed venue information
}

function toggleSaveVenue(button, card) {
    const icon = button.querySelector('i');
    const venueName = card.querySelector('h3').textContent;
    
    if (icon.classList.contains('fa-heart')) {
        // Already saved, remove from saved
        icon.classList.remove('fa-heart');
        icon.classList.add('fa-heart-o');
        button.style.color = '#64748b';
        showNotification(`Removed ${venueName} from saved venues`, 'info');
    } else {
        // Not saved, add to saved
        icon.classList.remove('fa-heart-o');
        icon.classList.add('fa-heart');
        button.style.color = '#ef4444';
        showNotification(`Saved ${venueName} to favorites`, 'success');
    }
}

function shareVenue(venueName) {
    if (navigator.share) {
        navigator.share({
            title: venueName,
            text: `Check out this venue: ${venueName}`,
            url: window.location.href
        });
    } else {
        // Fallback - copy to clipboard
        const shareText = `Check out this venue: ${venueName} - ${window.location.href}`;
        navigator.clipboard.writeText(shareText).then(() => {
            showNotification('Venue details copied to clipboard!', 'success');
        });
    }
}

// Initialize venue cards with animations
function initVenueCards() {
    const venueCards = document.querySelectorAll('.venue-card');
    
    // Animate cards on load
    venueCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
    
    // Enhanced hover effects
    venueCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.15)';
            
            // Animate venue image
            const image = this.querySelector('.venue-image');
            if (image) {
                image.style.transform = 'scale(1.05)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
            
            // Reset venue image
            const image = this.querySelector('.venue-image');
            if (image) {
                image.style.transform = 'scale(1)';
            }
        });
    });
}

// Initialize load more functionality
function initLoadMore() {
    const loadMoreBtn = document.querySelector('.load-more-section .btn');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loadMoreVenues();
        });
    }
}

// Load more venues function
function loadMoreVenues() {
    const loadMoreBtn = document.querySelector('.load-more-section .btn');
    const originalText = loadMoreBtn.innerHTML;
    
    // Show loading state
    loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    loadMoreBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Reset button
        loadMoreBtn.innerHTML = originalText;
        loadMoreBtn.disabled = false;
        
        // Show notification
        showNotification('More venues loaded!', 'success');
    }, 1500);
}

// Add new venue function
function addNewVenue() {
    showNotification('Add New Venue form would open here', 'info');
    // In a real app, this would open a venue creation form
}

// Utility function to show notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#06b6d4'};
        color: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
        max-width: 320px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    `;
    
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    notification.innerHTML = `<i class="fas ${icon}"></i>${message}`;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Export functions for global use
window.VenuesPage = {
    addNewVenue,
    bookVenue,
    showNotification
};
