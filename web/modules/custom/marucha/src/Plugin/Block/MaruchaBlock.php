<?php

namespace Drupal\marucha\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provide a Simple block.
 *
 * @Block(
 * id = "marucha_block",
 * admin_label = @Translation("marucha Block"),
 * )
 **/
class MaruchaBlock extends BlockBase {
    /**
     * {@inheritDoc}
     */
    public function build() {
        return ['#markup' => $this->t('Hello!')];
    }
}

