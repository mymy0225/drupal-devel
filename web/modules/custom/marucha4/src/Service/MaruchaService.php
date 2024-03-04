<?php

namespace Drupal\marucha4\Service;

class MaruchaService{
    private $drinks = ['コーヒー', 'キャラメルマキアート', 'カフェラテ'];

    public function getDrink(){
        return $this->drinks[array_rand($this->drinks)];
    }
}