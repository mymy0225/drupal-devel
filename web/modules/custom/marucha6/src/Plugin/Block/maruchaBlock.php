<?php

namespace Drupal\marucha6\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides marucha block.
 *
 * @Block(
 * id = "marucha_block6",
 * admin_label = @Translation("Marucha Block6")
 * )
 */
class MaruchaBlock extends BlockBase{

    /**
     * {@inheridDoc}
     */
    public function build(){
        return [
            '#markup' => 'This is marucha block 6',
        ];
    }
}