<?php

namespace Drupal\marucha6\Plugin\Tapioca;

use Drupal\marucha6\TapiocaBase;

/**
 * Provides tapioca milk tea plugin.
 *
 * @Tapioca(
 *    id = "tapioca_milk_tea",
 *    label = "Tapioca Milk Tea",
 *    description = "This is best recommended drink."
 * )
 */
class TapiocaMilkTea extends TapiocaBase{
    /**
     * {@inheritDoc}
     */
    public function getOrder(){
        $label = $this->pluginDefinition['label'];
        return 'あなたの注文した商品はこちらです:' . $label;
    }
}