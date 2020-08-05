<?php

namespace Drupal\songs\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom Block.
 *
 * @Block(
 *   id = "playlist_block",
 *   admin_label = @Translation("Playlist block"),
 *   category = @Translation("Custom block"),
 * )
 */
class PlaylistBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $twig = \Drupal::service('twig');

    $template = $twig->loadTemplate(
        drupal_get_path('module', 'songs') . '/templates/playlist.html.twig'
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