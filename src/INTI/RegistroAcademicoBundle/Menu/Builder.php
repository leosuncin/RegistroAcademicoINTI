<?php

namespace INTI\RegistroAcademicoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function asideMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('List Header');
        $item->addChild('.icon-home Inicio', array('route' => 'index'));
        $expediente = $item->addChild('.icon-book Aspirantes', array('route' => 'expediente_aspirante'));
        $item->addChild('.icon-briefcase Empleados', array('route' => 'admin_empleado'));
        $item = $menu->addChild('Another List Header');
        $item->addChild('.icon-user Profile', array('uri' => '#'));
        $item->addChild('.icon-cog Settings', array('uri' => '#'));
        $menu->addChild('d1', array('attributes' => array('divider' => true)));
        $menu->addChild('.icon-question-sign Help', array('uri' => '#'));
        
        return $menu;
    }

    public function empleadoIndexBreadcrumbMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Principal', array('route' => 'index'));
        $menu->addChild('Empleado')->setCurrent(true);
        return $menu;
    }
}
