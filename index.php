<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Produtos</title>
  <link rel="stylesheet" href="/css/styles.css" />
</head>

<body>
  <a class="skip" href="#conteudo">Pular para o conteúdo</a>

  <header class="top">
    <div class="top-inner">
      <div class="brand">
        <img class="brand-img" src="./assets/header-1.png" alt="Imagem do topo 1" onerror="this.style.display='none'">
      </div>

      <nav class="social" aria-label="Redes sociais">
        <a class="social-link" href="#" target="_blank" rel="noreferrer">Instagram</a>
        <a class="social-link" href="#" target="_blank" rel="noreferrer">YouTube</a>
      </nav>

      <div class="brand">
        <img class="brand-img" src="./assets/header-2.png" alt="Imagem do topo 2" onerror="this.style.display='none'">
      </div>
    </div>
  </header>

  <main id="conteudo" class="container">
    <?php
    $linksData = 'data/links.json';
    $links = file_exists($linksData) ? json_decode(file_get_contents($linksData), true) : [];
    $socials = array_filter($links, fn($l) => $l['type'] === 'social');
    $groups = array_filter($links, fn($l) => $l['type'] === 'group');
    ?>
    <!-- REDES SOCIAIS -->
    <?php if(!empty($socials)): ?>
    <section class="block">
      <h2 class="kicker">MINHAS REDES</h2>
      <div class="social-actions">
        <?php foreach($socials as $s): ?>
        <a class="btn <?php echo htmlspecialchars($s['style'] ?? 'btn-secondary'); ?>" href="<?php echo htmlspecialchars($s['link']); ?>" target="_blank" rel="noreferrer">
          <?php echo htmlspecialchars($s['name']); ?>
        </a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- GRUPO DE LINKS -->
    <?php if(!empty($groups)): ?>
    <section class="block">
      <h2 class="kicker">GRUPO DE LINKS</h2>
      <?php foreach($groups as $g): ?>
      <a class="btn <?php echo htmlspecialchars($g['style'] ?? 'btn-secondary'); ?>" href="<?php echo htmlspecialchars($g['link']); ?>" target="_blank" rel="noreferrer">
        <?php echo htmlspecialchars($g['name']); ?>
      </a>
      <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <!-- CATEGORIAS -->
    <section class="block">
      <h2 class="kicker">CATEGORIAS</h2>
      <p style="margin:0 0 10px;color:var(--muted);font-size:13px;">Clique nas tags para filtrar:</p>
      <div id="tags-container" class="tags-cloud"></div>
    </section>

    <!-- LISTAGEM -->
    <section class="block">
      <div class="grid-head">
        <h2 class="kicker">PRODUTOS</h2>
        <div class="search">
          <input id="q" type="search" placeholder="Buscar produto..." />
        </div>
      </div>

      <div id="grid" class="grid" aria-live="polite"></div>

      <div class="pagination">
        <button id="prev" class="page-btn" type="button">◀</button>
        <div id="pages" class="pages"></div>
        <button id="next" class="page-btn" type="button">▶</button>
      </div>
    </section>
  </main>

  <footer class="footer">
    <small>&copy; <span id="year"></span> Vendas Demais — Todos os direitos reservados | <a href="/admin/">Admin</a></small>
  </footer>

  <?php
  $dataFile = 'data/products.json';
  $initialData = '[]';
  if (file_exists($dataFile)) {
    $initialData = file_get_contents($dataFile);
  }
  ?>
  <script>
    window.initialData = <?php echo $initialData; ?>;
  </script>
  <script src="./script.js"></script>
</body>

</html>