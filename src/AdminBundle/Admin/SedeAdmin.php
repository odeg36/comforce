<?php
namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class SedeAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre', null, [
                'label' => 'campo.nombre',
            ])
            ->add('fechaCreacion', null, [
                'label' => 'campo.fecha_creacion',
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nombre', null, [
                'label' => 'campo.nombre',
            ])
            ->add('fechaCreacion', null, [
                'label' => 'campo.fecha_creacion',
            ])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', null, [
                'label' => 'campo.nombre',
                'constraints' => [
                    new NotNull(),
                    new Length([
                        'max' => 255,
                        ])
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombre', null, [
                'label' => 'campo.nombre',
            ])
            ->add('fechaCreacion', null, [
                'label' => 'campo.fecha_creacion',
            ])
        ;
    }
}
