<?php

namespace INTI\RegistroAcademicoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createBreadcrumbMenu(Request $request)
    {
        $menu = $this->$factory->createItem('root');

        $menu->addChild('Principal', array('route' => 'index'));
        switch ($request->get('_route')) {
            case 'aspirante_index':
                $menu->addChild('Aspirante')->setCurrent(true);
                break;
            case 'aspirante_create':
            case 'aspirante_new':
                $menu->addChild('Aspirante', array('route' => 'aspirante_index'));
                $menu->addChild('Crear')->setCurrent(true);
                break;
            case 'aspirante_show':
                $menu->addChild('Aspirante', array('route' => 'aspirante_index'));
                $menu->addChild('Mostrar')->setCurrent(true);
                break;
            case 'aspirante_edit':
            case 'aspirante_update':
                $menu->addChild('Aspirante', array('route' => 'aspirante_index'));
                $menu->addChild('Modificar')->setCurrent(true);
                break;
            case 'aspirante_delete':
                # code...
                break;
            case 'aspirante_index':
                # code...
                break;
            case 'aspirante_index':
                # code...
                break;
            
            default:
                # code...
                break;
        }

        return $menu;
    }
}