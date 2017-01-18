<?php

//the layout view
View::composer(array('administrator::layouts.default'), function ($view) {
    //set up the basic asset arrays
    $view->css = array();
    $view->js  = array(
        'jquery' => asset('packages/vancels/administrator/js/jquery/jquery-1.8.2.min.js'),
    );

    //add the non-custom-page css assets
    if (!$view->page && !$view->dashboard) {
        $view->css += array(
            'jquery-ui' => asset('packages/vancels/administrator/css/ui/jquery-ui-1.9.1.custom.min.css'),
        );
    }

    //add the package-wide css assets
    $view->css += array(
        'customscroll' => asset('packages/vancels/administrator/js/jquery/customscroll/customscroll.css'),
        'main'         => asset('packages/vancels/administrator/css/main.css'),
    );

    //add the non-custom-page js assets
    if (!$view->page && !$view->dashboard) {

        $view->js += array(
            'knockout' => asset('packages/vancels/administrator/js/knockout/knockout-2.2.0.js'),
        );
    }

    $view->js += array('page' => asset('packages/vancels/administrator/js/page.js'));
});
View::composer(array('administrator::public.nav'), function ($view) {
    $menu = app(\Vancels\Administrator\Menu::class)->getMenu();

    $view->nav = $menu;
});
View::composer(array('administrator::public.navs'), function ($view) {
    $menu = config("administrator.menu");
    $nav  = [];
    foreach ($menu as $key => $value) {
        if (is_array($value)) {
            // 下级
            $nav_child = [];
            foreach ($value as $child) {
                $nav_child[] = [
                    'selected' => "",
                    'url'      => '#',
                    'title'    => $child,
                ];
            }
            $nav[] = [
                'selected' => "",
                'url'      => '',
                'title'    => $key,
                'child'    => $nav_child,
            ];
        } else {
            // 直接
            $nav[] = [
                'selected' => "",
                'url'      => '#',
                'title'    => $value,
                'child'    => [],
            ];
        }
    }
    $view->nav = $nav;
});