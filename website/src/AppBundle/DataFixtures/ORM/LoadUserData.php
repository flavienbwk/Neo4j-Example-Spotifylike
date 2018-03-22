<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\DependencyInjection\ContainerAwareInterface;
use \Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements ORMFixtureInterface, ContainerAwareInterface {
    
    private $container;
    
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername("admin");
        $user->setEmail("admin@admin.com");
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, '0000');
        $user->setPassword($password);
        
        $manager->persist($user);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}
