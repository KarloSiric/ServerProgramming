<div class="todo-container">
    <div class="todo-card">
        <div class="todo-header">
            <span class="todo-icon">🚧</span>
            <h1 class="todo-title">TODO</h1>
            <span class="todo-icon">🚧</span>
        </div>
        
        <div class="todo-content">
            <div class="event-info-badge">
                <span class="badge-label">Event ID:</span>
                <span class="badge-value">#<?= (int)($eventId ?? $_GET['id'] ?? 0) ?></span>
            </div>
            
            <div class="todo-message">
                <h2>Attendee Management System</h2>
                <p class="todo-status">🔨 Under Construction</p>
                <p class="todo-description">
                    This feature is currently being developed and will be available in the next milestone.
                </p>
            </div>
            
            <div class="feature-preview">
                <h3>Coming Soon:</h3>
                <div class="feature-grid">
                    <div class="feature-item">
                        <span class="feature-emoji">📋</span>
                        <span>Complete attendee list</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">✉️</span>
                        <span>Email notifications</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">📊</span>
                        <span>Attendance analytics</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">🎫</span>
                        <span>Check-in system</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">📱</span>
                        <span>QR code scanning</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">💳</span>
                        <span>Payment tracking</span>
                    </div>
                </div>
            </div>
            
            <div class="progress-indicator">
                <span class="progress-label">Development Progress</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 35%;"></div>
                </div>
                <span class="progress-text">35% Complete</span>
            </div>
        </div>
        
        <div class="todo-footer">
            <a href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=user&action=admin" 
               class="back-button">
                <span>←</span> Back to Admin Panel
            </a>
            <button class="notify-button" onclick="alert('You will be notified when this feature is ready!')">
                🔔 Notify Me When Ready
            </button>
        </div>
    </div>
    
    <!-- Decorative elements -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
</div>

<style>
/* Using the same styles from event/attendees.php */
.todo-container {
    min-height: calc(100vh - 300px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 2rem;
}

.todo-card {
    background: white;
    border-radius: 32px;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.15);
    max-width: 800px;
    width: 100%;
    overflow: hidden;
    position: relative;
    animation: slideUp 0.6s ease-out;
}

.todo-header {
    background: var(--primary-gradient);
    color: white;
    padding: 3rem 2rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    position: relative;
    overflow: hidden;
}

.todo-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 10px,
        rgba(255, 255, 255, 0.05) 10px,
        rgba(255, 255, 255, 0.05) 20px
    );
    animation: slide 20s linear infinite;
}

@keyframes slide {
    0% {
        transform: translate(0, 0);
    }
    100% {
        transform: translate(50px, 50px);
    }
}

.todo-icon {
    font-size: 3rem;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.todo-title {
    font-size: 4rem;
    font-weight: 900;
    letter-spacing: 2px;
    margin: 0;
    position: relative;
    z-index: 1;
}

.todo-content {
    padding: 3rem 2rem;
}

.event-info-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    margin-bottom: 2rem;
}

.badge-label {
    color: var(--text-secondary);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.badge-value {
    color: var(--accent-purple);
    font-weight: 900;
    font-size: 1.1rem;
}

.todo-message {
    text-align: center;
    margin-bottom: 3rem;
}

.todo-message h2 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 2rem;
}

.todo-status {
    color: var(--warning);
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.todo-description {
    color: var(--text-secondary);
    font-size: 1.1rem;
    line-height: 1.6;
}

.feature-preview {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
}

.feature-preview h3 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    text-align: center;
    font-size: 1.3rem;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    border: 2px solid var(--border-light);
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent-purple);
}

.feature-emoji {
    font-size: 1.5rem;
}

.progress-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    margin-top: 2rem;
}

.progress-label {
    color: var(--text-secondary);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.progress-bar {
    width: 100%;
    max-width: 400px;
    height: 12px;
    background: var(--border-light);
    border-radius: 50px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--primary-gradient);
    border-radius: 50px;
    position: relative;
    animation: progressPulse 2s ease-in-out infinite;
}

@keyframes progressPulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.progress-text {
    color: var(--accent-purple);
    font-weight: 700;
}

.todo-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-top: 2px solid var(--border-light);
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 2px solid var(--border-light);
    border-radius: 50px;
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-button:hover {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
    transform: translateX(-5px);
}

.notify-button {
    padding: 0.75rem 1.5rem;
    background: var(--secondary-gradient);
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.notify-button:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: -1;
}

.shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
}

.shape-1 {
    width: 200px;
    height: 200px;
    background: var(--primary-gradient);
    top: 10%;
    left: -100px;
    animation: float 15s ease-in-out infinite;
}

.shape-2 {
    width: 150px;
    height: 150px;
    background: var(--secondary-gradient);
    bottom: 10%;
    right: -75px;
    animation: float 20s ease-in-out infinite reverse;
}

.shape-3 {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    top: 50%;
    right: 10%;
    animation: float 10s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-30px) rotate(180deg);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .todo-title {
        font-size: 3rem;
    }
    
    .todo-header {
        gap: 1rem;
        padding: 2rem 1rem;
    }
    
    .feature-grid {
        grid-template-columns: 1fr;
    }
    
    .todo-footer {
        flex-direction: column;
        gap: 1rem;
    }
    
    .back-button,
    .notify-button {
        width: 100%;
        justify-content: center;
    }
}
</style>
