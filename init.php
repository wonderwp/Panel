<?php

use WonderWp\Component\Panel\Metabox\Metabox;
use WonderWp\Component\Panel\PanelManager;
use WonderWp\Component\Panel\PostFieldPanel\PostFieldPanel;
use WonderWp\Component\DependencyInjection\Container;

add_action('wonderwp.loader.load', 'wwp_register_panel_definitions_towards_container', 10, 2);

function wwp_register_panel_definitions_towards_container(Container $container)
{
    /**
     * Panels and MetaBoxes
     */
    $container['wwp.panel.Manager'] = function () {
        return new PanelManager();
    };
    $container['wwp.panel.Panel']   = $container->factory(function () {
        return new PostFieldPanel();
    });
    $container['wwp.panel.metabox'] = $container->factory(function () {
        return new Metabox();
    });
}
