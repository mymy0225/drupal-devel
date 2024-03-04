<?php

namespace Drupal\marucha3\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MaruchaForm extends FormBase {
    public function getFormId() {
        return 'marucha3_simple_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => '名前',
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => 'Email',
            '#pattern' => '*@example.com',
        ];
        $form['phone'] = [
            '#type' => 'tel',
            '#title' => 'Phone',
            '#pattern' => '[^\\d]*',
        ];
        $form['radio'] = [
            '#type' => 'radios',
            '#title' => 'ラジオボタン',
            '#default_value' => 1,
            '#options' => [
              0 => 'Closed',
              1 => 'Active',
            ],
        ];
        $form['checkbox'] = [
            '#type' => 'checkbox',
            '#title' => 'Send me a copy',
        ];
        $form['select'] = [
            '#type' => 'select',
            '#title' => 'Select element',
            '#options' => [
              '1' => 'One',
              '2' => 'Two point one',
              '3' => 'Three',
            ],
        ];
        $form['color'] = [
            '#type' => 'color',
            '#title' => 'Color',
            '#default_value' => '#ff0000',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => '送信',
        ];
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        $this->messenger()->addStatus('ご入力ありがとうございます');
    }
}