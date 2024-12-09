<?php
/**
 * Define the SingleArtist class.
 */

use DustPress\Query;
use TMS\Theme\Base\Images;
use TMS\Theme\Base\Traits;
use TMS\Theme\Savel\Taxonomy\FestivalCategory;

/**
 * The SingleArtist class.
 */
class SingleArtist extends BaseModel {

    use Traits\Sharing;

    /**
     * Content
     *
     * @return array|object|WP_Post|null
     * @throws Exception If global $post is not available or $id param is not defined.
     */
    public function content() {
        $single = Query::get_acf_post();

        return $single;
    }

    /**
     * Prepend additional information rows with artist years.
     *
     * @return array Additional information rows.
     */
    public function additional_information() {
        $additional_information = \get_field( 'additional_information' );

        if ( empty( $additional_information ) ) {
            $additional_information = [];
        }

        $death_year = \get_field( 'death_year' ); // TODO: REMOVE

        if ( ! empty( $death_year ) ) {
            array_unshift( $additional_information, [
                'additional_information_title' => __( 'Death year', 'tms-theme-savel' ),
                'additional_information_text'  => $death_year,
            ] );
        }

        $birth_year = \get_field( 'birth_year' ); // TODO: REMOVE

        if ( ! empty( $birth_year ) ) {
            array_unshift( $additional_information, [
                'additional_information_title' => __( 'Birth year', 'tms-theme-savel' ),
                'additional_information_text'  => $birth_year,
            ] );
        }

        return $additional_information;
    }

    /**
     * Get festivals.
     *
     * @return mixed
     */
    protected function get_festivals() {
        return \get_field( 'festivals' );
    }

    /**
     * Get related festivals
     * TODO: REMOVE
     *
     * @return array|null
     */
    public function festivals() : ?array {
        $festival_items = $this->get_festivals();

        if ( empty( $festival_items ) ) {
            return null;
        }

        return array_map( function ( $item ) {
            $types = \wp_get_post_terms( $item->ID, FestivalCategory::SLUG );

            if ( ! empty( $types ) ) {
                $item->festival_type      = $types[0]->name;
                $item->festival_type_link = \get_category_link( $types[0]->ID );
            }

            $item->image_id = \has_post_thumbnail( $item->ID )
                ? \get_post_thumbnail_id( $item->ID )
                : Images::get_default_image_id();

            $item->permalink = \get_post_permalink( $item->ID );

            if ( ! \has_excerpt( $item->ID ) ) {
                $item->post_excerpt = $this->get_festival_excerpt( $item );
            }

            return $item;
        }, $festival_items );
    }

    /**
     * Get festival excerpt.
     *
     * @param WP_Post $item           Related post item.
     * @param int     $excerpt_length Target excerpt length.
     */
    protected function get_festival_excerpt( WP_Post $item, int $excerpt_length = 25 ) : string {
        $item_excerpt = \get_the_excerpt( $item->ID );

        return strlen( $item_excerpt ) > $excerpt_length
            ? \wp_trim_words( $item_excerpt, $excerpt_length, '...' )
            : $item_excerpt;
    }

    /**
     * Get related art title
     * TODO: REMOVE
     */
    public function related_art() : string {
        return __( 'Related art', 'tms-theme-savel' );
    }
}
