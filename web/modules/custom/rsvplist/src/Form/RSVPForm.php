<?php

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

/**
 * RSVP send form.
 */
class RSVPForm extends FormBase {

  /**
   * The route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The email validator service.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  public function __construct(
        RouteMatchInterface $route_match,
        EmailValidatorInterface $email_validator,
        AccountInterface $current_user,
        Connection $connection,
        TimeInterface $time,
        MessengerInterface $messenger,
        ) {
    $this->routeMatch = $route_match;
    $this->emailValidator = $email_validator;
    $this->currentUser = $current_user;
    $this->time = $time;
    $this->database = $connection;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
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
  public function getFormId() {
    return 'rsvplist_email_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $node = $this->routeMatch->getParameter('node');

    if (!(is_null($node))) {
      $nid = $node->id();
    }
    else {
      $nid = 0;
    }

    $request = \Drupal::request()->get('code');

    $form['email'] = [
      '#type' => 'textfield',
      '#title' => t('Email address'),
      '#size' => 25,
      '#description' => t('We will send updates to the email address you provide.'),
      '#required' => TRUE,
    ];
    $form['special_code'] = [
      '#type' => 'textfield',
      '#title' => 'Special Code',
      '#size' => 25,
      '#description' => t('If you have an special code, please input.'),
      '#default_value' => $request,
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
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('email');
    if (!($this->emailValidator->isValid($value))) {
      $form_state->setErrorByName(
            'email',
            $this->t('it appears that %mail is not a valid email. Please try again', ['%mail' => $value]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // $submitted_email = $form_state->getValue('email');
    // $this->messenger()->addMessage(t("The form is working! You entered @entry.",
    // ['@entry' => $submitted_email]));
    try {
      $uid = $this->currentUser->id();
      $nid = $form_state->getValue('nid');
      $email = $form_state->getValue('email');
      $special_code = $form_state->getValue('special_code');
      $current_time = $this->time->getRequestTime();

      $query = $this->database->insert('rsvplist');
      $query->fields([
        'uid',
        'nid',
        'mail',
        'special_code',
        'created',
      ]);

      $query->values([
        $uid,
        $nid,
        $email,
        $special_code,
        $current_time,
      ]);

      $query->execute();

      $this->messenger->addMessage(
            t('Thank you for your RSVP, you are on the list for the event!')
        );

    }
    catch (\Exception $e) {
      $this->messenger->addError(t('Unable to save RSVP settings at this time due to database error. Please try again.'));
    }

  }

}
