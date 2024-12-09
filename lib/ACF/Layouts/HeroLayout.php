<?php

namespace TMS\Theme\Savel\ACF\Layouts;

use Geniem\ACF\Exception;
use Geniem\ACF\Field;
use Geniem\ACF\Field\Flexible\Layout;
use TMS\Theme\Base\Logger;

/**
 * Class HeroLayout
 *
 * @package TMS\Theme\Savel\ACF\Layouts
 */
class HeroLayout extends Layout {

    /**
     * Layout key
     */
    const KEY = '_hero';

    /**
     * Create the layout
     *
     * @param string $key Key from the flexible content.
     */
    public function __construct( string $key ) {
        parent::__construct(
            'Hero',
            $key . self::KEY,
            'hero'
        );

        $this->add_layout_fields();
    }

    /**
     * Add layout fields.
     *
     * @return array
     * @throws Exception In case of invalid option.
     */
    public function add_layout_fields() : array {
        $key = $this->get_key();

        $strings = [
            'image'         => [
                'label'        => 'Kuva',
                'instructions' => '',
            ],
            'title'         => [
                'label'        => 'Otsikko',
                'instructions' => '',
            ],
            'title_image'         => [
                'label'        => 'Otsikon taustakuva',
                'instructions' => '',
            ],
            'description'   => [
                'label'        => 'Kuvaus',
                'instructions' => '',
            ],
            'link'          => [
                'label'        => 'Painike',
                'instructions' => '',
            ],
            'align'         => [
                'label'        => 'Tekstin tasaus',
                'instructions' => '',
            ],
            'info_column' => [
                'label'  => 'Lisätietoja',
                'title'  => [
                    'label'        => 'Otsikko',
                    'instructions' => '',
                ],
                'text'   => [
                    'label'        => 'Teksti',
                    'instructions' => '',
                ],
                'button' => [
                    'label'        => 'Painike',
                    'instructions' => '',
                ],
                'image'  => [
                    'label'        => 'Kuva',
                    'instructions' => '',
                ],
            ],
        ];

        $image_field = ( new Field\Image( $strings['image']['label'] ) )
            ->set_key( "{$key}_image" )
            ->set_name( 'image' )
            ->set_return_format( 'id' )
            ->set_required()
            ->set_instructions( $strings['image']['instructions'] );

        $title_field = ( new Field\Text( $strings['title']['label'] ) )
            ->set_key( "{$key}_title" )
            ->set_name( 'title' )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['title']['instructions'] );

        $title_image_field = ( new Field\Image( $strings['title_image']['label'] ) )
            ->set_key( "{$key}_title_image" )
            ->set_name( 'title_image' )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['title_image']['instructions'] );

        $description_field = ( new Field\Textarea( $strings['description']['label'] ) )
            ->set_key( "{$key}_description" )
            ->set_name( 'description' )
            ->set_rows( 4 )
            ->set_new_lines( 'wpautop' )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['description']['instructions'] );

        $link_field = ( new Field\Link( $strings['link']['label'] ) )
            ->set_key( "{$key}_link" )
            ->set_name( 'link' )
            ->set_wrapper_width( 40 )
            ->set_instructions( $strings['link']['instructions'] );

        $info_one_tab = ( new Field\Group( $strings['info_column']['label'] ) )
            ->set_key( "{$key}_info_one" )
            ->set_name( 'info_one' );

        $info_one_tab->add_fields(
            $this->get_hero_group_fields( $key, 'info_one', $strings['info_column'] )
        );

        $fields[] = $info_one_tab;

        $info_two_tab = ( new Field\Group( $strings['info_column']['label'] ) )
            ->set_key( "{$key}_info_two" )
            ->set_name( 'info_two' );

        $info_two_tab->add_fields(
            $this->get_hero_group_fields( $key, 'info_two', $strings['info_column'] )
        );

        $info_three_tab = ( new Field\Group( $strings['info_column']['label'] ) )
            ->set_key( "{$key}_info_three" )
            ->set_name( 'info_three' );

        $info_three_tab->add_fields(
            $this->get_hero_group_fields( $key, 'info_three', $strings['info_column'] )
        );

        $info_four_tab = ( new Field\Group( $strings['info_column']['label'] ) )
            ->set_key( "{$key}_info_four" )
            ->set_name( 'info_four' );

        $info_four_tab->add_fields(
            $this->get_hero_group_fields( $key, 'info_four', $strings['info_column'] )
        );

        try {
            $this->add_fields(
                \apply_filters(
                    'tms/acf/layout/hero--savel/fields',
                    [
                        $image_field,
                        $title_field,
                        $title_image_field,
                        $description_field,
                        $link_field,
                        $info_one_tab,
                        $info_two_tab,
                        $info_three_tab,
                        $info_four_tab,
                    ],
                    $key
                )
            );
        }
        catch ( Exception $e ) {
            ( new Logger() )->error( $e->getMessage(), $e->getTrace() );
        }

        return $fields;
    }

    /**
     * Get hero group fields.
     *
     * @param string $key     Layout key.
     * @param string $group   Group name.
     * @param array  $strings Field strings.
     *
     * @return array
     * @throws Exception In case of invalid ACF option.
     */
    public function get_hero_group_fields( string $key, string $group, array $strings ) : array {
        $title_field = ( new Field\Text( $strings['title']['label'] ) )
            ->set_key( "{$key}_{$group}_title" )
            ->set_name( "{$group}_title" )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['title']['instructions'] );

        $text_field = ( new Field\Textarea( $strings['text']['label'] ) )
            ->set_key( "{$key}_{$group}_text" )
            ->set_name( "{$group}_text" )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['text']['instructions'] )
            ->set_new_lines( 'br' );

        $button_field = ( new Field\Link( $strings['button']['label'] ) )
            ->set_key( "{$key}_{$group}_button" )
            ->set_name( "{$group}_button" )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['button']['instructions'] );

        $image_field = ( new Field\Image( $strings['image']['label'] ) )
            ->set_key( "{$key}_{$group}_image" )
            ->set_name( "{$group}_image" )
            ->set_return_format( 'id' )
            ->set_wrapper_width( 50 )
            ->set_instructions( $strings['image']['instructions'] );

        return [
            $title_field,
            $text_field,
            $button_field,
            $image_field,
        ];
    }
}
