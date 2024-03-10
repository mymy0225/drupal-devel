<?php

namespace Drupal\rules\Plugin\Condition;

use Drupal\node\NodeInterface;
use Drupal\rules\Core\RulesConditionBase;

/**
 * Provides a 'Node is of type' condition.
 *
 * @Condition(
 *   id = "rules_node_is_of_type",
 *   label = @Translation("Node is of type"),
 *   category = @Translation("Content"),
 *   context_definitions = {
 *     "node" = @ContextDefinition("entity:node",
 *       label = @Translation("Node"),
 *       description = @Translation("Specifies the node for which to evaluate the condition."),
 *       assignment_restriction = "selector"
 *     ),
 *     "types" = @ContextDefinition("string",
 *       label = @Translation("Content types"),
 *       description = @Translation("The content type(s) to check for."),
 *       options_provider = "\Drupal\rules\TypedData\Options\NodeTypeOptions",
 *       multiple = TRUE
 *     ),
 *   }
 * )
 */
class NodeIsOfType extends RulesConditionBase {

  /**
   * Check if a node is of a specific set of types.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node to check for a type.
   * @param string[] $types
   *   An array of type names as strings.
   *
   * @return bool
   *   TRUE if the node type is in the array of types.
   */
  protected function doEvaluate(NodeInterface $node, array $types) {
    return in_array($node->getType(), $types);
  }

}
