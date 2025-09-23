<?php
// demo login: username "admin" grants admin role; everything else is attendee
$title = 'Login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $role = (strtolower($username) === 'admin') ? 'admin' : 'attendee';
  $_SESSION['user'] = [
    'first_name' => ($role==='admin' ? 'Gordon' : 'Ciri'),
    'last_name'  => ($role==='admin' ? 'Freeman' : 'of Cintra'),
    'username'   => $username,
    'role'       => $role
  ];
  flash('success', 'Logged in.');
  header('Location: ' . PROJECT_URL . '/Index.php?event/index'); exit;
}
?>
<form method="post" class="mx-auto" style="max-width:420px">
  <h2 class="h4 mb-3">Login</h2>
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input class="form-control" name="username" minlength="3" maxlength="16" placeholder="e.g., admin or geralt" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input class="form-control" type="password" name="password" minlength="6" placeholder="hunter2" required>
  </div>
  <button class="btn btn-primary w-100">Sign in</button>
</form>
