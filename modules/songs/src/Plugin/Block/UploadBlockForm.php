<?php
/**
 * @file
 * Contains \Drupal\songs\Plugin\Block\UploadBlockForm.
 */

namespace Drupal\songs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'Upload' block.
 *
 * @Block(
 *   id = "upload_block",
 *   admin_label = @Translation("Upload block"),
 *   category = @Translation("Upload songs form")
 * )
 */
class UploadBlockForm extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\songs\Form\SongsForm');

    return $form;
   }
}