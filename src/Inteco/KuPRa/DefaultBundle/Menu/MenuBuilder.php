<?php

namespace Inteco\KuPRa\DefaultBundle\Menu;

use Doctrine\Common\Persistence\ObjectManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class MenuBuilder
 * @package Inteco\KuPRa\DefaultBundle\Menu
 */
class MenuBuilder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     * @param ObjectManager $entityManager
     */
    public function __construct(
        FactoryInterface $factory
    )
    {
        $this->factory                  = $factory;
    }

    /**
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'main_menu');

        $menu->addChild('Fridge', array(
            'route' => '_fridge',
        ));

        $menu->addChild('Measurements', array(
            'route' => '_measurement',
        ));

        $menu->addChild('Products', array(
            'route' => '_products',
        ));

        $menu->addChild('Recipes', array(
            'route' => '_recipe',
        ));

        $menu->addChild('Menus', array(
            'route' => '_menu',
        ));

        return $menu;
    }

}