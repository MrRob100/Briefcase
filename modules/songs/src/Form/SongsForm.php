<?php

namespace Drupal\songs\Form;

use \Drupal\Songs\SongService;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SongsForm extends FormBase {


  protected $songService;

  public function __construct(SongService $songService) {
      $this->songService = $songService;
  }

  public static function create(ContainerInterface $container) {
      return new static(
          $container->get('songs.song')
      );
  }

  public function getFormId() {
    return 'song_upload';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $song_list = $this->songService->read();

    $form['song'] = [
      '#type' => 'file',
      '#title' => $this->t('Upload song'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
    ];

    foreach ($song_list as $song) {

        $form[$song->name]['#markup'] = t('<p>'.$song->name.'</p>');
    }




    return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      
      $form_field_name = 'song';
      $validators = array('file_validate_extensions' => array("mp3 wav aif"));

      $destination = 'public://songs'; 

      $save = file_save_upload($form_field_name, $validators, $destination);

      if (is_null($save)) {

          \Drupal::logger('songs')->alert('Failed to upload file (1)');
          \Drupal::messenger()->addError('Failed to upload file (1)');
        
          return;

      } else {
        if (!array_key_exists('0', $save)) {
          //no file chosen

          \Drupal::logger('songs')->alert('No file chosen');
          \Drupal::messenger()->addError('No file chosen');
          
          return;
        }

        if ($save[0] === false) { 
          //wrong file type or other issue uploading & saving

          \Drupal::logger('songs')->alert('Failed to upload file');
          \Drupal::messenger()->addError('Failed to upload file');
        
          return;
        }
      }

      // create database record
      $connection = \Drupal::database();

      $file_name = $_FILES['files']['name']['song'];

      $insert = $connection->insert('songs')->fields(
        array(
          'name' => $file_name
        )
      );

      try {
        $insert->execute();
      } catch (\Exception $e) {

        \Drupal::logger('songs')->alert('Failed to create record in database: '. $e->getMessage());
        \Drupal::messenger()->addError('Failed to create record in database');

        return;
      }

      \Drupal::messenger()->addMessage('Song uploaded successfully');
    }

}

