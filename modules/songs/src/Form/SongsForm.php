<?php

namespace Drupal\songs\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SongsForm extends FormBase {

  public function getFormId() {
    return 'song_upload';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // $form['#attributes'] = array('enctype' => "multipart/form-data");

    // $form['#attributes']['enctype'] = "multipart/form-data";

    // $form['enctype'] = 'multipart/form-data';

    $form['song'] = [
      '#id' => 'song_input',
      '#type' => 'file',
      '#title' => $this->t('Upload song (form in form)'),
    ];

    $form['submit'] = [
      '#id' => 'song_submit',
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
    ];

    /* renders playlist but not form above */
    // $form['#theme'] = 'tunes_admin_form';

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

