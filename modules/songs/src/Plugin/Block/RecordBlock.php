<?php

namespace Drupal\songs\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom Block.
 *
 * @Block(
 *   id = "record_block",
 *   admin_label = @Translation("Record block 2"),
 *   category = @Translation("Custom header"),
 * )
 */
class RecordBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    \Drupal::logger('songs')->info('in block code');

    $twig = \Drupal::service('twig');


    $template = $twig->loadTemplate(
        drupal_get_path('module', 'songs') . '/templates/songs.html.twig'
    );

    $build = [
          'description' => [
          '#type' => 'inline_template',
          '#template' => file_get_contents($template),
        ]
    ];

    return $build;

  }

}