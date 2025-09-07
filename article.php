?php
require_once 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = $pdo->prepare("SELECT a.*, c.name AS category_name FROM articles a LEFT JOIN categories c ON a.category_id = c.id WHERE a.id = ?");
$article->execute([$id]);
$article = $article->fetch();
 
$comments = $pdo->prepare("SELECT * FROM comments WHERE article_id = ? ORDER BY created_at DESC");
$comments->execute([$id]);
$comments = $comments->fetchAll();
?>
<!doctype html><html><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $article ? htmlspecialchars($article['title']) : 'Article' ?> - DHLClone</title>
<style>
body{background:#071127;color:#eaf0fb;font-family:Inter;margin:0}
.container{max-width:900px;margin:18px auto;padding:16}
.thumb{height:320px;background-size:cover;border-radius:12px;margin-bottom:12px}
.meta{color:#9aa3b2;font-size:14px}
.card{background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);padding:12px;border-radius:10px}
.form-row{display:flex;gap:8px;margin-top:8px}
input,textarea{width:100%;padding:8px;border-radius:8px;border:1px solid rgba(255,255,255,0.06);background:transparent;color:inherit}
button{padding:8px 10px;border-radius:8px;border:none;background:#ff3b30;color:white;cursor:pointer}
.comment{border-top:1px solid rgba(255,255,255,0.03);padding-top:8px;margin-top:8px}
</style>
</head><body>
<div class="container">
  <button onclick="redirect('index.php')">← Back</button>
  <?php if(!$article): ?>
    <h2>Article not found</h2>
  <?php else: ?>
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <div class="meta"><?= htmlspecialchars($article['author']) ?> • <?= htmlspecialchars($article['category_name']) ?> • <?= date('M d, Y', strtotime($article['published_at'])) ?></div>
    <div class="thumb" style="background-image:url('<?=htmlspecialchars($article['image'])?>')"></div>
    <div class="card">
      <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
    </div>
 
    <section style="margin-top:16px">
      <h3>Comments (<?= count($comments) ?>)</h3>
      <div class="card">
        <?php foreach($comments as $cm): ?>
          <div class="comment">
            <strong><?= htmlspecialchars($cm['name']) ?></strong> <span style="color:#9aa3b2;font-size:13px">• <?= date('M d, Y H:i', strtotime($cm['created_at'])) ?></span>
            <p><?= nl2br(htmlspecialchars($cm['comment'])) ?></p>
          </div>
        <?php endforeach; ?>
 
        <form action="comment_submit.php" method="post" style="margin-top:12px">
          <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
          <div class="form-row">
            <input type="text" name="name" placeholder="Your name" required>
            <input type="text" name="email" placeholder="Email (optional)">
          </div>
          <div style="margin-top:8px">
            <textarea name="comment" placeholder="Write a comment..." rows="4" required></textarea>
          </div>
          <div style="margin-top:8px">
            <button type="submit">Post Comment</button>
          </div>
        </form>
      </div>
    </section>
  <?php endif; ?>
</div>
 
<script>function redirect(u){window.location.href=u}</script>
</body></html>
 
