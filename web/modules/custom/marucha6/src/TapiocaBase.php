<?php

namespace Drupal\marucha6;

use Drupal\Component\Plugin\PluginBase;

/**
 * Defines a base tapioca implemention.
 */
abstract class TapiocaBase extends PluginBase implements TapiocaPluginInterface {
    /**
     * {@inheritDoc}
     */
    public function getOrder(){
        $label = $this->pluginDefinition['label'];
        return 'You ordered an ' . $label . '. Enjoy!';
    }
}