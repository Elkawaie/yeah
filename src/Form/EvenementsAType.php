<?php

namespace App\Form;

use App\Entity\Evenements;
use App\Entity\Tarif;
use App\Entity\Entreprise;
use App\Entity\Tva;
use App\Entity\Clients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class EvenementsAType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $idTarif = $options['idTarif'];
        $idEntreprise = $options['idEntreprise'];
        $idClient = $options['idClient'];


        //Form pour tarifHoraire 
        $builder
                ->add('fkEntreprise', EntityType::class, array(
                    'class' => Entreprise::class,
                    'query_builder' => function (EntityRepository $er) use ($idEntreprise) {
                        return $er->createQueryBuilder('u')
                                ->where('u.id=' . $idEntreprise . '');
                    },
                    'disabled' => true,
                    'choice_label' => 'nom',
                    'label' => 'Votre Entreprise',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
                ->add('fkClient', EntityType::class, array(
                    'class' => Clients::class,
                    'query_builder' => function (EntityRepository $er) use ($idClient) {
                        return $er->createQueryBuilder('u')
                                ->where('u.id=' . $idClient . '');
                    },
                    'disabled' => true,
                    'label' => 'Votre client',
                    'choice_label' => 'nom',
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('startDate', DateTimeType::class, array(
                    'label' => 'Date de début',
                    'attr' => array(
                        'class' => 'form-control',
                        'type' => 'datetime-local'),
                ))
                ->add('endDate', DateTimeType::class, array(
                    'label' => 'Date de fin',
                    'attr' => array('class' => 'form-control',
                        'type' => 'datetime-local'),
                ))
                ->add('titre', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('description', TextareaType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('fkTarif', EntityType::class, [
                    'label' => 'Votre tarif',
                    'class' => Tarif::class,
                    'query_builder' => function (EntityRepository $er) use ($idTarif) {
                        return $er->createQueryBuilder('u')
                                // ->leftJoin('App\Entity\Entreprise', 'e')
                                ->where('u.id=' . $idTarif . '');
                    },
                   
                    'choice_label' => 'designation',
                    'attr' => array('class' => 'form-control'),
                ])
                ->add('quantite', IntegerType::class, array(
                    'attr' => array(
                        'class' => 'form-control number',
                        ),
                    ))
                ->add('fkTva', EntityType::class, array(
                    'class' => Tva::class,
                    'label' => 'TVA a appliqué.',
                    'choice_label' => 'designation',
                     'attr' => array('class' => 'form-control'),
                ))
                //->add('total')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenements::class,
            'idEntreprise' => 1,
            'idClient' => 1,
        ]);

        $resolver->setRequired(['idTarif']);
    }

}
