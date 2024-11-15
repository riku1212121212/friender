<?php
session_start();
require 'config.php';

// ログイン確認
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// リクエストの取得

$sql = "SELECT u.username, r.request_time 
        FROM participation_requests r
        JOIN users u ON r.user_id = u.id
        WHERE r.listing_id = ?
        ORDER BY r.request_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $listing_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>参加リクエスト一覧</title>
</head>
<body>
    <h1>参加リクエスト一覧</h1>

    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li><?php echo htmlspecialchars($row['username']); ?> - リクエスト時間: <?php echo htmlspecialchars($row['request_time']); ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>リクエストはまだありません。</p>
    <?php endif; ?>

</body>
</html>
