<?php

namespace Inteco\KuPRa\DefaultBundle\Manager;

use Inteco\KuPRa\DefaultBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Locale\Exception\NotImplementedException;

/**
 * Class MealManager
 * @package Inteco\KuPRa\DefaultBundle\Manager
 */
class UserManager {

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Meal
     */
    public function create()
    {
        $userManager = new User();
        return $userManager;
    }

    /**
     * @param User $user
     */
    public function register(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     */
    public function update(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}