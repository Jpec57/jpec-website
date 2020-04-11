<?php

namespace App\Traits;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

trait FormTrait
{
  private function getErrorsArray(Form $form): array {
    $errorArray = [];
    foreach ($form->all() as $field){
      /** @var FormError[] $errors */
      $errors = $field->getErrors(true);
      if (count($errors) > 0){
        $fieldError = [];
        foreach ($errors as $error){
          $fieldError[] = $error->getMessage();
        }
        $errorArray[$field->getName()] = $fieldError;
      }
    }
    return $errorArray;
  }
}