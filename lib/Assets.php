<?php

namespace TMS\Theme\Savel;

/**
 * Class Assets
 *
 * @package TMS\Theme\Savel
 */
class Assets extends \TMS\Theme\Base\Assets implements \TMS\Theme\Base\Interfaces\Controller {

    /**
     * Add hooks and filters from this controller
     *
     * @return void
     */
    public function hooks(): void {
        \add_filter( 'tms/theme/theme_default_color', [ $this, 'theme_name' ] );
        \add_filter( 'tms/theme/theme_selected', [ $this, 'theme_name' ] );

        \add_filter( 'tms/theme/theme_css_path', [ $this, 'theme_asset_path' ], 10, 2 );
        \add_filter( 'tms/theme/theme_js_path', [ $this, 'theme_asset_path' ], 10, 2 );
        \add_filter( 'tms/theme/admin_js_path', [ $this, 'base_theme_asset_path' ], 10, 2 );

        \add_filter( 'tms/theme/asset_mod_time', function ( $mod_time, $filename ) {
            if ( false !== strpos( $filename, 'savel' ) ) {
                $dist_path = \get_stylesheet_directory() . '/assets/dist/' . $filename;

                if ( file_exists( $dist_path ) ) {
                    return filemtime( $dist_path );
                }
            }

            return $mod_time;

        }, 10, 2 );

        // Add icons
        \add_action(
            'wp_footer',
            \Closure::fromCallable( [ $this, 'include_savel_svg_icons' ] )
        );
    }

    /**
     * Get theme name.
     *
     * @return string
     */
    public function theme_name(): string {
        return 'savel';
    }

    /**
     * Get theme asset path.
     *
     * @param string $full_path Asset path.
     * @param string $file      File name.
     *
     * @return string
     */
    public function theme_asset_path( $full_path, $file ): string { // phpcs:ignore
        return \get_stylesheet_directory_uri() . '/assets/dist/' . $file;
    }

    /**
     * Get base theme asset path.
     *
     * @param string $full_path Asset path.
     * @param string $file      File name.
     *
     * @return string
     */
    public function base_theme_asset_path( $full_path, $file ): string { // phpcs:ignore
        return \get_template_directory_uri() . '/assets/dist/' . $file;
    }

    /**
     * Add SVG definitions to footer.
     */
    private function include_savel_svg_icons(): void {
        $svg_icons_path = \get_stylesheet_directory() . '/assets/dist/icons-savel.svg';

        if ( is_file( $svg_icons_path ) ) {
            include_once $svg_icons_path;
        }
    }
}
