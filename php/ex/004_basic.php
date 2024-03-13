<?php
// 변수(Variable)
$str = "안녕 php";
echo $str;

// 변수 명명 규치
// - 변수명은 영문 대소문자,숫자,언더바(_) 가능
// (’_’ 이 외의 특수기호 사용 불가능 / 한글은 사용 가능하나 지양)
// - 변수명은 숫자로 시작이 불가능
// - 변수명은 공백이 포함 불가
// - 변수명은 미리 지정되어 있는 예약어를 사용불가
// ex) $this, $_POST 등등
// - 변수명은 대소문자를 구분
// ex) $Num; 과 $num;은 서로 다른 변수로 인식

// 한글로도 설정이 가능하나, 사용하지 말자
$숫자1 = 1;
echo $숫자1;

$user_name;

$Num = 1;
$num = 2;
echo $Num, $num;

// 네이밍 기법
// 스네이크 기법
$user_name;

// 카멜 기법
$userName;

echo "\n";
// 상수 : 절대 변하지 않는 값
define("USER_AGE", "가나다라");

define("USER_AGE", 30); // 이미 선언된 상수이므로 워닝 일어나고 값이 바뀌지 않음

echo USER_AGE;

// 점심메뉴
// 탕수육 9000원
// 햄버거 10000원
// 빵 2000원
$menu = "점심메뉴\n";
$tang = "탕수육 9000원\n";
$hamberger = "햄버거 10000원\n";
$bbang = "빵 2000원";
echo $menu, $tang, $hamberger, $bbang;

define("MENU", "점심메뉴\n");
echo MENU;

// 스왑 
$swap1 = "곤드레밥";
$swap2 = "짜장면";
$tmp = "";

$tmp = $swap1;
$swap1 = $swap2;
$swap2 = $tmp;

echo $swap1;
echo $swap2;