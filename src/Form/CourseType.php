<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('image' , FileType::class, [
                'data_class' => null
            ])
            ->add('nb_enrollments')
            ->add('details')
            ->add('link')
            ->add('nb_likes')
            ->add('quizzes', EntityType::class, [
                // looks for choices from this entity
                'class' => Quiz::class,
                'label' => 'Quiz',
          // uses the category name property as the visible option string
                'choice_label' => 'title',
               
                
                'attr' => [
                    'class' =>'select',
                    'expended'=>False,
                    'multiple'=>True,
                ],
                ])
       
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
