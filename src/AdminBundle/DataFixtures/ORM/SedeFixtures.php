<?php
namespace AdminBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LogicBundle\Entity\Sede;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SedeFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    public function getOrder()
    {
        return 2;
    }

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $em = $this->container->get('doctrine')->getManager();
        $sedes = [
            [
                'nombre' => 'Bogotá',
            ],
            [
                'nombre' => 'México',
            ],
            [
                'nombre' => 'Peru',
            ],
        ];
        foreach ($sedes as $s) {
            $sede = new Sede();
            $sede->setNombre($s['nombre']);
            $manager->persist($sede);
        }
        $manager->flush();
    }
}
