<?php
require_once('config.php');
require_once('alphaID.inc.php');

$shortID = alphaID(trim($_REQUEST['id']), true);

try {
  $stmt = $pdo->prepare('SELECT longurl FROM urlshort WHERE id = ? ORDER BY id LIMIT 1');
  $stmt->execute([$shortID]);
  $result = $stmt->fetch();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if($result['longurl']) {
  try {
    $pdo->prepare('UPDATE urlshort SET hits = hits+1 WHERE id = ?')->execute([$shortID]);
    $pdo->prepare('UPDATE urlshort SET lastused = NOW() WHERE id = ?')->execute([$shortID]);
  } catch(Exception $e) {
    // Do nothing
  }

  //header('HTTP/1.1 301 Moved Permanently');
  header('HTTP/1.1 302 Moved Temporarily');
  header("Location: ${result['longurl']}");
  exit;
} else {
  return false;
}

?>
