<?php 
namespace Drupal\songs\Controller;

use Drupal\Songs\SongService;
use Drupal\Core\Template\TwigEnvironment;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

class SongsController extends ControllerBase implements ContainerInjectionInterface 
{
    /**
     * @var Drupal\Core\Template\TwigEnvironment
    */
    protected $twig;

    /**
     * 
     */
    protected $songService;

    public function __construct(TwigEnvironment $twig, SongService $songService)
    {
        $this->twig = $twig;
        $this->songService = $songService;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('twig'),
            $container->get('songs.song')
        );
    }

    /**
     * index
     */
    public function index() 
    {

        return [];
    }

    /**
     * Displays admin page to upload, view and delete songs
     */
    public function admin($page = 1)
    {

        if ($page > 1) {
            $page = $page;
            $prev = true;
        } else {
            $page = 1;
            $prev = false;
        }

        $songs = $this->songService->read($page);

        /* detects if there is next page */
        $next = $this->songService->is_next($page);

        $form = \Drupal::formBuilder()->getForm('Drupal\songs\Form\SongsForm');

        $form['field']['value'] = 'From controller';
        $twig = \Drupal::service('twig');

        $template = 'tunes-admin-form';

        $template = $twig->loadTemplate(
            drupal_get_path('module', 'songs') . '/templates/'.$template.'.html.twig'
        );

        $build = [
                'description' => [
                '#type' => 'inline_template',
                '#template' => file_get_contents($template),
                '#context' => [
                    'form' => $form,
                    'songs' => $songs,
                    'page' => $page,
                    'prev' => $prev,
                    'next' => $next
                ]
            ]
        ];

        return $build;
    
    }

    public function delete($id)
    {

        $resp = $this->songService->delete($id);

        \Drupal::messenger()->addMessage($resp);

        return $this->redirect('songs.admin');

    }

}