<?php
/**
 * Define the SingleFestival class.
 */

use DustPress\Query;
use TMS\Theme\Base\Formatters\ImageFormatter;
use TMS\Theme\Base\Traits;
use TMS\Theme\Savel\PostType\Artist;
use TMS\Theme\Savel\Taxonomy\FestivalCategory;

/**
 * The SingleFestival class.
 */
class SingleFestival extends SingleArtist {

    use Traits\Sharing;

    /**
     * Content
     *
     * @return array|object|WP_Post|null
     * @throws Exception If global $post is not available or $id param is not defined.
     */
    public function content() {
        $single       = Query::get_acf_post();
        $single->meta = \get_post_meta( get_the_ID() );

        if ( ! empty( $single->image ) ) {
            $single = ImageFormatter::get_image_artist( (array) $single, (array) $single->image );
        }

        return $single;
    }

    /**
     * Get additional info.
     *
     * @return array|mixed
     */
    public function additional_info() {
        $info_rows = ! empty( \get_field( 'additional_information' ) ) ? get_field( 'additional_information' ) : [];

        $artist_location_group = $this->get_info_group_location();

        if ( ! empty( $artist_location_group ) ) {
            array_unshift(
                $info_rows,
                $artist_location_group
            );
        }

        $artist_name_group = $this->get_info_group_artist_name();

        if ( ! empty( $artist_name_group ) ) {
            array_unshift(
                $info_rows,
                $artist_name_group
            );
        }

        $artwork_year_group = $this->get_info_group_artwork_year();

        if ( ! empty( $artwork_year_group ) ) {
            array_unshift(
                $info_rows,
                $artwork_year_group
            );
        }

        return $info_rows;
    }

    /**
     * Get related artwork.
     *
     * @return array|null
     */
    public function artwork() : ?array {
        $artwork    = parent::artwork();
        $current_id = get_the_ID();

        if ( empty( $artwork ) ) {
            return null;
        }

        return array_filter( $artwork, function ( $item ) use ( $current_id ) {
            return $item->ID !== $current_id;
        } );
    }

    /**
     * Get info group artwork location.
     *
     * @return array[]|null
     */
    protected function get_info_group_location() : ?array {
        $group          = null;
        $location_terms = wp_get_post_terms( get_the_ID(), ArtworkLocation::SLUG, [ 'fields' => 'names' ] );

        if ( ! empty( $location_terms ) && ! is_wp_error( $location_terms ) ) {
            $group = $this->format_info_group(
                _x( 'Location', 'theme-frontend', 'tms-theme-savel' ),
                implode( ', ', $location_terms )
            );
        }

        return $group;
    }

    /**
     * Get info group artist name.
     *
     * @return array[]|null
     */
    protected function get_info_group_artist_name() : ?array {
        $group      = null;
        $artist_ids = array_keys( $this->get_artist_map() );

        if ( empty( $artist_ids ) ) {
            return null;
        }

        foreach ( $artist_ids as $artist_id ) {
            $first_name = get_field( 'first_name', $artist_id );
            $last_name  = get_field( 'last_name', $artist_id );

            if ( ! empty( $first_name ) || ! empty( $last_name ) ) {
                $artist_names[] = trim( $first_name . ' ' . $last_name );
            }
        }

        if ( ! empty( $artist_names ) ) {
            $group_title = count( $artist_names ) > 1
                ? _x( 'Artists', 'theme-frontend', 'tms-theme-savel' )
                : _x( 'Artist', 'theme-frontend', 'tms-theme-savel' );

            $group = $this->format_info_group( $group_title, implode( ', ', $artist_names ) );
        }

        return $group;
    }

    /**
     * Get info group artwork year
     *
     * @return array[]|string[]|null
     */
    public function get_info_group_artwork_year() {
        $year = get_field( 'year' );

        if ( ! empty( $year ) ) {
            return $this->format_info_group(
                __( 'Year of manufacture', 'tms-theme-savel' ),
                $year
            );
        }

        return null;
    }

    /**
     * Format data for use as additional information row.
     *
     * @param string $row_title Info group title.
     * @param string $row_text  Info group text content.
     *
     * @return array[]
     */
    protected function format_info_group( string $row_title, string $row_text ) : array {
        return [
            'additional_information_title' => $row_title,
            'additional_information_text'  => $row_text,
        ];
    }

    /**
     * Return image gallery data.
     *
     * @return array
     */
    public function image_gallery() : array {
        $gallery_field = ! empty( get_field( 'images' ) ) ? get_field( 'images' ) : [];

        if ( has_post_thumbnail() ) {
            array_unshift( $gallery_field, $this->get_featured_media_gallery_item() );
        }

        $data['rows'] = array_map( static function ( $item ) {
            $item['meta'] = ImageFormatter::format( [
                'is_clickable' => true,
                'id'           => $item['ID'],
                'image'        => $item,
            ] );

            $item['id'] = wp_unique_id( 'image-gallery-item-' );

            return $item;
        }, $gallery_field );

        $data['gallery_id']   = wp_unique_id( 'image-gallery-' );
        $data['translations'] = ( new \Strings() )->s()['gallery'] ?? [];

        return $data;
    }

    /**
     * Get featured media formatted for use as a gallery item.
     *
     * @return array|WP_Post|null
     */
    protected function get_featured_media_gallery_item() {
        $featured_media_id = get_post_thumbnail_id();

        if ( function_exists( 'acf_get_attachment' ) ) {
            return acf_get_attachment( $featured_media_id );
        }

        $img_src           = wp_get_attachment_image_src( $featured_media_id, 'fullhd' );
        $img_post          = get_post( $featured_media_id, ARRAY_A );
        $img_post['sizes'] = [
            'fullhd'        => $img_src[0],
            'fullhd-width'  => $img_src[1],
            'fullhd-height' => $img_src[2],
        ];

        return $img_post;
    }

    /**
     * Returns artist link.
     */
    public function artist_links() {
        $artists = array_keys( $this->get_artist_map() );

        if ( empty( $artists ) ) {
            return false;
        }

        $has_multiple = count( $artists ) > 1;
        $link_classes = count( $artists ) > 1
            ? 'single-artwork__artist-link'
            : 'single-artwork__artist-button button is-primary button--icon';

        return array_map( function ( $artist ) use ( $has_multiple, $link_classes ) {
            $view_artists_text = __( 'View artist', 'tms-theme-savel' );

            if ( $has_multiple ) {
                $view_artists_text .= ' ' . get_the_title( $artist );
            }

            return [
                'classes' => $link_classes,
                'link'    => get_permalink( $artist ),
                'text'    => $view_artists_text,
            ];
        }, $artists );
    }

    /**
     * Get artwork artist ID.
     *
     * @return array
     */
    protected function get_artwork() : array {
        $map     = $this->get_artist_map();
        $artwork = [];

        foreach ( $map as $map_artworks ) {
            foreach ( $map_artworks as $map_artwork ) {
                if ( ! in_array( $map_artwork, $artwork ) ) { // phpcs:ignore
                    $artwork[] = $map_artwork;
                }
            }
        }

        return $artwork;
    }

    /**
     * Get artworks artists map
     *
     * @return array
     */
    protected function get_artist_map() : array {
        $artists = Artist::get_all();

        if ( empty( $artists ) ) {
            return [];
        }

        $map        = [];
        $current_id = get_the_ID();

        foreach ( $artists as $artist ) {
            $artworks = get_field( 'artwork', $artist->ID );

            if ( empty( $artworks ) ) {
                continue;
            }

            $artwork_ids = array_map( function ( $artwork_item ) {
                return $artwork_item->ID;
            }, $artworks );

            if ( in_array( $current_id, $artwork_ids, true ) ) {
                foreach ( $artworks as $artwork ) {
                    $map[ $artist->ID ][] = $artwork;
                }
            }
        }

        return $map;
    }
}
