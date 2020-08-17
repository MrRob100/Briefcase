<?php

namespace Drupal\songs\Plugin\Block;

use Drupal\Songs\SongService;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom Block.
 *
 * @Block(
 *   id = "new_block",
 *   admin_label = @Translation("New block 3"),
 *   category = @Translation("Custom header"),
 * )
 */
// class NewBlock extends BlockBase {
class NewBlock extends BlockBase implements ContainerFactoryPluginInterface {

    protected $songService;
   
    public function __construct($plugin_id, $plugin_definition, SongService $songService) {
        parent::__construct($plugin_id, $plugin_definition);
        $this->songService = $songService;
    }

    public static function create(ContainerInterface $container,
    $plugin_id, $plugin_definition) {
        return new static(
            $plugin_id,
            $plugin_definition,
            $container->get('songs.song')
        );
    }

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