<?php
require_once 'session.php';
require_once 'auth.php';

$linksFile = '../data/links.json';
$links = file_exists($linksFile) ? json_decode(file_get_contents($linksFile), true) : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Links | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>body { background: #111; color: #fff; }</style>
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Links e Redes</h2>
            <div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#linkModal" onclick="clearForm()">+ Novo Link</button>
                <a href="index.php" class="btn btn-outline-light ms-2">Voltar</a>
            </div>
        </div>

        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Link</th>
                    <th>Estilo (Classe CSS)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($links as $l): ?>
                <tr>
                    <td>
                        <?php if($l['type'] == 'social'): ?>
                            <span class="badge bg-info">Rede Social</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Grupo</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($l['name']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($l['link']); ?>" target="_blank" class="text-white"><?php echo htmlspecialchars($l['link']); ?></a></td>
                    <td><code><?php echo htmlspecialchars($l['style']); ?></code></td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick='editLink(<?php echo json_encode($l); ?>)'>Editar</button>
                        <a href="delete_link.php?id=<?php echo $l['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="linkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <form action="save_link.php" method="post">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title">Link / Rede Social</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label>Tipo</label>
                            <select name="type" id="type" class="form-select bg-secondary text-white">
                                <option value="social">Rede Social</option>
                                <option value="group">Grupo de Links</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nome (Texto do Botão)</label>
                            <input type="text" name="name" id="name" class="form-control bg-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label>Link URL</label>
                            <input type="text" name="link" id="link" class="form-control bg-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label>Estilo CSS (Opcional)</label>
                            <input type="text" name="style" id="style" class="form-control bg-secondary text-white" placeholder="Ex: btn-tiktok, btn-instagram, btn-secondary">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const linkModal = new bootstrap.Modal(document.getElementById('linkModal'));
        
        function clearForm() {
            document.getElementById('id').value = '';
            document.getElementById('type').value = 'social';
            document.getElementById('name').value = '';
            document.getElementById('link').value = '';
            document.getElementById('style').value = '';
        }

        function editLink(l) {
            document.getElementById('id').value = l.id;
            document.getElementById('type').value = l.type;
            document.getElementById('name').value = l.name;
            document.getElementById('link').value = l.link;
            document.getElementById('style').value = l.style || '';
            linkModal.show();
        }
    </script>
</body>
</html>
