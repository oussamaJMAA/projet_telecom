<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\QuizQuestions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizQuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('quiz', EntityType::class, [
            // looks for choices from this entity
            'class' => Quiz::class,
            'label' => 'Quiz',
      // uses the category name property as the visible option string
            'choice_label' => 'title',
           
            
            'attr' => [
                'class' =>'select',
            ],
            ])
   
            ->add('Question')
            ->add('choiceA')
            ->add('choiceB')
            ->add('choiceC')
            ->add('choiceD')
            ->add('CorrectAnswer')
            ->add('Explanation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestions::class,
        ]);
    }
}
