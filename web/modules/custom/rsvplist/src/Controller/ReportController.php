<?php

/**
 * @file
 * Provide site administrators with a list of all the RSVP List signups
 * so they know who is attending their events.
 */

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReportController extends ControllerBase{

    protected $database;
    protected $messenger;

    public function __construct(Connection $connection, MessengerInterface $messenger){
        $this->database = $connection;
        $this->messenger = $messenger;

    }

    public static function create(ContainerInterface $container){
        return new static(
            $container->get('database'),
            $container->get('messenger'),
        );
    }
    /**
     * Gets and returns all RSVPs for all nodes.
     * These are returned as an associative array, with each row
     * containing the username, the node title. and email of RSVP.
     *
     * @return array\null
     */
    protected function load(){
        try{
            $database = $this->database;
            $select_query = $database->select('rsvplist', 'r');
            $select_query->join('users_field_data', 'u', 'r.uid = u.uid');
            $select_query->join('node_field_data', 'n', 'r.nid = n.nid');
            $select_query->addField('u', 'name', 'username');
            $select_query->addField('n', 'title');
            $select_query->addField('r', 'mail');
            $select_query->addField('r', 'special_code');

            $entries = $select_query->execute()->fetchAll(\PDO::FETCH_ASSOC);

            return $entries;
        }
        catch(\Exception $e){
            $this->messenger->addStatus(
                t('Unable to access the database at this time. Please try again later.')
            );
            return NULL;
        }
    }

    /**
     * Creates the RSVPlist report page.
     *
     * @return array
     * Render array for the RSVPList report output.
     */
    public function report(){
        $content = [];
        $content['message'] = [
            '#markup' => t('Below is a list of all Event RSVPs including username.
            email address and the name of the event they will be attending.'),
        ];

        $headers = [
            t('Username'),
            t('Event'),
            t('Email'),
            t('Special Code'),
        ];

        $table_rows = $this->load();

        $content['table'] = [
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $table_rows,
            '#empty' => t('No entries available'),
        ];

        $content['#cache']['max-age'] = 0;

        return $content;
    }
}