<?php
namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class ProcesoAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numeroProceso', null, [
                'label' => 'campo.numero_proceso',
            ])
            ->add('sede', null, [
                'label' => 'campo.sede',
            ])
            ->add('fechaCreacion', 'doctrine_orm_date_range', [
                'field_type' => 'sonata_type_date_range_picker',
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('numeroProceso', null, [
                'label' => 'campo.numero_proceso',
            ])
            ->add('presupuesto', 'currency', [
                'currency' => 'COP',
                'template' => 'AdminBundle:Proceso:presupuesto_list.html.twig'
            ])
            ->add('sede', null, [
                'label' => 'campo.sede',
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

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('descripcion', TextareaType::class, [
                'label' => 'campo.descripcion',
                'constraints' => [
                    new NotNull(),
                    new Length([
                        'max' => 200,
                        ])
                ]
            ])
            ->add('sede', null, [
                'label' => 'campo.sede',
            ])
            ->add('presupuesto', MoneyType::class, [
                'required' => false,
                'label' => 'campo.presupuesto',
                'currency' => 'COP'
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numeroProceso', null, [
                'label' => 'campo.numero_proceso',
            ])
            ->add('descripcion', null, [
                'label' => 'campo.descripcion',
            ])
            ->add('presupuesto', 'currency', [
                'currency' => 'COP',
                'template' => 'AdminBundle:Proceso:presupuesto_show.html.twig'
            ])
            ->add('sede', null, [
                'label' => 'campo.sede',
            ])
            ->add('fechaCreacion', null, [
                'label' => 'campo.fecha_creacion',
            ])
        ;
    }
}
