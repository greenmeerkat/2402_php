<?php
namespace mammal;

require_once('./Swimm.php');
require_once('./mammal/Mammal.php');
use mammal\Mammal;
use inf\Swimm;

// 고래 클래스
class Whale extends Mammal implements Swimm {

    public function printRegidence() {
        echo $this->name . '는 바다에 삽니다.';
    }

    public function swimming() {
        echo $this->name . '가 헤엄칩니다.';
    }
}