<?php

namespace TMS\Theme\Savel\ACF\Layouts;

use Geniem\ACF\Exception;
use Geniem\ACF\Field;
use Geniem\ACF\Field\Flexible\Layout;
use TMS\Theme\Base\Logger;

/**
 * Class TimelineLayout
 *
 * @package TMS\Theme\Savel\ACF\Layouts
 */
class TimelineLayout extends Layout {

    /**
     * Layout key
     */
    const KEY = '_timeline';

    /**
     * Create the layout
     *
     * @param string $key Key from the flexible content.
     */
    public function __construct( string $key ) {
        parent::__construct(
            'Aikajana',
            $key . self::KEY,
            'timeline'
        );

        $this->add_layout_fields();
    }

    /**
     * Add layout fields.
     *
     * @return void
     * @throws Exception In case of invalid option.
     */
    public function add_layout_fields() : void {
        $key = $this->get_key();

        $strings = [
            'repeater' => [
                'label'        => 'Osiot',
                'instructions' => '',
            ],
            'image'     => [
                'label'        => 'Kuva',
                'instructions' => '',
            ],
            'year'     => [
                'label'        => 'Vuosi',
                'instructions' => 'Kirjoita vuosi-teksti ilman välilyöntejä, jotta ankkurilinkit toimii',
            ],
            'title'    => [
                'label'        => 'Otsikko',
                'instructions' => '',
            ],
            'content'  => [
                'label'        => 'Tekstisisältö',
                'instructions' => '',
            ],
        ];

        $repeater = ( new Field\Repeater( $strings['repeater']['label'] ) )
            ->set_key( "{$key}_repeater" )
            ->set_name( 'repeater' )
            ->set_layout( 'block' )
            ->set_instructions( $strings['repeater']['instructions'] );

        $image_field = ( new Field\Image( $strings['image']['label'] ) )
            ->set_key( "{$key}_image" )
            ->set_name( 'image' )
            ->set_required()
            ->set_instructions( $strings['image']['instructions'] );

        $year_field = ( new Field\Text( $strings['year']['label'] ) )
            ->set_key( "{$key}_year" )
            ->set_name( 'year' )
            ->set_required()
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['year']['instructions'] );

        $title_field = ( new Field\Text( $strings['title']['label'] ) )
            ->set_key( "{$key}_title" )
            ->set_name( 'title' )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['title']['instructions'] );

        $content_field = ( new Field\Textarea( $strings['content']['label'] ) )
            ->set_key( "{$key}_content" )
            ->set_name( 'content' )
            ->set_rows( 4 )
            ->set_new_lines( 'br' )
            ->set_instructions( $strings['content']['instructions'] );

        $repeater->add_fields( [
            $image_field,
            $year_field,
            $title_field,
            $content_field,
        ] );


        try {
            $this->add_fields(
                \apply_filters(
                    'tms/acf/layout/timeline/fields',
                    [ $repeater ],
                    $key
                )
            );
        }
        catch ( Exception $e ) {
            ( new Logger() )->error( $e->getMessage(), $e->getTrace() );
        }
    }
}
