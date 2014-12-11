<?php

namespace Inteco\KuPra\DefaultBundle\DataFixtures\ORM;

use Inteco\KuPRa\DefaultBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DefaultUsers implements FixtureInterface, ContainerAwareInterface
{
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

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $now = new \DateTime('now');
        // valdas
        $user = new User();
        $user->setNickname('Wambo');
        $user->setName('Karolis');
        $user->setSurname('Kačiulis');
        $user->setSalt(md5(uniqid()));
        $user->setAddress('Kaišiadorys Sodžiaus g. 11');
        $user->setDescription('Net nenutuokiu ką čia įrašyti');
        $user->setRole('ROLE_ADMIN');
        $user->setLoginName('admin');

        // hash password
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword('labas123', $user->getSalt());
        $user->setPassword($encodedPassword);

        $manager->persist($user);
        $manager->flush();

    }
}