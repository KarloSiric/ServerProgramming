<?php
// fake users for milestone; edit/delete intentionally disabled
$title = 'Admin · Users';

$users = [
  ['attendee_id'=>1,'first_name'=>'Gordon','last_name'=>'Freeman','email'=>'crowbar@blackmesa.com','username'=>'admin','role'=>'admin'],
  ['attendee_id'=>2,'first_name'=>'Geralt','last_name'=>'of Rivia','email'=>'witcher@kaermorhen.com','username'=>'geralt','role'=>'attendee'],
];
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 m-0">Manage Users</h2>
  <a class="btn btn-primary" href="#">Add User</a>
</div>
<table class="table table-dark table-hover align-middle">
  <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th class="text-end">Actions</th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['first_name'].' '.$u['last_name']) ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><span class="badge bg-<?= $u['role']==='admin' ? 'primary' : 'secondary' ?>"><?= htmlspecialchars($u['role']) ?></span></td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary" disabled>Edit</button>
          <button class="btn btn-sm btn-outline-danger" disabled>Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
