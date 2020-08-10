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

    //copy var carry in then delete
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        $root = '..web/';
    } else {
        $root = '../';
    }

    $twig = \Drupal::service('twig');

    $template = $twig->loadTemplate(
        drupal_get_path('module', 'songs') . '/templates/record.html.twig',
    );

    $build = [
          'description' => [
          '#type' => 'inline_template',
          '#template' => file_get_contents($template),
          '#context' => [
              'my_var' => 'fvvv',
              'root' => $root
          ]
        ]
    ];

    return $build;

  }

}