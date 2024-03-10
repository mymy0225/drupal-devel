<?php

namespace Drupal\rsvplist;

use Drupal\Core\Database\Connection;
use Drupal\node\Entity\Node;

/**
 * Provides a service for RSVP enabler.
 */
class EnablerService {
  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $databaseConnenction;

  /**
   * Constructor.
   */
  public function __construct(Connection $connection) {
    $this->databaseConnection = $connection;
  }

  /**
   * Gets boolean enable RSVP form in this node.
   *
   * @return bool
   *   evaluate RSVP send form enabled in this node.
   */
  public function isEnabled(Node &$node) {
    if ($node->isNew()) {
      return FALSE;
    }
    try {
      $select = $this->databaseConnection->select('rsvplist_enabled', 're');
      $select->fields('re', ['nid']);
      $select->condition('nid', $node->id());
      $results = $select->execute();

      return !(empty($results->fetchCol()));

    }
    catch (\Exception $e) {
      \Drupal::messenger()->addError(
            t('unable to determine RSVP settings at this time. Please try again.')

        );
      return NULL;
    }
  }

  /**
   * Set RSVP form to node.
   */
  public function setEnabled(Node $node) {
    try {
      if (!($this->isEnabled($node))) {
        $insert = $this->databaseConnection->insert('rsvplist_enabled');
        $insert->fields(['nid']);
        $insert->values([$node->id()]);
        $insert->execute();
      }
    }
    catch (\Exception $e) {
      \Drupal::messenger()->addError(
            t('Unable to save RSVP settings at this time. Please try again.')
        );
    }
  }

  /**
   * Delete RSVP form from node.
   */
  public function delEnabled(Node $node) {
    try {
      $delete = $this->databaseConnection->delete('rsvplist_enabled');
      $delete->condition('nid', $node->id());
      $delete->execute();
    }
    catch (\Exception $e) {
      \Drupal::messenger()->addError(
            t('Unable to save RSVP settings at this time. Please try again.')
        );
    }
  }

}
