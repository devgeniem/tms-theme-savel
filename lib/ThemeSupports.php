<?php

namespace TMS\Theme\Savel;

use Closure;
use TMS\Theme\Base\Interfaces\Controller;

/**
 * Class ThemeSupports
 *
 * @package TMS\Theme\Sara_Hilden
 */
class ThemeSupports implements Controller {

    /**
     * Initialize the class' variables and add methods
     * to the correct action hooks.
     *
     * @return void
     */
    public function hooks(): void {
        // Allow custom url links to be added in menus
        \add_filter(
            'tms/theme/remove_custom_links',
            '__return_false'
        );

        \add_filter( 'tms_afc_image_shape_choices', \Closure::fromCallable( [
            $this,
            'acf_image_shape_choices',
        ] ), 10, 3 );
    }

        /**
     * ACF layout brand color field choices
     *
     * @return string[]
     */
    private function acf_image_shape_choices() : array {
        return [
            'default'                         => 'Ei muotoa',
            'shape shape--summertime-sadness' => 'Apila',
            'shape shape--drop'               => 'Pisara',
            'shape shape--soft-flower'        => 'Nelireunainen kukka',
            'shape shape--flower'             => 'Kukka',
            'shape shape--polygon'            => 'Monikulmio',
            'shape shape--rainbow'            => 'Sateenkaari',
        ];
    }
}
