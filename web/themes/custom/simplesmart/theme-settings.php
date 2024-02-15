<?php

function simplesmart_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $form['default_font_family'] = array(
      '#type' => 'select',
      '#title' => t('Font Family'),
      '#options' => array(
        '' => 'N/A',
        'pacifico' => 'Pacifico',
      ),
      '#description' => t('使用するフォントを選択してください'),
      '#default_value' => theme_get_setting('default_font_family'),
    );
  }