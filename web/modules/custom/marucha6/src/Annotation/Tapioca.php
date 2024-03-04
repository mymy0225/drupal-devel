<?php

namespace Drupal\marucha6\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Tapioca annotation object.
 *
 * @Annotation
 */
class Tapioca extends Plugin {

    /**
     * The plugin ID.
     *
     * @var string
     */
    public $id;

    /**
     * The human-readable name of the plugin.
     *
     * @var \Drupal\Core\Annotation\Translation
     *
     * @ingroup plugin_translatable
     */
    public $label;

    /**
     * The description of the plugin.
     *
     * @var \Drupal\Core\Annotation\Translation
     */
    public $description;
}