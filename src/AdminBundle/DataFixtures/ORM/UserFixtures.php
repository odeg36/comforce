<?php
namespace AdminBundle\DataFixtures;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    public function getOrder()
    {
        return 1;
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
        $users = [
            [
                'username' => 'admin',
                'password' => 'admin',
                'firstname' => 'Administrator',
                'email' => 'admin@admin.com',
                'phone' => '123123123',
                'roles' => array('ROLE_ADMIN'),
                'enabled' => true,
            ],
        ];
        foreach ($users as $u) {
            $user = new User();
            //Generate Password
            $encoder = $this->container
                ->get('security.encoder_factory')
                ->getEncoder($user);

            $password = $encoder->encodePassword($u['password'], $user->getSalt());
            $user->setPassword($password);
            $user->setUsername($u['username']);
            $user->setFirstname($u['firstname']);
            $user->setEmail($u['email']);
            $user->setPhone($u['phone']);
            $user->setRoles($u['roles']);
            $user->setEnabled($u['enabled']);
            if (in_array('ROLE_ADMIN', $u['roles'])) {
                $user->setSuperAdmin(true);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}
