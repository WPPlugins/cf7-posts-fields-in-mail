<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
class VTD_Cf_Posts_Fields_Settings {
  
  private $tabs = array();
  
  private $options;
  
  /**
   * Start up
   */
  public function __construct() {
    // Admin menu
    add_action( 'admin_menu', array( $this, 'add_settings_page' ), 100 );
    add_action( 'admin_init', array( $this, 'settings_page_init' ) );
    
    // Settings tabs
    add_action('settings_page_vtd_cf_posts_fields_general_tab_init', array(&$this, 'general_tab_init'), 10, 1);
  }
  
  /**
   * Add options page
   */
  public function add_settings_page() {
    global $VTD_Cf_Posts_Fields;
    
    add_menu_page(
        __('Cf7 Posts Fields Settings', $VTD_Cf_Posts_Fields->text_domain), 
        __('Cf7 Posts Fields Settings', $VTD_Cf_Posts_Fields->text_domain), 
        'manage_options', 
        'vtd-cf-posts-fields-setting-admin', 
        array( $this, 'create_vtd_cf_posts_fields_settings' ),
        $VTD_Cf_Posts_Fields->plugin_url . 'assets/images/vtdesigns.png'
    );
    
    $this->tabs = $this->get_vtd_settings_tabs();
  }
  
  function get_vtd_settings_tabs() {
    global $VTD_Cf_Posts_Fields;
    $tabs = apply_filters('vtd_cf_posts_fields_tabs', array(
      'vtd_cf_posts_fields_general' => __('Cf7 Posts Fields General', $VTD_Cf_Posts_Fields->text_domain)
    ));
    return $tabs;
  }
  
  function vtd_settings_tabs( $current = 'vtd_cf_posts_fields_general' ) {
    if ( isset ( $_GET['tab'] ) ) :
      $current = $_GET['tab'];
    else:
      $current = 'vtd_cf_posts_fields_general';
    endif;
    
    $links = array();
    foreach( $this->tabs as $tab => $name ) :
      if ( $tab == $current ) :
        $links[] = "<a class='nav-tab nav-tab-active' href='?page=vtd-cf-posts-fields-setting-admin&tab=$tab'>$name</a>";
      else :
        $links[] = "<a class='nav-tab' href='?page=vtd-cf-posts-fields-setting-admin&tab=$tab'>$name</a>";
      endif;
    endforeach;
    echo '<div class="icon32" id="vtdesigns_menu_ico"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $links as $link )
      echo $link;
    echo '</h2>';
    
    foreach( $this->tabs as $tab => $name ) :
      if ( $tab == $current ) :
        echo "<h2>$name Settings</h2>";
      endif;
    endforeach;
  }

  /**
   * Options page callback
   */
  public function create_vtd_cf_posts_fields_settings() {
    global $VTD_Cf_Posts_Fields;
    ?>
    <div class="wrap">
      <?php $this->vtd_settings_tabs(); ?>
      <?php
      $tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'vtd_cf_posts_fields_general' );
      $this->options = get_option( "vtd_{$tab}_settings_name" );
      //print_r($this->options);
      
      // This prints out all hidden setting errors
      settings_errors("vtd_{$tab}_settings_name");
      ?>
      <form method="post" action="options.php">
      <?php
        // This prints out all hidden setting fields
        settings_fields( "vtd_{$tab}_settings_group" );   
        do_settings_sections( "vtd-{$tab}-settings-admin" );
        submit_button(); 
      ?>
      </form>
    </div>
    <?php
    do_action('vtd_cf_posts_fields_vtdesigns_admin_footer');
  }

  /**
   * Register and add settings
   */
  public function settings_page_init() { 
    do_action('befor_settings_page_init');
    
    // Register each tab settings
    foreach( $this->tabs as $tab => $name ) :
      do_action("settings_page_{$tab}_tab_init", $tab);
    endforeach;
    
    do_action('after_settings_page_init');
  }
  
  /**
   * Register and add settings fields
   */
  public function settings_field_init($tab_options) {
    global $VTD_Cf_Posts_Fields;
    
    if(!empty($tab_options) && isset($tab_options['tab']) && isset($tab_options['ref']) && isset($tab_options['sections'])) {
      // Register tab options
      register_setting(
        "vtd_{$tab_options['tab']}_settings_group", // Option group
        "vtd_{$tab_options['tab']}_settings_name", // Option name
        array( $tab_options['ref'], "vtd_{$tab_options['tab']}_settings_sanitize" ) // Sanitize
      );
      
      foreach($tab_options['sections'] as $sectionID => $section) {
        // Register section
        add_settings_section(
          $sectionID, // ID
          $section['title'], // Title
          array( $tab_options['ref'], "{$sectionID}_info" ), // Callback
          "vtd-{$tab_options['tab']}-settings-admin" // Page
        );
        
        // Register fields
        if(isset($section['fields'])) {
          foreach($section['fields'] as $fieldID => $field) {
            if(isset($field['type'])) {
              $field = $VTD_Cf_Posts_Fields->vtd_wp_fields->check_field_id_name($fieldID, $field);
              $field['tab'] = $tab_options['tab'];
              $callbak = $this->get_field_callback_type($field['type']);
              if(!empty($callbak)) {
                add_settings_field(
                  $fieldID,
                  $field['title'],
                  array( $this, $callbak ),
                  "vtd-{$tab_options['tab']}-settings-admin",
                  $sectionID,
                  $field
                );
              }
            }
          }
        }
      }
    }
  }
  
  function general_tab_init($tab) {
    global $VTD_Cf_Posts_Fields;
    $VTD_Cf_Posts_Fields->admin->load_class("settings-{$tab}", $VTD_Cf_Posts_Fields->plugin_path, $VTD_Cf_Posts_Fields->token);
    new VTD_Cf_Posts_Fields_Settings_Gneral($tab);
  }
  
  function get_field_callback_type($fieldType) {
    $callBack = '';
    switch($fieldType) {
      case 'input':
      case 'text':
      case 'email':
      case 'number':
      case 'file':
      case 'url':
        $callBack = 'text_field_callback';
        break;
        
      case 'hidden':
        $callBack = 'hidden_field_callback';
        break;
        
      case 'textarea':
        $callBack = 'textarea_field_callback';
        break;
        
      case 'wpeditor':
        $callBack = 'wpeditor_field_callback';
        break;
        
      case 'checkbox':
        $callBack = 'checkbox_field_callback';
        break;
        
      case 'radio':
        $callBack = 'radio_field_callback';
        break;
        
      case 'select':
        $callBack = 'select_field_callback';
        break;
        
      case 'upload':
        $callBack = 'upload_field_callback';
        break;
        
      case 'colorpicker':
        $callBack = 'colorpicker_field_callback';
        break;
        
      case 'datepicker':
        $callBack = 'datepicker_field_callback';
        break;
        
      case 'multiinput':
        $callBack = 'multiinput_callback';
        break;
        
      default:
        $callBack = '';
        break;
    }
    
    return $callBack;
  }
  
  /** 
   * Get the hidden field display
   */
  public function hidden_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->hidden_input($field);
  }
  
  /** 
   * Get the text field display
   */
  public function text_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->text_input($field);
  }
  
  /** 
   * Get the text area display
   */
  public function textarea_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_textarea( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_textarea( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->textarea_input($field);
  }
  
  /** 
   * Get the wpeditor display
   */
  public function wpeditor_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? ( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? ( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->wpeditor_input($field);
  }
  
  /** 
   * Get the checkbox field display
   */
  public function checkbox_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['dfvalue'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : '';
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->checkbox_input($field);
  }
  
  /** 
   * Get the checkbox field display
   */
  public function radio_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->radio_input($field);
  }
  
  /** 
   * Get the select field display
   */
  public function select_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_textarea( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_textarea( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->select_input($field);
  }
  
  /** 
   * Get the upload field display
   */
  public function upload_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->upload_input($field);
  }
  
  /** 
   * Get the multiinput field display
   */
  public function multiinput_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? $field['value'] : array();
    $field['value'] = isset( $this->options[$field['name']] ) ? $this->options[$field['name']] : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->multi_input($field);
  }
  
  /** 
   * Get the colorpicker field display
   */
  public function colorpicker_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->colorpicker_input($field);
  }
  
  /** 
   * Get the datepicker field display
   */
  public function datepicker_field_callback($field) {
    global $VTD_Cf_Posts_Fields;
    $field['value'] = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
    $field['value'] = isset( $this->options[$field['name']] ) ? esc_attr( $this->options[$field['name']] ) : $field['value'];
    $field['name'] = "vtd_{$field['tab']}_settings_name[{$field['name']}]";
    $VTD_Cf_Posts_Fields->vtd_wp_fields->datepicker_input($field);
  }
  
}