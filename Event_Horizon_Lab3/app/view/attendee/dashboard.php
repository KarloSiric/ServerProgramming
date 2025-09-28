<div class="card" style="max-width: 800px; margin: 3rem auto;">
    <h2 style="font-size: 2.5rem; text-align: center; margin-bottom: 2rem;">
        🌟 Welcome to Your Portal, <?= htmlspecialchars($user['first_name']) ?>!
    </h2>
    
    <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%); border-radius: 16px; margin-bottom: 2rem;">
        <p style="font-size: 1.2rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
            Your personalized attendee dashboard for Event Horizon
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
            <span style="background: var(--primary-gradient); color: white; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600;">
                📊 Active Status
            </span>
            <span style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600;">
                ✨ Member Since <?= date('Y') ?>
            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;">
        <a href="Index.php?controller=event&action=index" 
           style="display: flex; flex-direction: column; align-items: center; padding: 2rem; background: white; border: 2px solid var(--border-light); border-radius: 16px; text-decoration: none; transition: all 0.3s ease; text-align: center;">
            <span style="font-size: 3rem; margin-bottom: 1rem;">🎉</span>
            <span style="color: var(--text-primary); font-weight: 700; font-size: 1.1rem;">Browse Events</span>
            <span style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.5rem;">Discover and join exciting events</span>
        </a>
        
        <a href="Index.php?controller=user&action=logout" 
           style="display: flex; flex-direction: column; align-items: center; padding: 2rem; background: white; border: 2px solid var(--border-light); border-radius: 16px; text-decoration: none; transition: all 0.3s ease; text-align: center;">
            <span style="font-size: 3rem; margin-bottom: 1rem;">🚪</span>
            <span style="color: var(--text-primary); font-weight: 700; font-size: 1.1rem;">Sign Out</span>
            <span style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.5rem;">Securely logout from your account</span>
        </a>
    </div>

    <style>
        a:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-purple) !important;
        }
    </style>
</div>
