<?php
namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;

class DisciplinaAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codigo', null, array('label' => 'formulario.codigo'))
            ->add('nombre')


        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codigo', null, array('label' => 'formulario.codigo'))
            ->add('nombre')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codigo')
            ->add('nombre')
            ->add('imagenes', CollectionType::class, [
                'required' => false,
                'by_reference' => false,
                'type_options' => [
                    'delete' => true
                ],
                'btn_add' => 'Agregar nuevo'
                ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codigo', null, array('label' => 'formulario.codigo'))
            ->add('nombre')


        ;
    }

    public function prePersist($disciplina)
    {
        $this->manageEmbeddedImageAdmins($disciplina);
    }

    public function preUpdate($disciplina)
    {
        $this->manageEmbeddedImageAdmins($disciplina);
    }

    private function manageEmbeddedImageAdmins($disciplina)
    {

        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldDescription->getType() === 'Sonata\CoreBundle\Form\Type\CollectionType' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'LogicBundle\Entity\Imagen'
            ) {
                $getter = 'get' . $fieldName;
                $setter = 'set' . $fieldName;

                /** @var Image $image */
                $images = $disciplina->$getter();
                foreach ($images as $image) {
                    if ($image) {
                        if ($image->getArchivo()) {
                            // update the Image to trigger file management
                            $image->refreshUpdated();
                        } elseif (!$image->getArchivo() && !$image->getNombreArchivo()) {
                            // prevent Sf/Sonata trying to create and persist an empty Image
                            $disciplina->$setter(null);
                        }
                    }
                }
            }
        }
    }
}
