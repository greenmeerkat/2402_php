<?php
function my_sum($num1, $num2){
    return $num1 + $num2;
}

// echo my_sum(32, 54);

// 파라미터 default 설정

/**
 * 두 숫자를 더하는 함수
 * 
 * @param int $num1 더할 첫번째 숫자
 * @param int $num2 더할 두번째 숫자, default 10
 * @return int 합계
 */
function my_sum2(int $num1, int $num2 = 10) {
    return $num1 + $num2;
}

echo my_sum2(5);

// -, *, /, % 를 해주는 각각의 함수를 만들어 주세요.
function my_sub(int $num1, int $num2) {
    return $num1 - $num2;
}
function my_multi(int $num1, int $num2) {
    return $num1 * $num2;
}
function my_div(int $num1, int $num2) {
    return $num1 / $num2;
}
function my_remind(int $num1, int $num2) {
    return $num1 % $num2;
}

$str = "처음 정의";

function test(string $str) {
    $str = "test()에서 변경";
}
function test2(string $str) {
    $str = "test2()에서 변경";
    return $str;
}

$str = test2($str);
echo $str;


// 가변 길이 파라미터
function my_sum_all(...$numbers) {
    // $numbers = func_get_args(); // PHP 5.5 이하
    print_r($numbers);
}
echo my_sum_all(3,3,5,6,7,3,4,6,8,5,3,9);


// 파라미터로 받은 모든 수를 더하는 함수를 만들어 주세요.
function my_sum_all2(...$numbers) {
    $sum = 0; // 합계 저장용 변수, 합계를 저장하기 때문에 숫자 0으로 초기화

    // 파라미터 루프해서 값을 획득 후 더하기
    foreach($numbers as $val) {
        $sum += $val;
    }

    // 합계 리턴
    return $sum;
}
echo my_sum_all2(5,4,5,6);
echo "\n";

// 참조 전달
function test_v($num) {
    $num = 3;
}
function test_r(&$num) {
    $num = 5;
}
$num = 0;
test_r($num);
echo $num;
echo "\n";

// 참조 변수
$a = 1;
$b = &$a;
$a = 3;

echo $b;
