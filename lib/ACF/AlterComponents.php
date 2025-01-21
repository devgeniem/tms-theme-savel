<?php
/**
 *  Copyright (c) 2021. Geniem Oy
 */

namespace TMS\Theme\Savel\ACF;

use TMS\Theme\Savel\ACF\Layouts\TimelineLayout;

/**
 * AlterComponents
 */
class AlterComponents {

    /**
     * Constructor
     */
    public function __construct() {
        \add_filter(
            'tms/acf/field/fg_page_components_components/layouts',
            [ $this, 'add_html_layout' ],
            10,
            2
        );
    }

    /**
     * Add Timeline layout to components
     *
     * @param array  $layouts Array of ACF Layouts.
     * @param string $key     Field group key.
     *
     * @return array
     */
    public function add_html_layout( array $layouts, string $key ): array {
        $layouts[] = new TimelineLayout( $key );

        return $layouts;
    }
}

( new AlterComponents() );
