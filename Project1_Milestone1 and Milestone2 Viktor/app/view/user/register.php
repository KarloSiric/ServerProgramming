<?php
// demo register: bootstrap a fake attendee and redirect to list
$title = 'Register';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['user'] = [
    'first_name' => trim($_POST['first_name'] ?? 'Player'),
    'last_name'  => trim($_POST['last_name'] ?? 'One'),
    'username'   => trim($_POST['username'] ?? 'player1'),
    'role'       => 'attendee'
  ];
  flash('success', 'Account created and you are logged in.');
  header('Location: ' . PROJECT_URL . '/Index.php?event/index'); exit;
}
?>
<form method="post" class="mx-auto" style="max-width:520px">
  <h2 class="h4 mb-3">Create account</h2>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">First name</label>
      <input class="form-control" name="first_name" required maxlength="45" placeholder="Aloy">
    </div>
    <div class="col-md-6">
      <label class="form-label">Last name</label>
      <input class="form-control" name="last_name" required maxlength="45" placeholder="from Nora">
    </div>
    <div class="col-12">
      <label class="form-label">Email</label>
      <input class="form-control" type="email" name="email" required maxlength="50" placeholder="player@vaulttech.com">
    </div>
    <div class="col-md-6">
      <label class="form-label">Username</label>
      <input class="form-control" name="username" required minlength="3" maxlength="16" pattern="[A-Za-z0-9_]+" placeholder="chocobo_rider">
    </div>
    <div class="col-md-6">
      <label class="form-label">Password</label>
      <input class="form-control" type="password" name="password" required minlength="6" placeholder="s0n1cR!ngs">
    </div>
  </div>
  <button class="btn btn-primary w-100 mt-3">Sign up</button>
</form>
