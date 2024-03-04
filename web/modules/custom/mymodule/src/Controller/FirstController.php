<?php

/**
 * @File
 */

 namespace Drupal\mymodule\Controller;

 use Drupal\Core\Controller\ControllerBase;

 class FirstController extends ControllerBase{
    public function simpleContent(){
        return [
            '#type' => 'markup',
            '#markup' =>t(string: 'hello Drupal world. Time flies like an arrow, fruit flies like a banana.'),
        ];
    }

    public function variableContent($name_1, $name_2){
        return [
            '#type' => 'markup',
            '#markup' => t(string:'@name1 and @name2 say hello to you!',
            args:['@name1' => $name_1, '@name2' => $name_2]),
        ];
    }
 }