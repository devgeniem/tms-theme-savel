<?php

namespace TMS\Theme\Savel\ACF;

use Closure;
use Geniem\ACF\Field;
use Geniem\ACF\Exception;
use TMS\Theme\Base\Logger;

/**
 * AlterSettingsGroup
 */
class AlterSettingsGroup {

    /**
     * Constructor
     */
    public function __construct() {
        \add_filter(
            'tms/acf/group/fg_site_settings/fields',
            [ $this, 'remove_theme_color_setting' ],
            100
        );
    }

    /**
     * Remove color tab from settings
     *
     * @param Field\Tab[] $fields Array of settings tabs.
     *
     * @return array
     */
    public function remove_theme_color_setting( $fields ) {
        foreach ( $fields as $field ) {
            if ( $field->get_name() === 'Teeman ulkoasu' ) {
                $field->remove_field( 'theme_color' );
            }
        }

        return $fields;
    }
}

( new AlterSettingsGroup() );
