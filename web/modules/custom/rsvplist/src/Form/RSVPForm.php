<?php
/**
 * @file
 * A form to collect an email addressfor RSVP details
 */
namespace Drupal\rsvplist\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RSVPForm extends FormBase {

    protected $routeMatch;
    protected $emailValidator;
    protected $currentUser;
    protected $database;
    protected $time;
    protected $messenger;

    public function __construct(
        RouteMatchInterface $route_match,
        EmailValidatorInterface $email_validator,
        AccountInterface $current_user,
        Connection $connection,
        TimeInterface $time,
        MessengerInterface $messenger,
        ){
        $this->routeMatch = $route_match;
        $this->emailValidator = $email_validator;
        $this->currentUser = $current_user;
        $this->time = $time;
        $this->database = $connection;
        $this->messenger = $messenger;
    }

    public static function create(ContainerInterface $container){
        return new static(
            $container->get('current_route_match'),
            $container->get('email.validator'),
            $container->get('current_user'),
            $container->get('database'),
            $container->get('datetime.time'),
            $container->get('messenger'),
        );

    }

    /**
     * {@inheritdoc}
     */
    public function getFormId (){
        return 'rsvplist_email_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm (array $form, FormStateInterface $form_state){
        $node = $this->routeMatch->getParameter('node');

        if ( !(is_null($node)) ){
            $nid = $node->id();
        } else {
            $nid = 0;
        }

        $form['email'] = [
            '#type' => 'textfield',
            '#title' => t('Email address'),
            '#size' => 25,
            '#description' => t('We will send updates to the email address you provide.'),
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('RSVP'),
        ];
        $form['nid'] = [
            '#type' => 'hidden',
            '#value' => $nid,
        ];
        return $form;

    }

    /**
     * {@inheritdoc}
     */

    public function validateForm(array &$form, FormStateInterface $form_state){
        $value = $form_state->getValue('email');
        if( !($this->emailValidator->isValid($value)) ){
            $form_state->setErrorByName(
                'email',
                $this->t('it appears that %mail is not a valid email. Please try again', ['%mail' => $value]));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state){
        // $submitted_email = $form_state->getValue('email');
        // $this->messenger()->addMessage(t("The form is working! You entered @entry.",
        // ['@entry' => $submitted_email]));

        try{
            $uid = $this->currentUser->id();

            $nid = $form_state->getValue('nid');
            $email = $form_state->getValue('email');
            $current_time = $this->time->getRequestTime();

            $query = $this->database->insert('rsvplist');
            $query->fields([
                'uid',
                'nid',
                'mail',
                'created',
            ]);

            $query->values([
                $uid,
                $nid,
                $email,
                $current_time,
            ]);

            $query->execute();

            $this->messenger->addMessage(
                t('Thank you for your RSVP, you are on the list for the event!')
            );

        }catch(\Exception $e){
            $this->messenger->addError(t('Unable to save RSVP settings at this time due to database error. Please try again.'));
        }

    }
}