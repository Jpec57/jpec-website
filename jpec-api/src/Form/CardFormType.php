<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Deck;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CardFormType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('id', IntegerType::class, [])
      ->add('question', TextType::class, [
          'constraints' => [
            new Assert\NotNull(),
            new Assert\NotBlank(),
            new Assert\Length(['min' => 1]),
          ],
        ]
      )
      ->add('deck', EntityType::class, [
        'class' => Deck::class
      ])
      ->add('languageCode', IntegerType::class, [
        'required' => false,
        'empty_data' => '' . Card::LANGUAGE_JAPANESE_CODE
      ])
      ->add('answerLanguageCode', IntegerType::class, [
        'required' => false,
        'empty_data' => '' . Card::LANGUAGE_ENGLISH_CODE
      ])
      ->add('isReversible', ChoiceType::class, [
        'choices' => ['Yes' => true, 'No' => false],
        'empty_data' => true
      ])
      ->add('hint', TextType::class, [
        'required' => false
      ])
      ->add('answers', CollectionType::class, [
        'entry_type' => AnswerFormType::class,
        'by_reference' => false,
        'allow_add' => true,
        'allow_delete' => true,
        'required' => false
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Card::class,
      'csrf_protection' => false
    ]);
  }
}