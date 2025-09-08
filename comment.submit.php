<?php
require_once 'db.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;
    $name = trim($_POST['name'] ?? 'Anonymous');
    $comment = trim($_POST['comment'] ?? '');
    if($article_id && $comment){
        $stmt = $pdo->prepare("INSERT INTO comments (article_id, name, comment) VALUES (?, ?, ?)");
        $stmt->execute([$article_id, $name, $comment]);
    }
    // JS redirect back to article page (no PHP header)
    echo "<!doctype html><html><head><meta charset='utf-8'><script>location.href='article.php?id=".$article_id."';</script></head><body>Redirecting...</body></html>";
    exit;
}
header('Location: index.php');
 
