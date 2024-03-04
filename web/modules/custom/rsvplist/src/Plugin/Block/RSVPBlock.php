<?php

/**
 * @file
 * Creates a block which displays the RSVPForm contained in RSVPForm.php
 */

namespace Drupal\rsvplist\Plugin\Block;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Provides the RSVP main block.
 *
 * @Block(
 *  id = "rsvp_block",
 *  admin_label = @Translation("The RSVP Block")
 * )
 */
class RSVPBlock extends BlockBase implements ContainerFactoryPluginInterface{

    protected $formBuilder;
    protected $routeMatch;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $form_builder, RouteMatchInterface $route_match){
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->formBuilder = $form_builder;
        $this->routeMatch = $route_match;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('form_builder'),
            $container->get('current_route_match'),
        );
    }
    public function build(){
        // return [
        //     '#type' => 'markup',
        //     '#markup' => $this->t('My RSVP List Block'),
        // ];

        return $this->formBuilder->getForm('Drupal\rsvplist\Form\RSVPForm');
    }

    /**
     * {@inheritdoc}
     */
    public function blockAccess(AccountInterface $account){
        $node = $this->routeMatch->getParameter('node');

        if(!(is_null($node))){
            $enabler = \Drupal::service('rsvplist.enabler');
            if($enabler->isEnabled($node)){
                return AccessResult::allowedIfHasPermission($account, 'view rsvplist');

            }
        }
        return AccessResult::forbidden();
    }
}