<?php

namespace App\Traits;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

trait FormTrait
{
  private function getErrorsArray(Form $form): array
  {
    $errors = array();

    if ($form->count() > 0) {
      foreach ($form->all() as $child) {
        /**
         * @var Form $child
         */
        if (!$child->isValid()) {
          $errors[$child->getName()] = $this->getErrorsArray($child);
        }
      }
    } else {
      /**
       * @var FormError $error
       */
      foreach ($form->getErrors() as $key => $error) {
        $errors[] = $error->getMessage();
      }
    }

    return $errors;
  }
}