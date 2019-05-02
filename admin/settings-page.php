<?php
/**
 * Popup cards settings page
 *
 * v 1.0
 *
 */

require_once ( plugin_dir_path( __DIR__ ) . '/classes/class-cj-database.php' );

/**
* Plugin settings page registration
*
*/
add_action( 'admin_menu', 'cj_create_settings_menu' );
function cj_create_settings_menu()
{
    add_options_page( 'Popup Cards', 'Popup Cards', 'manage_options', 'cj_setup', 'cj_setup_page' );
    add_action( 'admin_init', 'cj_register_settings' );
};


/*
* Callbacks
*
*/
function cj_register_settings()
{
    register_setting( 'cj_options', 'cj_options', 'cj_sanitize_options' );
};

function cj_setup_page()
{?>

<div>
    <h2><?php esc_html_e( 'Popup Cards settings', 'cj' ); ?></h2>
    <form method="post" action="options.php">
    <?php
    settings_fields('cj_options');
    $options = get_option('cj_options');

    // set default values
    $title      = isset( $options['title'] ) ? $options['title'] : 'Choose your card';
    $delay       = isset( $options['delay'] ) ? $options['delay'] : 3;
    $text_win   = isset( $options['text_win'] ) ? $options['text_win'] : 'You are lucky!';
    $text_lose  = isset( $options['text_lose'] ) ? $options['text_lose'] : 'Try again later!';

    $color_bg   = isset( $options['color_bg'] ) ? $options['color_bg'] : '111';
    $color_text = isset( $options['color_text'] ) ? $options['color_text'] : 'F2F2F2';
    
    $not_show = isset( $options['not_show'] ) ?  $options['not_show'] : '';
    ?>
        <div class="cj_settings">
              <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Title', 'cj' ); ?></th>
                        <td>
                            <input type = "text"
                                   size = "50"
                                   name="cj_options[title]"
                                   value = "<?php echo esc_attr($title); ?>"
                                   placeholder = "<?php echo esc_attr($title); ?>"
                            />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Delay before displaying, sec', 'cj' ); ?></th>
                        <td>
                            <input type = "text"
                                   size = "50"
                                   name="cj_options[delay]"
                                   value = "<?php echo esc_attr($delay); ?>"
                                   placeholder = "<?php echo esc_attr($delay); ?>"
                            />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Text for winner', 'cj' ); ?></th>
                        <td>
                          <input type = "text"
                                 size = "50"
                                 name="cj_options[text_win]"
                                 value = "<?php echo esc_attr($text_win); ?>"
                                 placeholder = "<?php echo esc_attr($text_win); ?>"
                          />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Text for loser', 'cj' ); ?></th>
                        <td>
                          <input type = "text"
                                 size = "50"
                                 name="cj_options[text_lose]"
                                 value = "<?php echo esc_attr($text_lose); ?>"
                                 placeholder = "<?php echo esc_attr($text_lose); ?>"
                          />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Background color', 'cj' ); ?></th>
                        <td>
                          <input type="text"
                                name="cj_options[color_bg]"
                                value="<?php echo esc_attr($color_bg); ?>"
                                class="my-color-field"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Text color', 'cj' ); ?></th>
                        <td>
                          <input type="text"
                                  name="cj_options[color_text]"
                                  value="<?php echo esc_attr($color_text); ?>"
                                  class="my-color-field"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Don\'t display popup window?', 'cj' ); ?></th>
                        <td>
                          <p><input
                            name="cj_options[not_show]"
                            type="checkbox"
                            <?php echo checked( $not_show, 'on', false ); ?>
                            > Yes</p>
                        </td>
                    </tr>
                </table>
            </div>
        <?php submit_button(); ?>
    </form>
</div>
<?php
echo CJ_Database::get_submitted_users_table();
};

function cj_sanitize_options( $input )
{
    foreach( $input as $name => & $val ){
        $val = strip_tags( $val );
    };
   return $input;
};
