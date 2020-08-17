<?php

namespace Drupal\songs\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom Block.
 *
 * @Block(
 *   id = "record_block",
 *   admin_label = @Translation("Record block"),
 *   category = @Translation("Custom header"),
 * )
 */
class RecordBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {

    $root = $_SERVER['SERVER_NAME'] === 'localhost' ? '.../web/' : '../';

    $twig = \Drupal::service('twig');

    $template = $twig->loadTemplate(
        drupal_get_path('module', 'songs') . '/templates/record.html.twig',
    );

    $build = [
          'description' => [
          '#type' => 'inline_template',
          '#template' => file_get_contents($template),
          '#context' => [
              'root' => $root
          ]
        ]
    ];

    return $build;

  }

}