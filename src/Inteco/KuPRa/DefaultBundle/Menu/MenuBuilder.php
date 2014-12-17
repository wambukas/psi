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

        $menu->addChild('Šaldytuvas', array(
            'route' => '_fridge',
        ));

        $menu->addChild('Matavimo vienetai', array(
            'route' => '_measurement',
        ));

        $menu->addChild('Produktai', array(
            'route' => '_products',
        ));

        $menu->addChild('Receptai', array(
            'route' => '_recipes',
        ));

        $menu->addChild('Tvarkaraštis', array(
            'route' => '_menu',
        ));

        return $menu;
    }

}