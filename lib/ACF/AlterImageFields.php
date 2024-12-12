<?php
/**
 *  Copyright (c) 2021. Geniem Oy
 */

use TMS\Theme\Base\Logger;

/**
 * Alter Image Fields
 */
class AlterImageFields {

    /**
     * Constructor
     */
    public function __construct() {
        \add_filter(
            'tms/block/image/fields',
            [ $this, 'alter_fields' ],
            10,
            2
        );
    }

    /**
     * Alter fields
     *
     * @param array $fields Array of ACF fields.
     *
     * @return array
     */
    public function alter_fields( array $fields ) : array {
        $s = [
            'image_shape' => [
                'title'        => 'Kuvan muoto',
                'instructions' => 'Valitse kuvan muoto',
            ],
        ];

        try {
            $image_shape = ( new \Geniem\ACF\Field\Select( $s['image_shape']['title'] ) )
                ->set_key( 'image_image_shape' )
                ->set_name( 'image_shape' )
                ->set_choices( [
                    'default'                         => 'Ei muotoa',
                    'shape shape--summertime-sadness' => 'Apila',
                    'shape shape--drop'               => 'Pisara',
                    'shape shape--soft-flower'        => 'Nelireunainen kukka',
                    'shape shape--flower'             => 'Kukka',
                    'shape shape--polygon'            => 'Monikulmio',
                    'shape shape--rainbow'            => 'Sateenkaari',
                ] );

            $fields[] = $image_shape;
        }
        catch ( \Exception $e ) {
            ( new Logger() )->error( $e->getMessage(), $e->getTraceAsString() );
        }

        return $fields;
    }
}

( new AlterImageFields() );