<?php

namespace Drupal\marucha4\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Utility\EmailValidator;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\marucha4\Service\MaruchaService;

class MaruchaForm extends FormBase{

    protected $emailValidator;
    protected $maruchaService;

    public function __construct(EmailValidator $email_validator, MaruchaService $marucha_service){
        $this->emailValidator = $email_validator;
        $this->maruchaService = $marucha_service;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('email.validator'),
            $container->get('marucha.drink'),
        );
    }

    public function getFormId(){
        return 'marucha4_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        $form['email'] = [
            '#type' => 'textfield',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => '送信',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state){
        $email = $form_state->getValue('email');
        $flag = $this->emailValidator->isValid($email);
        if(!$flag){
            $form_state->setErrorByName('email', 'メールアドレスの形式ではありません');
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        $message = 'ドリンク占い: ' . $this->maruchaService->getDrink();
        $this->messenger()->addStatus($message);
    }
}