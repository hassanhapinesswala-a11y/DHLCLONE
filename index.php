<?php
require_once 'db.php';
 
// fetch featured
$featured = $pdo->query("SELECT * FROM articles WHERE featured=1 ORDER BY published_at DESC LIMIT 3")->fetchAll();
 
// latest / breaking
$latest = $pdo->query("SELECT * FROM articles ORDER BY published_at DESC LIMIT 6")->fetchAll();
 
// categories
$cats = $pdo->query("SELECT * FROM categories ORDER BY id")->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>DHLClone - Home</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* INTERNAL CSS - modern, polished */
    :root{--accent:#ff3b30;--muted:#6b7280;--bg:#0f1724}
    *{box-sizing:border-box;font-family:Inter, system-ui, Arial}
    body{margin:0;background:linear-gradient(180deg,#071126 0%, #0b1530 100%);color:#e6eef8}
    header{padding:24px 20px;display:flex;align-items:center;justify-content:space-between}
    .brand{font-weight:800;font-size:20px;letter-spacing:1px}
    .nav{display:flex;gap:12px;align-items:center}
    .nav button{background:transparent;border:1px solid rgba(255,255,255,0.06);padding:8px 12px;border-radius:10px;color:inherit;cursor:pointer}
    .container{max-width:1100px;margin:18px auto;padding:0 18px}
    .hero{display:grid;grid-template-columns:2fr 1fr;gap:18px;margin-bottom:18px}
    .card{background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));padding:16px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.6)}
    .hero .main{padding:0}
    .thumb{height:260px;border-radius:10px;background-size:cover;background-position:center;margin-bottom:12px}
    .small-list{display:flex;flex-direction:column;gap:12px}
    .article-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:14px}
    .article-item{padding:12px;border-radius:10px;background:rgba(255,255,255,0.02)}
    h2{margin:0 0 8px 0}
    p.ex{color:var(--muted);margin:0}
    footer{padding:30px;text-align:center;color:var(--muted)}
    @media(max-width:900px){
      .hero{grid-template-columns:1fr}
      .article-grid{grid-template-columns:1fr 1fr}
    }
    @media(max-width:520px){.article-grid{grid-template-columns:1fr}}
  </style>
</head>
<body>
  <header>
    <div class="brand">DHLClone</div>
    <div class="nav">
      <button onclick="redirect('index.php')">Home</button>
      <?php foreach($cats as $c): ?>
        <button onclick="redirect('category.php?cat=<?= $c['id'] ?>')"><?= htmlspecialchars($c['name']) ?></button>
      <?php endforeach; ?>
      <button onclick="redirect('search.php')">Search</button>
    </div>
  </header>
 
  <div class="container">
    <div class="hero">
      <div class="card main">
        <h2>Featured</h2>
        <?php if(count($featured)): ?>
          <?php $f = $featured[0]; ?>
          <div class="thumb" style="background-image:url('<?= htmlspecialchars($f['image']) ?>')"></div>
          <h1><?= htmlspecialchars($f['title']) ?></h1>
          <p class="ex"><?= htmlspecialchars($f['excerpt']) ?></p>
          <p style="margin-top:8px;color:var(--muted)"><?= htmlspecialchars($f['author']) ?> — <?= date('M d, Y', strtotime($f['published_at'])) ?></p>
          <div style="margin-top:12px"><button onclick="redirect('article.php?id=<?= $f['id'] ?>')">Read full</button></div>
        <?php else: ?>
          <p>No featured articles yet.</p>
        <?php endif; ?>
      </div>
 
      <div class="card">
        <h3>Breaking / Latest</h3>
        <div class="small-list">
          <?php foreach($latest as $l): ?>
            <div>
              <strong onclick="redirect('article.php?id=<?= $l['id'] ?>')" style="cursor:pointer"><?= htmlspecialchars($l['title']) ?></strong>
              <div style="color:var(--muted);font-size:13px"><?= htmlspecialchars($l['author']) ?> • <?= date('M d', strtotime($l['published_at'])) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
 
    <div class="card">
      <h2>Trending</h2>
      <div class="article-grid">
        <?php foreach($latest as $a): ?>
          <div class="article-item">
            <div style="height:120px;background-image:url('<?= htmlspecialchars($a['image']) ?>');background-size:cover;border-radius:8px"></div>
            <h3 style="font-size:16px;margin-top:8px"><?= htmlspecialchars($a['title']) ?></h3>
            <p class="ex"><?= htmlspecialchars($a['excerpt']) ?></p>
            <div style="margin-top:8px"><button onclick="redirect('article.php?id=<?= $a['id'] ?>')">Open</button></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
 
  <footer>© <?= date('Y') ?> DHLClone — built with PHP, MySQL, JS</footer>
 
  <script>
    function redirect(url){
      // JS redirection per your requirement
      window.location.href = url;
    }
  </script>
</body>
</html>
 
