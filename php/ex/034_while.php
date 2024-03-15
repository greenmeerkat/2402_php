<?php
// while 문
$cnt = 0;
while($cnt < 3) {
    echo "count : $cnt \n";
    $cnt++;
}

$cnt = 0;
while(true) {
    echo "$cnt \n";
    if($cnt === 3) {
        break;
    }
    $cnt++;
}


// while를 이용해서 2단을 출력해 주세요.
// 2 X 1 = 2
// 2 X 2 = 4
// ...
// 2 X 9 = 18
$num = 1;
while($num < 10) {
    echo "2 X ".$num." = ".(2 * $num)."\n";
    $num++;
}

$dan = 2;
$multi_num = 1;
while($dan < 10) {
    $multi_num = 1;
    echo $dan."단\n";

    while($multi_num < 10) {
        echo $dan." X ".$multi_num." = ".($dan * $multi_num)."\n";
        $multi_num++;
    }
    $dan++;
}

for($dan = 2; $dan < 10; $dan++) {
    echo "** ".$dan."단 **\n";
    for($multi_num = 1; $multi_num < 10; $multi_num++) {
        $msg_line = $dan." X ".$multi_num." = ".($dan * $multi_num);
        echo $msg_line."\n";
    }
}


