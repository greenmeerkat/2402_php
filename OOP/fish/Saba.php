<?php

namespace fish;

require_once('./Swimm.php');
require_once('./Breath.php');
use inf\Swimm;
use inf\Breath;

class Saba implements Swimm, Breath {
    private string $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function swimming() {
        echo $this->name . '가 헤엄칩니다.';
    }

    public function breath() {
        echo $this->name . '는 아가미 호흡을 합니다.';
    }
}