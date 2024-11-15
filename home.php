<?php
// home.php
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Friender</title>
<meta name="description"  content="書籍「動くWebデザインアイディア帳」のサンプルサイトです">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<!--==============レイアウトを制御する独自のCSSを読み込み===============-->
<link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
<link rel="stylesheet" type="text/css"  href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/4-2-9/css/4-2-9.css">
<link rel="stylesheet" href="home_style.css">
</head>
<body>
<div id="splash">
<div id="splash-logo">読み込み中</div>
<!--/splash--></div>

<p><img src="home.png"  alt="" class="center-image"></p>
  <div class="splashbg"></div><!---画面遷移用-->
 
    <div class="shake">
      <a href="registar.php" class="home">アカウント作成</a>
      <a href="login.php" class="home">ログイン</a>
    </div>



<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="home.js"></script>

</body>
</html>