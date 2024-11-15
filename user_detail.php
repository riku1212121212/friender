<?php
// user_detail.php
session_start();
require 'config.php';

// ログイン確認
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$current_user_id = $_SESSION['user_id'];
$viewed_user_id = $_GET['id'];

// 選択されたユーザーの詳細を取得
$sql = "SELECT u.username, p.gender, p.bio, p.photo_path, p.category, p.blood, p.figure, p.beer, p.MBTI, p.college, p.nickname, p.age, p.languages, p.tall, p.Birthplace, p.birthdate FROM users u JOIN profiles p ON u.id = p.user_id WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $viewed_user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// 「いいね」されているかを確認するクエリ
$sql_like = "SELECT COUNT(*) FROM likes WHERE user_id = ? AND liked_user_id = ?";
$stmt_like = $conn->prepare($sql_like);
$stmt_like->bind_param("ii", $current_user_id, $viewed_user_id);
$stmt_like->execute();
$stmt_like->bind_result($like_count);
$stmt_like->fetch();
$is_liked = $like_count > 0;
$stmt_like->close();

$conn->close();

// 生年月日のフォーマットを整える
$birthdate_formatted = !empty($user['birthdate']) ? date('Y年m月d日', strtotime($user['birthdate'])) : '未設定';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($user['username']); ?> の詳細</title>
    <link href="user_detail.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
          integrity="sha512-6RYOBMb6oaENX6dTeMEY5C4eXvJG3vE7l4EoBc/VXXZPIszg8Hzl06K+aC6GHi7AdbG5Iqa+xfgNT2jOhj6pZw==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="profile">
        <img src="<?php echo htmlspecialchars($user['photo_path']); ?>" alt="プロフィール写真">
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        <p>ニックネーム: <?php echo htmlspecialchars($user['nickname']); ?></p>
        <p>年齢: <?php echo htmlspecialchars($user['age']); ?></p>
        <p>性別: <?php echo htmlspecialchars($user['gender']); ?></p>
        <p>学年: <?php echo htmlspecialchars($user['category']); ?></p>
        <p>血液型: <?php echo htmlspecialchars($user['blood']); ?></p>
        <p>体型: <?php echo htmlspecialchars($user['figure']); ?></p>
        <p>お酒: <?php echo htmlspecialchars($user['beer']); ?></p>
        <p>MBTI: <?php echo htmlspecialchars($user['MBTI']); ?></p>
        <p>カレッジ: <?php echo htmlspecialchars($user['college']); ?></p>
        <p>言語: <?php echo htmlspecialchars($user['languages']); ?></p>
        <p>身長: <?php echo htmlspecialchars($user['tall']); ?></p>
        <p>出身地: <?php echo htmlspecialchars($user['Birthplace']); ?></p>
        <p>生年月日: <?php echo $birthdate_formatted; ?></p>
        <p>自己紹介: <?php echo htmlspecialchars($user['bio']); ?></p>
    </div>
    
    <!-- いいねボタン -->
    <div class="box"> 
    <button class="bubbly-button">
        <i class="fa-solid fa-heart"></i>
    </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="user_detail.js"></script>
</body>
</html>
