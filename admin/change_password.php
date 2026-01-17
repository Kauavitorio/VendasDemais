<?php
require_once 'auth.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $usersFile = '../data/users.json';
    
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true);
        $found = false;
        
        foreach ($users as &$user) {
            if ($user['username'] === $_SESSION['user']) {
                if (password_verify($current, $user['password'])) {
                    $user['password'] = password_hash($new, PASSWORD_DEFAULT);
                    $found = true;
                } else {
                    $error = 'Senha atual incorreta.';
                }
                break;
            }
        }
        
        if ($found) {
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
            $success = 'Senha alterada com sucesso!';
        } else if (!$error) {
            $error = 'Usuário não encontrado.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Senha | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #111; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card { background: #222; border-color: #333; color: #fff; max-width: 400px; width: 100%; }
        .form-control { background: #333; border-color: #444; color: #fff; }
        .form-control:focus { background: #333; color: #fff; border-color: #dc2626; box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25); }
    </style>
</head>
<body>
    <div class="card p-4">
        <h3 class="mb-4">Alterar Senha</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label>Senha Atual</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nova Senha</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Salvar</button>
            <a href="index.php" class="btn btn-outline-light w-100">Voltar</a>
        </form>
    </div>
</body>
</html>
