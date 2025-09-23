<?php
// venues list only; no CRUD yet for milestone
$title = 'Admin · Venues';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 m-0">Manage Venues</h2>
  <a class="btn btn-primary" href="#">Add Venue</a>
</div>
<table class="table table-dark table-hover align-middle">
  <thead><tr><th>Name</th><th>Capacity</th><th class="text-end">Actions</th></tr></thead>
  <tbody>
    <?php foreach ($venues as $v): ?>
      <tr>
        <td><?= htmlspecialchars($v['name']) ?></td>
        <td><?= (int)$v['capacity'] ?></td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary" disabled>Edit</button>
          <button class="btn btn-sm btn-outline-danger" disabled>Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
