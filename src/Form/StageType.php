<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Entreprise;
use App\Entity\Formation;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('titre')
          ->add('activite')
          ->add('lieu')
          ->add('description')
          ->add('mail')
          ->add('formations', EntityType::class, array(
            'class' => Formation::class,
            'choice_label' => 'intitule',

            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true,
          ))
          ->add('entreprise', EntityType::class, array(
            'class' => Entreprise::class,
            'choice_label' => 'nom',

            // used to render a select box, check boxes or radios
            'multiple' => false,
            'expanded' => true,
          ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
