<?php
// simple jump-off grid for admin sections
$title = 'Admin · Dashboard';
?>
<div class="row g-3">
  <div class="col-sm-4">
    <a class="card text-decoration-none" href="<?php echo PROJECT_URL; ?>/Index.php?admin/events">
      <div class="card-body"><h5 class="card-title">Manage Events</h5></div>
    </a>
  </div>
  <div class="col-sm-4">
    <a class="card text-decoration-none" href="<?php echo PROJECT_URL; ?>/Index.php?admin/venues">
      <div class="card-body"><h5 class="card-title">Manage Venues</h5></div>
    </a>
  </div>
  <div class="col-sm-4">
    <a class="card text-decoration-none" href="<?php echo PROJECT_URL; ?>/Index.php?admin/users">
      <div class="card-body"><h5 class="card-title">Manage Users</h5></div>
    </a>
  </div>
</div>
