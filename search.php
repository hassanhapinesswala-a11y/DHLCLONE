<?php
require_once 'db.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];
if($q !== ''){
  $stmt = $pdo->prepare("SELECT * FROM articles WHERE title LIKE ? OR excerpt LIKE ? OR content LIKE ? ORDER BY published_at DESC");
  $like = "%$q%";
  $stmt->execute([$like,$like,$like]);
  $results = $stmt->fetchAll();
}
$cats = $pdo->query("SELECT * FROM categories ORDER BY id")->fetchAll();
?>
<!doctype html><html><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Search - DHLClone</title>
<style>
body{background:#071127;color:#eaf0fb;font-family:Inter;margin:0}
.container{max-width:900px;margin:18px auto;padding:16}
input{width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.06);background:transparent;color:inherit}
.card{background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);padding:12px;border-radius:10px;margin-top:12px}
.result{padding:10px;border-bottom:1px solid rgba(255,255,255,0.02)}
button{padding:8px 10px;border-radius:8px;border:none;background:#ff3b30;color:white;cursor:pointer}
</style>
</head><body>
<div class="container">
  <div style="display:flex;gap:8px">
    <input id="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search articles...">
    <button onclick="doSearch()">Search</button>
  </div>
 
  <div class="card">
    <?php if($q===''): ?>
      <p>Type a keyword and press Search.</p>
    <?php else: ?>
      <h3>Results for "<?= htmlspecialchars($q) ?>" (<?= count($results) ?>)</h3>
      <?php foreach($results as $r): ?>
        <div class="result">
          <strong onclick="redirect('article.php?id=<?= $r['id'] ?>')" style="cursor:pointer"><?= htmlspecialchars($r['title']) ?></strong>
          <p style="color:#9aa3b2"><?= htmlspecialchars($r['excerpt']) ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
 
<script>
function redirect(u){window.location.href = u}
function doSearch(){
  const q = document.getElementById('q').value.trim();
  if(!q) return alert('Type something');
  window.location.href = 'search.php?q=' + encodeURIComponent(q);
}
</script>
</body></html>
 
