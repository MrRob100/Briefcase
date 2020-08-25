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
 *   id = "playlist_block2",
 *   admin_label = @Translation("Playlist block 13"),
 *   category = @Translation("Custom block"),
 * )
 */
class PlaylistBlock2 extends BlockBase implements ContainerFactoryPluginInterface {

    protected $songService;
   
    public function __construct(array $configuration, $plugin_id, $plugin_definition, SongService $songService) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->songService = $songService;
    }

    public static function create(ContainerInterface $container, array $configuration,
    $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('songs.song')
        );
    }


    /**
     * {@inheritdoc}
     */
    public function build() {

        $twig = \Drupal::service('twig');
        $route_name = \Drupal::routeMatch()->getRouteName();

        $template = 'playlist-front';

        $page = \Drupal::request()->query->get('page') ;

        if ($page > 1) {
            $page = $page;
            $prev = true;
        } else {
            $page = 1;
            $prev = false;
        }

        $songs = $this->songService->read($page);

        $next = sizeof($songs) > 0 ? true : false;

        $template = $twig->loadTemplate(
            drupal_get_path('module', 'songs') . '/templates/'.$template.'.html.twig'
        );

        $build = [
                'description' => [
                '#type' => 'inline_template',
                '#template' => file_get_contents($template),
                '#context' => [
                    'songs' => $songs,
                    'route_name' => $route_name,
                    'page' => $page,
                    'prev' => $prev,
                    'next' => $next
                ]
            ]
        ];

        return $build;

    }
    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge() {
        return 0;
    }

}