<?php

namespace Drupal\marucha3\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Implementing block.
 *
 * @Block(
 * id = "marucha3_block",
 * admin_label = "Marucha Block 3",
 * )
 */
class MaruchaBlock extends BlockBase {
    public function build(){
        return \Drupal::formBuilder()->getForm('Drupal\marucha3\Form\MaruchaForm');
    }
}