<?php
use TMS\Theme\Base\Logger;

/**
 * Alter Page settings -fields
 */
class AlterPageSettingsFields {

    /**
     * Constructor
     */
    public function __construct() {
        \add_filter(
            'tms/acf/group/fg_page_settings',
            [ $this, 'remove_hero_overlay_setting' ],
            100
        );
    }


    /**
     * Remove overlay TrueFalse-field from page settings
     *
     * @param Field\Group $group Group-object of settings.
     *
     * @return array
     */
    public function remove_hero_overlay_setting( $group ) {
        try {
            if ( $group->get_key() === 'fg_page_settings' ) {
                $s = [
                    'image_shape' => [
                        'title'        => 'Kuvan muoto',
                        'instructions' => 'Valitse kuvan muoto',
                    ],
                ];

                $image_shape = ( new \Geniem\ACF\Field\Select( $s['image_shape']['title'] ) )
                ->set_key( 'fg_page_settings_image_shape' )
                ->set_name( 'image_shape' )
                ->set_instructions( $s['image_shape']['instructions'] )
                ->set_choices( \apply_filters( 'tms_afc_image_shape_choices', [] ) );

                $group->add_field( $image_shape );

                $group->remove_field( 'fg_page_settings_remove_overlay' );
            }
        }
        catch ( Exception $e ) {
            ( new Logger() )->error( $e->getMessage(), $e->getTrace() );
        }

        return $group;
    }
}

( new AlterPageSettingsFields() );
