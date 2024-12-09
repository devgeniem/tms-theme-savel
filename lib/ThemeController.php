<?php

namespace TMS\Theme\Savel;

use ArchiveExhibition;
use TMS\Theme\Base\Interfaces;

/**
 * ThemeController
 */
class ThemeController extends \TMS\Theme\Base\ThemeController {

    /**
     * Init classes
     */
    protected function init_classes() : void {
        $classes = [
            IndexController::class,
            Assets::class,
            ACFController::class,
            PostTypeController::class,
            TaxonomyController::class,
            Localization::class,
            FormatterController::class,
            ThemeCustomizationController::class,
            ThemeSupports::class,
            RolesController::class,
        ];

        array_walk( $classes, function ( $class ) {
            $instance = new $class();

            if ( $instance instanceof Interfaces\Controller ) {
                $instance->hooks();
            }
        } );

        \add_action( 'init', function () {
            ArchiveExhibition::hooks();
        } );
    }
}