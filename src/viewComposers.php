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
