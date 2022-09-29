<?php

namespace OllieJones;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/OllieJones
 * @since      1.0.0
 *
 * @package    Tell_Me_More
 * @subpackage Tell_Me_More/public
 */

use Orhanerday\OpenAi\OpenAi;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tell_Me_More
 * @subpackage Tell_Me_More/public
 * @author     Oliver Jones <olliejones@gmail.com>
 */
class Tell_Me_More_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $plugin_name The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $version The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @param string $plugin_name The name of the plugin.
   * @param string $version The version of this plugin.
   * @since    1.0.0
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version     = $version;

    $this->initialize();
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Tell_Me_More_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Tell_Me_More_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tell-me-more-public.css', [], $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Tell_Me_More_Loader as all the hooks are defined
     * in that particular class.
     *
     * The Tell_Me_More_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tell-me-more-public.js', [ 'jquery' ], $this->version, false );
  }

  private function initialize() {
    add_shortcode( 'tell-me-more', [ $this, 'shortcode' ] );
  }

  public function shortcode( $atts, $content, $shortcode_tag ) {

    $options         = get_option( TELL_ME_MORE_OPTIONS );
    $words_in_prompt = intval( array_key_exists( 'words_in_prompt', $options ) ? $options['words_in_prompt'] : 10 );
    $max_tokens      = intval( array_key_exists( 'max_tokens', $options ) ? $options['max_tokens'] : 150 );

    if ( ! $content || strlen( $content ) === 0 ) {
      $content = wp_strip_all_tags( get_the_content() );
    }
    $content = implode( ' ', array_slice( explode( ' ', $content ), 0, $words_in_prompt ) );

    $open_ai = new OpenAi( $options['OPENAI_API_KEY'] );

    $completion = json_decode( $open_ai->complete( [
      'engine'            => 'davinci',
      'prompt'            => $content,
      'temperature'       => 0.9,
      'max_tokens'        => $max_tokens,
      'frequency_penalty' => 0,
      'presence_penalty'  => 0.6,
    ] ) );

    $text = $completion->choices[0]->text;

    $o = "<h2>Background</h2><p>$content $text...</p>";
    return $o;
  }

}
