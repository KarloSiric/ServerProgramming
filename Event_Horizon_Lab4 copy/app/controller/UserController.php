<?php

declare(strict_types=1);

class UserController extends Controller
{
  public function login(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'] ?? '';
      $password = $_POST['password'] ?? '';

      $model = new UserModel();
      $user = $model->authenticate($email, $password);

      if ($user) {
        // Optional hardening (safe to keep or omit):
        // session_regenerate_id(true);
        $_SESSION['user'] = $user;

        if ($user['role_name'] === 'admin') {
          $this->redirect('event', 'index');
        } elseif ($user['role_name'] === 'attendee') {
          $this->redirect('attendee', 'dashboard');
        } else {
          echo "<p>Unknown role: " . htmlspecialchars($user['role_name']) . "</p>";
        }
        return;
      } else {
        $error = "Invalid email or password.";
        $this->render('user/login.php', ['error' => $error]);
        return;
      }
    }

    $this->render('user/login.php');
  }

  public function logout(): void
  {
    // CHANGED per assignment: central Session::destroy() handles cleanup + redirect
    Session::destroy();
  }

  public function register(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $d = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'username'   => trim($_POST['username'] ?? ''),
        'password'   => $_POST['password'] ?? '',
      ];
      if (in_array('', $d, true)) {
        $this->render('user/register.php', ['error' => 'Please fill all fields.']);
        return;
      }
      try {
        (new UserModel())->register($d);
        // After register, push to login
        $this->render('user/login.php', ['error' => 'Account created. Please sign in.']);
        return;
      } catch (Throwable $e) {
        $this->render('user/register.php', ['error' => 'Email or username already in use.']);
        return;
      }
    }
    $this->render('user/register.php');
  }
}
