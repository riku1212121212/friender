<?php
session_start();
require 'config.php';

// ログイン確認
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// データベースから募集を取得（重複を排除、ユーザーの募集を除外）
$sql = "SELECT u.username, p.photo_path, l.id as listing_id, l.location, l.time, l.gender, l.male_participants, l.female_participants
        FROM lunch_listings l
        JOIN users u ON l.user_id = u.id
        JOIN profiles p ON u.id = p.user_id
        WHERE l.id IN (
            SELECT MAX(id) FROM lunch_listings WHERE user_id != ? GROUP BY user_id
        )
        ORDER BY l.time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お昼ご飯の募集掲示板</title>
    <style>
        .listing {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .listing img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>お昼ご飯の募集掲示板</h1>
    <a href="setting.php" class="">戻る</a>
    
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="listing">
                <img src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="プロフィール写真">
                <div>
                    <p><strong><?php echo htmlspecialchars($row['username']); ?></strong></p>
                    <p>場所: <?php echo htmlspecialchars($row['location']); ?>     時間: <?php echo htmlspecialchars($row['time']); ?></p>
                    <p>男性の募集人数: <?php echo htmlspecialchars($row['male_participants']); ?>     女性の募集人数: <?php echo htmlspecialchars($row['female_participants']); ?></p>
                    
                    <!-- 参加リクエストボタン -->
                    <input type="hidden" name="listing_id" value="<?php echo $row['listing_id']; ?>">
                    <button type="submit">参加リクエストを送る</button>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>現在募集はありません。</p>
    <?php endif; ?>
</body>
</html>
