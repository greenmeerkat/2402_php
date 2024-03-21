<?php
// 삼항연산자
// 변수 = 조건식 ? 참일 경우 : 거짓일 경우
$question = isset($_GET["q"]) ? $_GET["q"] : "";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>검색어를 입력하세요.</h1>

    <form action="/146_http_method_get.php" method="get">
        <input type="text" name="q">
        <button type="submit">검색</button>
    </form>
    <br>
    <br>
    <?php
        if($question !== "") {
            echo "<h2>당신의 검색어는 <span style=\"color:red;\">$question</span> 입니다.</h2>";
        }
    ?>
    <?php
        if($question !== "") {
    ?>
            <h2>당신의 검색어는 <span style="color:blue;"><?php echo $question ?></span>입니다.</h2>
    <?php
        }
    ?>
</body>
</html>