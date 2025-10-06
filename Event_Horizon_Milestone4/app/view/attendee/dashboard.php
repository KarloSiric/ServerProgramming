<div class="card" style="max-width: 800px; margin: 3rem auto;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <div style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1rem; border-radius: 50%; margin-bottom: 1rem;">
            <span style="font-size: 3rem;">👤</span>
        </div>
        <h2 style="font-size: 2.5rem; margin-bottom: 0.5rem;">
            Welcome, <?= htmlspecialchars($user['username'] ?? 'User') ?>!
        </h2>
        <p style="color: var(--text-secondary); font-size: 1.1rem;">Your personalized attendee portal</p>
    </div>
    
    <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem;">
        <span style="background: var(--primary-gradient); color: white; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600; font-size: 0.9rem;">
            📊 Active Status
        </span>
        <span style="background: linear-gradient(135deg, #48bb78 0%, #4299e1 100%); color: white; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600; font-size: 0.9rem;">
            ✨ Member Since <?= date('Y') ?>
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <a href="<?= PROJECT_URL ?>/event/all" 
           style="display: flex; flex-direction: column; align-items: center; background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%); border-radius: 20px; padding: 2rem; text-decoration: none; transition: all 0.3s ease; border: 2px solid #48bb78;">
            <span style="font-size: 3.5rem; margin-bottom: 1rem;">🎉</span>
            <span style="color: var(--text-primary); font-weight: 700; font-size: 1.2rem; margin-bottom: 0.5rem;">Browse Events</span>
            <span style="color: var(--text-secondary); font-size: 0.95rem; text-align: center;">Discover and register for exciting events</span>
        </a>
        
        <a href="<?= PROJECT_URL ?>/user/logout" 
           style="display: flex; flex-direction: column; align-items: center; background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(237, 137, 54, 0.1) 100%); border-radius: 20px; padding: 2rem; text-decoration: none; transition: all 0.3s ease; border: 2px solid #f56565;">
            <span style="font-size: 3.5rem; margin-bottom: 1rem;">🚪</span>
            <span style="color: var(--text-primary); font-weight: 700; font-size: 1.2rem; margin-bottom: 0.5rem;">Sign Out</span>
            <span style="color: var(--text-secondary); font-size: 0.95rem; text-align: center;">End your session securely</span>
        </a>
    </div>

    <div style="margin-top: 2rem; padding: 1.5rem; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%); border-radius: 16px; border: 2px solid var(--border-light);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="font-size: 2rem;">💡</span>
            <div>
                <strong style="color: var(--text-primary); display: block; margin-bottom: 0.25rem;">Quick Tip</strong>
                <span style="color: var(--text-secondary); font-size: 0.95rem;">Browse upcoming events and register with one click. You can always unregister if plans change!</span>
            </div>
        </div>
    </div>
</div>

<style>
.card a:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
</style>
