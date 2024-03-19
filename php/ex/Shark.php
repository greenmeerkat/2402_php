<?php
class Shark {
    private $name;

    // 생성자
    public function __construct($name) {
        $this->name = $name;
    }

    // 메소드
    
    /**
     * name + 호흡합니다 출력
     */
    public function swim() {
        echo $this->name." 헤엄 칩니다.\n";
    }

    public function breathe() {
        echo $this->name." 호흡 합니다.\n";
    }
}