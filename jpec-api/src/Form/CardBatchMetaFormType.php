<?php

namespace App\Form;

use App\Entity\CardBatchMeta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardBatchMetaFormType extends AbstractType
{
  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('cards', CollectionType::class, [
          'entry_type' => CardBatchFormType::class,
          'by_reference' => false,
          'allow_add' => true,
          'allow_delete' => true,
          'required' => true
        ]
      );
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => CardBatchMeta::class,
      'csrf_protection' => false
    ]);
  }
}