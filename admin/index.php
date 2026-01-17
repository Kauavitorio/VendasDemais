<?php
require_once 'auth.php';
$productsFile = '../data/products.json';
$products = file_exists($productsFile) ? json_decode(file_get_contents($productsFile), true) : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #111; color: #fff; }
        .table { color: #fff; }
        .table img { max-height: 50px; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Produtos</h2>
            <div>
                <a href="links.php" class="btn btn-info me-2">Gerenciar Links</a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal" onclick="clearForm()">+ Novo Produto</button>
                <a href="change_password.php" class="btn btn-secondary ms-2">Alterar Senha</a>
                <a href="logout.php" class="btn btn-outline-light ms-2">Sair</a>
            </div>
        </div>

        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>Img</th>
                    <th>Nome</th>
                    <th>Tags</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($p['image']); ?>" alt="img"></td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo implode(', ', $p['tags'] ?? []); ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick='editProduct(<?php echo json_encode($p); ?>)'>Editar</button>
                        <a href="delete.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <form action="save.php" method="post">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title">Produto</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label>Nome</label>
                            <input type="text" name="name" id="name" class="form-control bg-secondary text-white" required>
                        </div>
                        <!-- Price Removed -->
                        <div class="mb-3">
                            <label>Imagem URL</label>
                            <input type="text" name="image" id="image" class="form-control bg-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label>Descrição</label>
                            <textarea name="description" id="description" class="form-control bg-secondary text-white"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Tags (separadas por vírgula)</label>
                            <input type="text" name="tags" id="tags" class="form-control bg-secondary text-white">
                        </div>
                        <div class="mb-3">
                            <label>Link de Compra</label>
                            <input type="text" name="link" id="link" class="form-control bg-secondary text-white">
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
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));
        
        function clearForm() {
            document.getElementById('id').value = '';
            document.getElementById('name').value = '';
            document.getElementById('image').value = '';
            document.getElementById('description').value = '';
            document.getElementById('tags').value = '';
            document.getElementById('link').value = '';
        }

        function editProduct(p) {
            document.getElementById('id').value = p.id;
            document.getElementById('name').value = p.name;
            document.getElementById('image').value = p.image;
            document.getElementById('description').value = p.description || '';
            document.getElementById('tags').value = (p.tags || []).join(', ');
            document.getElementById('link').value = p.link || '';
            productModal.show();
        }
    </script>
</body>
</html>
