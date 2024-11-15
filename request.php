<?php
session_start();
require 'config.php';

// ログイン確認
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// フォームが送信された場合、データをデータベースに保存
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $location = $_POST['location'];
    $time = $_POST['time'];
    $male_participants = $_POST['male_participants']; // 男性用人数
    $female_participants = $_POST['female_participants']; // 女性用人数

    // 新規募集の挿入
    $sql = "INSERT INTO lunch_listings (user_id, location, time, male_participants, female_participants) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issii", $user_id, $location, $time, $male_participants, $female_participants);
    $stmt->execute();
    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お昼ご飯を募集する</title>
</head>
<body>
    <h1>お昼ご飯を募集する</h1>
    <div style="text-align: left;">
        <!-- マイページに戻るボタン -->
        <a href="setting.php" class="">戻る</a>
    </div>
    <form action="request.php" method="post">
        <label for="location">場所:</label>
        <input type="text" id="location" name="location" required><br><br>
        
        <label for="time">時間:</label>
        <select id="time" name="time" required>
            <option value="">選択してください</option>
            <option value="12:00">12:00</option>
            <option value="12:30">12:30</option>
            <option value="13:00">13:00</option>
            <option value="13:30">13:30</option>
            <option value="14:00">14:00</option>
            <option value="14:30">14:30</option>
        </select><br><br>

        <label for="male_participants">男性の募集人数:</label>
        <input type="number" id="male_participants" name="male_participants" min="0" required><br><br>

        <label for="female_participants">女性の募集人数:</label>
        <input type="number" id="female_participants" name="female_participants" min="0" required><br><br>

        <button type="submit">募集する</button>
    </form>
</body>
</html>
