<?php
require_once 'db.php';
$cat = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$category = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$category->execute([$cat]);
$category = $category->fetch();
 
$articles = $pdo->prepare("SELECT * FROM articles WHERE category_id = ? ORDER BY published_at DESC");
$articles->execute([$cat]);
$articles = $articles->fetchAll();
 
$cats = $pdo->query("SELECT * FROM categories ORDER BY id")->fetchAll();
?>
<!doctype html><html><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $category ? htmlspecialchars($category['name']) : 'Category' ?> - DHLClone</title>
<style>
/* internal CSS similar style */
body{background:#071127;color:#eaf0fb;font-family:Inter;padding:0;margin:0}
.container{max-width:1000px;margin:18px auto;padding:16px}
.header{display:flex;justify-content:space-between;align-items:center}
.btn{background:transparent;border:1px solid rgba(255,255,255,0.06);padding:8px 10px;border-radius:10px;cursor:pointer}
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:14px}
.card{background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);padding:12px;border-radius:10px}
@media(max-width:900px){.grid{grid-template-columns:1fr 1fr}}
@media(max-width:520px){.grid{grid-template-columns:1fr}}
</style>
</head><body>
<div class="container">
  <div class="header">
    <h1><?= $category ? htmlspecialchars($category['name']) : 'Category' ?></h1>
    <div>
      <button class="btn" onclick="redirect('index.php')">Home</button>
      <button class="btn" onclick="redirect('search.php')">Search</button>
    </div>
  </div>
 
  <?php if(!$category): ?>
    <p>Category not found.</p>
  <?php else: ?>
    <div class="grid">
      <?php foreach($articles as $a): ?>
        <div class="card">
          <div style="height:140px;background-image:url('<?=htmlspecialchars($a['image'])?>');background-size:cover;border-radius:8px"></div>
          <h3><?= htmlspecialchars($a['title']) ?></h3>
          <p style="color:#9aa3b2"><?= htmlspecialchars($a['excerpt']) ?></p>
          <div style="margin-top:8px"><button onclick="redirect('article.php?id=<?= $a['id'] ?>')">Read</button></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
 
</div>
 
<script>function redirect(u){window.location.href=u}</script>
</body></html>
 
