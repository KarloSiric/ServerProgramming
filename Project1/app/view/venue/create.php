<div class="main-content">
    <div class="card admin-card">
        <div class="card-header">
            <h2>Add New Venue</h2>
        </div>
        <div class="card-body">
            <a href="/venue/list" class="btn btn-outline">Back to Venues</a>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Venue Details</h3>
        </div>
        <div class="card-body">
            <form method="post" action="/venue/store">
                <div class="form-group">
                    <label for="name" class="form-label">Venue Name</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           placeholder="Venue name" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3" 
                              placeholder="Venue description"></textarea>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" id="capacity" name="capacity" class="form-control" 
                               placeholder="100" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label">Venue Type</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Convention Center">Convention Center</option>
                            <option value="Conference Room">Conference Room</option>
                            <option value="Workshop Space">Workshop Space</option>
                            <option value="Event Hall">Event Hall</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" 
                           placeholder="City, State" required>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-success">Add Venue</button>
                    <a href="/venue/list" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
