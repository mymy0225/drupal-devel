<?php

namespace Drupal\marucha\Controller;

use Drupal\Core\Controller\ControllerBase;

class MaruchaController extends ControllerBase{

    public function index(){
        return ['#markup' => 'Hello World!'];
    }
}