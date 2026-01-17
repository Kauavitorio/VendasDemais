<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $usersFile = '../data/users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true);
        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                header('Location: index.php');
                exit;
            }
        }
    }
    $error = 'Usuário ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #111; color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #222; border-color: #333; color: #fff; max-width: 400px; width: 100%; }
        .form-control { background: #333; border-color: #444; color: #fff; }
        .form-control:focus { background: #333; color: #fff; border-color: #dc2626; box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25); }
        .btn-primary { background: #dc2626; border-color: #dc2626; }
        .btn-primary:hover { background: #b91c1c; border-color: #b91c1c; }
    </style>
</head>
<body>
    <div class="card p-4">
        <h3 class="text-center mb-4">Admin Login</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</body>
</html>
