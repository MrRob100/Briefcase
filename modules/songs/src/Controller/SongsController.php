<?php 
namespace Drupal\songs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Template\TwigEnvironment;

class SongsController extends ControllerBase implements ContainerInjectionInterface 
{
  /**
  * @var Drupal\Core\Template\TwigEnvironment
  */
  protected $twig;

  public function __construct(TwigEnvironment $twig)
  {
    $this->twig = $twig;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('twig')
    );
  }

  /**
   * index
   * @param  string $name
   * @return string
   */
  public function index($name = 'hello') 
  {

    $template = $this->twig->loadTemplate(
      drupal_get_path('module', 'songs') . '/templates/home.html.twig'
    );

    //return val?

    $build = [
      'description' => [
        '#type' => 'inline_template',
        '#template' => file_get_contents($template),
      ]
      ];

    return $build;

  }
}