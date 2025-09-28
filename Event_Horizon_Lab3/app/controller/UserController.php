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
        session_destroy();
        $this->redirect('user', 'login');
    }
}
