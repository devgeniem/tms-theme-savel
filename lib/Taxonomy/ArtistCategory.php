<?php

namespace TMS\Theme\Savel\Taxonomy;

use \TMS\Theme\Base\Interfaces\Taxonomy;
use TMS\Theme\Savel\PostType\Artist;
use TMS\Theme\Base\Traits\Categories;

/**
 * This class defines the taxonomy.
 *
 * @package TMS\Theme\Savel\Taxonomy
 */
class ArtistCategory implements Taxonomy {

    use Categories;

    /**
     * This defines the slug of this taxonomy.
     */
    const SLUG = 'artist-category';

    /**
     * Add hooks and filters from this controller
     *
     * @return void
     */
    public function hooks(): void {
        \add_action( 'init', \Closure::fromCallable( [ $this, 'register' ] ), 15 );
    }

    /**
     * This registers the post type.
     *
     * @return void
     */
    private function register() {
        $labels = [
            'name'                       => 'Kategoriat',
            'singular_name'              => 'Kategoria',
            'menu_name'                  => 'Kategoriat',
            'all_items'                  => 'Kaikki kategoriat',
            'new_item_name'              => 'Lisää uusi kategoria',
            'add_new_item'               => 'Lisää uusi kategoria',
            'edit_item'                  => 'Muokkaa kategoriaa',
            'update_item'                => 'Päivitä kategoria',
            'view_item'                  => 'Näytä kategoria',
            'separate_items_with_commas' => 'Erottele kategoriat pilkulla',
            'add_or_remove_items'        => 'Lisää tai poista kategoria',
            'choose_from_most_used'      => 'Suositut kategoriat',
            'popular_items'              => 'Suositut kategoriat',
            'search_items'               => 'Etsi kategoria',
            'not_found'                  => 'Ei tuloksia',
            'no_terms'                   => 'Ei tuloksia',
            'items_list'                 => 'Kategoriat',
            'items_list_navigation'      => 'Kategoriat',
        ];

        $args = [
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud'     => false,
            'show_in_rest'      => true,
            'capabilities'      => [
                'manage_terms' => 'manage_artist_categories',
                'edit_terms'   => 'edit_artist_categories',
                'delete_terms' => 'delete_artist_categories',
                'assign_terms' => 'assign_artist_categories',
            ],
        ];

        \register_taxonomy( self::SLUG, [ Artist::SLUG ], $args );
    }
}
