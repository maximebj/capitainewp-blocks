<?php
/**
 * Plugin Name: Capitaine WP - Blocs
 * Plugin URI: https://github.com/maximebj/capitainewp-gut-bases
 * Description: Mes blocs pour la rédaction des cours et tutoriels
 * Author: maximebj
 * Author URI: https://capitainewp.io
 * Version: 1.0.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }


class CapitaineWPBlocks {

	public function register_hooks() {
    add_action( 'init', [ $this, 'register_render'] );
    add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_assets' ] );
    add_action( 'enqueue_block_editor_assets', [ $this, 'register_editor_assets' ] );
    add_action( 'enqueue_block_assets', [ $this, 'register_public_assets' ] );
  }

  public function register_editor_assets() {

    $js = 'dist/blocks.build.js';

  	wp_enqueue_script(
  		'capitainewp-blocs',
  		plugins_url( $js, __FILE__ ),
  	  [ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element' ],
      filemtime( plugin_dir_path( __FILE__ ) . $js )
  	);

    $css = 'dist/blocks.editor.build.css';

  	wp_enqueue_style(
  		'capitainewp-blocs-editor',
  		plugins_url( $css , __FILE__ ),
  		[ 'wp-edit-blocks' ],
      filemtime( plugin_dir_path( __FILE__ ) . $css )
  	);
  }

  public function register_admin_assets() {

    $css = 'dist/editor.style.build.css';

  	wp_enqueue_style(
  		'capitainewp-admin',
  		plugins_url( $css , __FILE__ ),
  		[ 'wp-edit-post' ],
      filemtime( plugin_dir_path( __FILE__ ) . $css )
  	);
  }

  public function register_public_assets() {

    $css = 'dist/blocks.style.build.css';

    wp_enqueue_style(
      'capitainwp-blocks',
      plugins_url( $css , __FILE__ ),
      array('wp-blocks'), // TODO
      filemtime( plugin_dir_path( __FILE__ ) . $css )
    );
  }

  public function register_render() {

    register_block_type(
      'captainewp/definition',
      [ 'render_callback' => [ $this, 'render_definition_block' ] ]
    );
  }

  public function render_definition_block( $attributes ) {
    global $context;

    $id = $attributes['definitionID'];

    $context['definition'] = \Timber::get_post($id);

    return \Timber::compile('blocks/definition.twig', $context);
  }
}

$CapitaineWPBlocks = new CapitaineWPBlocks();
$CapitaineWPBlocks->register_hooks();
