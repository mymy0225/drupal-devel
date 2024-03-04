<?php

/**
 * @file
 * Contains the RSVP Enabler service.
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Connection;
use Drupal\node\Entity\Node;

class EnablerService{
    protected $database_connenction;

    public function __construct(Connection $connection){
        $this->database_connection = $connection;
    }

    public function isEnabled(Node &$node){
        if($node->isNew()){
            return FALSE;
        }
        try{
            $select = $this->database_connection->select('rsvplist_enabled', 're');
            $select->fields('re', ['nid']);
            $select->condition('nid', $node->id());
            $results = $select->execute();

            return !(empty($results->fetchCol()));

        }
        catch(\Exception $e){
            \Drupal::messenger()->addError(
                t('unable to determine RSVP settings at this time. Please try again.')

            );
            return NULL;
        }
    }

    public function setEnabled(Node $node){
        try{
            if( !($this->isEnabled($node)) ){
                $insert = $this->database_connection->insert('rsvplist_enabled');
                $insert->fields(['nid']);
                $insert->values([$node->id()]);
                $insert->execute();
            }
        }
        catch(\Exception $e){
            \Drupal::messenger()->addError(
                t('Unable to save RSVP settings at this time. Please try again.')
            );
        }
    }

    public function delEnabled(Node $node){
        try{
            $delete = $this->database_connection->delete('rsvplist_enabled');
            $delete->condition('nid', $node->id());
            $delete->execute();
        }
        catch(\Exception $e){
            \Drupal::messenger()->addError(
                t('Unable to save RSVP settings at this time. Please try again.')
            );
        }
    }
}