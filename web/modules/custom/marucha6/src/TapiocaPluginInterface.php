<?php

namespace Drupal\marucha6;

/**
 * Defines an Tapioca interface.
 */
interface TapiocaPluginInterface{

    /**
     * Provide an order.
     *
     * @return string
     *  Say order.
     */
    public function getOrder();

}