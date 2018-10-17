<?php
namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UsuarioAdmin extends AbstractAdmin
{

    protected $em;

    public function setConfigurationPool(Pool $configurationPool)
    {
        parent::setConfigurationPool($configurationPool);
        $this->em = $configurationPool->getContainer()->get("doctrine")->getManager();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname', null, [
                'label' => 'campo.nombres'
            ])
            ->add('lastname', null, [
                'label' => 'campo.apellidos'
            ])
            ->add('email', null, [
            ])
            ->add('enabled', null, [
                'label' => 'campo.habilitado'
            ])
            ->add('groups', null, [
                'label' => 'campo.grupos'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstname', null, [
                'label' => 'campo.nombres'
            ])
            ->add('lastname', null, [
                'label' => 'campo.apellidos'
            ])
            ->add('email', null, [
            ])
        ;
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $listMapper
                ->add('enabled', null, [
                    'editable' => true,
                    'label' => 'campo.habilitado'
                ])
                ->add('groups', null, [
                    'label' => 'campo.grupos'
                ])
            ;
        }
        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $listMapper
                ->add('impersonating', 'string', [
                    'label' => 'campo.personificar',
                    'template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig'
                ])
            ;
        }
        $listMapper
            ->add('_action', null, array(
                'label' => 'titulo.acciones',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->tab('User', ['label' => 'titulo.usuario'])
            ->with('Profile', array('class' => 'col-md-6', 'label' => 'titulo.perfil'))->end()
            ->with('General', array('class' => 'col-md-6', 'label' => 'titulo.general'))->end()
            ->with('Social', array('class' => 'col-md-6', 'label' => 'titulo.redes_sociales'))->end()
            ->end()
            ->tab('Security', ['label' => 'campo.seguridad'])
            ->with('Status', array('class' => 'col-md-4', 'label' => 'titulo.estado'))->end()
            ->with('Groups', array('class' => 'col-md-4', 'label' => 'titulo.grupos'))->end()
            ->with('Keys', array('class' => 'col-md-4', 'label' => 'titulo.llaves'))->end()
            ->with('Roles', array('class' => 'col-md-12', 'label' => 'titulo.roles'))->end()
            ->end()
        ;

        $now = new \DateTime();

        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $textType = 'Symfony\Component\Form\Extension\Core\Type\TextType';
            $datePickerType = 'Sonata\CoreBundle\Form\Type\DatePickerType';
            $urlType = 'Symfony\Component\Form\Extension\Core\Type\UrlType';
            $userGenderType = 'Sonata\UserBundle\Form\Type\UserGenderListType';
            $localeType = 'Symfony\Component\Form\Extension\Core\Type\LocaleType';
            $timezoneType = 'Symfony\Component\Form\Extension\Core\Type\TimezoneType';
            $modelType = 'Sonata\AdminBundle\Form\Type\ModelType';
            $securityRolesType = 'Sonata\UserBundle\Form\Type\SecurityRolesType';
        } else {
            $textType = 'text';
            $datePickerType = 'sonata_type_date_picker';
            $urlType = 'url';
            $userGenderType = 'sonata_user_gender';
            $localeType = 'locale';
            $timezoneType = 'timezone';
            $modelType = 'sonata_type_model';
            $securityRolesType = 'sonata_security_roles';
        }

        $formMapper
            ->tab('User')
            ->with('General')
            ->add('username', null, [
                'label' => 'campo.username'
            ])
            ->add('email')
            ->add('plainPassword', $textType, array(
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                'label' => 'campo.contrasena'
            ))
            ->end()
            ->with('Profile')
            ->add('dateOfBirth', $datePickerType, array(
                'years' => range(1900, $now->format('Y')),
                'dp_min_date' => '1-1-1900',
                'dp_max_date' => $now->format('c'),
                'required' => false,
                'label' => 'campo.fecha_nacimiento'
            ))
            ->add('firstname', null, array('required' => false,
                'label' => 'campo.nombres'))
            ->add('lastname', null, array('required' => false,
                'label' => 'campo.apellidos'))
            ->add('website', $urlType, array('required' => false,
                'label' => 'campo.sitio_web'))
            ->add('biography', $textType, array('required' => false,
                'label' => 'campo.biografia'))
            ->add('gender', $userGenderType, array(
                'required' => true,
                'label' => 'campo.genero',
                'translation_domain' => $this->getTranslationDomain(),
            ))
            ->add('locale', $localeType, array('required' => false,
                'label' => 'campo.ubicacion'))
            ->add('timezone', $timezoneType, array('required' => false,
                'label' => 'campo.zona_horaria'))
            ->add('phone', null, array('required' => false,
                'label' => 'campo.telefono'))
            ->end()
            ->with('Social')
            ->add('facebookUid', null, array('required' => false,
                'label' => 'campo.facebook_id'))
            ->add('facebookName', null, array('required' => false,
                'label' => 'campo.facebook_nombre'))
            ->add('twitterUid', null, array('required' => false,
                'label' => 'campo.twitter_id'))
            ->add('twitterName', null, array('required' => false,
                'label' => 'campo.twitter_nombre'))
            ->add('gplusUid', null, array('required' => false,
                'label' => 'campo.google_id'))
            ->add('gplusName', null, array('required' => false,
                'label' => 'campo.google_nombre'))
            ->end()
            ->end()
            ->tab('Security')
            ->with('Status')
            ->add('enabled', null, array('required' => false,
                'label' => 'campo.habilitado'))
            ->end()
            ->with('Groups')
            ->add('groups', $modelType, array(
                'label' => 'campo.grupos',
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ))
            ->end()
            ->with('Roles')
            ->add('realRoles', $securityRolesType, array(
                'label' => 'campo.roles',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ))
            ->end()
            ->with('Keys')
            ->add('token', null, array('required' => false,
                'label' => 'campo.token',))
            ->add('twoStepVerificationCode', null, array('required' => false,
                'label' => 'campo.codigo_verificacion_dos_pasos',))
            ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
            ->add('username')
            ->add('email')
            ->end()
            ->with('Groups')
            ->add('groups')
            ->end()
            ->with('Profile')
            ->add('dateOfBirth')
            ->add('firstname')
            ->add('lastname')
            ->add('website')
            ->add('biography')
            ->add('gender')
            ->add('locale')
            ->add('timezone')
            ->add('phone')
            ->end()
            ->with('Social')
            ->add('facebookUid')
            ->add('facebookName')
            ->add('twitterUid')
            ->add('twitterName')
            ->add('gplusUid')
            ->add('gplusName')
            ->end()
            ->with('Security')
            ->add('token')
            ->add('twoStepVerificationCode')
            ->end()
        ;
    }
}
