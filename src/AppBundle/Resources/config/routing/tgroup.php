<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('tgroup_index', new Route(
    '/',
    array('_controller' => 'AppBundle:TGroup:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('tgroup_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:TGroup:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('tgroup_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:TGroup:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('tgroup_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:TGroup:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('tgroup_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:TGroup:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
