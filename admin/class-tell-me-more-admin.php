<?php

namespace OllieJones;
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/OllieJones
 * @since      1.0.0
 *
 * @package    Tell_Me_More
 * @subpackage Tell_Me_More/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tell_Me_More
 * @subpackage Tell_Me_More/admin
 * @author     Oliver Jones <olliejones@gmail.com>
 */
class Tell_Me_More_Admin {

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
   * @param string $plugin_name The name of this plugin.
   * @param string $version The version of this plugin.
   * @since    1.0.0
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version     = $version;
  }

  public function admin_menu() {

    $option = get_option( TELL_ME_MORE_OPTIONS );

    /* make sure default option is in place, to avoid double sanitize call */
    if ( ! $option || ! is_array( $option ) ) {
      update_option( TELL_ME_MORE_OPTIONS,
        [ 'OPENAI_API_KEY' => '' ] );
    }
    register_setting(
      TELL_ME_MORE_SLUG,
      TELL_ME_MORE_OPTIONS,
      [ 'sanitize_callback' => [ $this, 'sanitize_settings' ] ] );

    add_options_page(
      __( 'Tell Me More -- OpenAI - furnished extra content', 'tell-me-more' ),
      __( 'Tell Me More', 'tell_me_more' ),
      'manage_options',
      TELL_ME_MORE_SLUG,
      function () {
        if ( current_user_can( 'manage_options' ) ) {
          include_once plugin_dir_path( __FILE__ ) . 'partials/tell-me-more-admin-display.php';
        }
      } );

    add_settings_section(
      TELL_ME_MORE_SLUG . '_opts',
      __( 'Configuration', 'tell-me-more' ),
      function () {
        /* empty, intentionally */
      },
      TELL_ME_MORE_SLUG
    );

    add_settings_field(
      'OPENAI_API_KEY',
      __( 'OpenAI API Key', 'tell-me-more' ),
      [ $this, 'api_key' ],
      TELL_ME_MORE_SLUG,
      TELL_ME_MORE_SLUG . '_opts' );
  }

  public function api_key( $args ) {
    $options    = get_option( TELL_ME_MORE_OPTIONS );
    $optionName = 'OPENAI_API_KEY';
    $key        = $options[ $optionName ];
    $hyperlink = '<a href="https://openai.com/api/" target="_blank">OpenAI.com</a>';
    $createPrompt = sprintf (
            /* translators:  1: hyperlink (<a> tag) pointing to OpenAI.com */
            __('Create an account on %1$s and get your API key. Put it here.', 'tell-me-more' ),
            $hyperlink
    );
    ?>
      <input type="text"
             id="<?php echo $optionName ?>"
             name="<?php echo TELL_ME_MORE_OPTIONS ?>[OPENAI_API_KEY]"
             placeholder="<?php esc_attr_e( 'API Key', 'tell-me-more' ) ?>"
             size="50"
             value="<?php echo esc_attr( $key ); ?>"
      />
      <p class="description">
        <?php echo $createPrompt; ?>
      </p>

    <?php
  }

  function sanitize_settings( $input ) {
    return $input;
  }

  /**
   * Register the stylesheets for the admin area.
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

    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tell-me-more-admin.css', [], $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the admin area.
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
    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tell-me-more-admin.js', [ 'jquery' ], $this->version, false );
  }

}
