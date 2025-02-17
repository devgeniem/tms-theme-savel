<?php

namespace TMS\Theme\Savel\ACF;

use Closure;
use Geniem\ACF\Field;

/**
 * Class AlterManualEventGroup
 */
class AlterManualEventGroup {

    /**
     * PageGroup constructor.
     */
    public function __construct() {
        \add_filter(
            'tms/acf/group/fg_manual_event_fields/fields',
            [ $this, 'remove_fields' ],
            10,
            1
        );
    }

    /**
     * Replace base theme hero with Muumimuseo hero.
     *
     * @param array $layouts Front page layouts.
     *
     * @return mixed
     */
    public function remove_fields( $fields ) {
        $fields[0]->remove_field( 'recurring_event' );
        $fields[0]->remove_field( 'dates' );
        $fields[0]->remove_field( 'end_datetime' );

        return $fields;
    }
}

( new AlterManualEventGroup() );
