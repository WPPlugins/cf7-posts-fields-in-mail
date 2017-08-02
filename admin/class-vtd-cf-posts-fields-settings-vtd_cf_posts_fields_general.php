<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
class VTD_Cf_Posts_Fields_Settings_Gneral {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;
  
  private $tab;

  /**
   * Start up
   */
  public function __construct($tab) {
    $this->tab = $tab;
    $this->options = get_option( "vtd_{$this->tab}_settings_name" );
    $this->settings_page_init();
  }
  
  /**
   * Register and add settings
   */
  public function settings_page_init() {
    global $VTD_Cf_Posts_Fields;
    
    $settings_tab_options = array("tab" => "{$this->tab}",
                                  "ref" => &$this,
                                  "sections" => array(
                                                      "default_settings_section" => array("title" =>  __('Default Settings', $VTD_Cf_Posts_Fields->text_domain), // Section one
                                                                                         "fields" => array(
                                                                                            "is_enable" => array('title' => __('Enable', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'is_enable', 'label_for' => 'is_enable', 'name' => 'is_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "is_post_enable" => array('title' => __('Enable Post Contact', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'is_post_enable', 'label_for' => 'is_post_enable', 'name' => 'is_post_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "is_page_enable" => array('title' => __('Enable Page Contact', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'is_page_enable', 'label_for' => 'is_page_enable', 'name' => 'is_page_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "is_product_enable" => array('title' => __('Enable Product Contact', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'is_product_enable', 'label_for' => 'is_product_enable', 'name' => 'is_product_enable', 'value' => 'Enable'), // Checkbox
                                                                                            
                                                                                                                                                                  
                                                                                                           )
                                                                                         ),
                                                      "fields_settings_section" => array("title" =>  __('Fields Included In Mail ', $VTD_Cf_Posts_Fields->text_domain), // Section one
                                                                                         "fields" => array(
                                                                                            "title_enable" => array('title' => __('Page, Post, Product Title', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'title_enable', 'label_for' => 'title_enable', 'name' => 'title_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "url_enable" => array('title' => __(' Page, Post, Product Url', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'url_enable', 'label_for' => 'url_enable', 'name' => 'url_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "author_enable" => array('title' => __('Page, Post, Product Author', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'author_enable', 'label_for' => 'author_enable', 'name' => 'author_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "post_id_enable" => array('title' => __('Page, Post, Product Id', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'checkbox', 'id' => 'post_id_enable', 'label_for' => 'post_id_enable', 'name' => 'post_id_enable', 'value' => 'Enable'), // Checkbox
                                                                                            "custom_post_meta" => array('title' => __('Page, Post, Product Meta fields (,) seperated', $VTD_Cf_Posts_Fields->text_domain), 'type' => 'wpeditor', 'id' => 'custom_post_meta', 'label_for' => 'custom_post_meta', 'name' => 'custom_post_meta','desc'=>__("example post_meta_key1:Post Meta label1, post_meta_key2:Post Meta Label2")), // wpeditor
                                                                                            
                                                                                                                                                                  
                                                                                                           )
                                                                                         )
                                                      
                                                      )
                                  );
    
    $VTD_Cf_Posts_Fields->admin->settings->settings_field_init(apply_filters("settings_{$this->tab}_tab_options", $settings_tab_options));
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function vtd_vtd_cf_posts_fields_general_settings_sanitize( $input ) {
    global $VTD_Cf_Posts_Fields;
    $new_input = array();
    
    $hasError = false;
    
     if( isset( $input['is_enable'] ) )
      $new_input['is_enable'] = sanitize_text_field( $input['is_enable'] );
    if( isset( $input['is_page_enable'] ) )
      $new_input['is_page_enable'] = sanitize_text_field( $input['is_page_enable'] );
    if( isset( $input['is_post_enable'] ) )
      $new_input['is_post_enable'] = sanitize_text_field( $input['is_post_enable'] );
    if( isset( $input['is_product_enable'] ) )
      $new_input['is_product_enable'] = sanitize_text_field( $input['is_product_enable'] );

    if( isset( $input['title_enable'] ) )
      $new_input['title_enable'] = sanitize_text_field( $input['title_enable'] );
    if( isset( $input['url_enable'] ) )
      $new_input['url_enable'] = sanitize_text_field( $input['url_enable'] );
    if( isset( $input['author_enable'] ) )
      $new_input['author_enable'] = sanitize_text_field( $input['author_enable'] );
    if( isset( $input['post_id_enable'] ) )
      $new_input['post_id_enable'] = sanitize_text_field( $input['post_id_enable'] );
    if( isset( $input['custom_post_meta'] ) )
      $new_input['custom_post_meta'] = sanitize_text_field( $input['custom_post_meta'] );
    
    if(!$hasError) {
      add_settings_error(
        "vtd_{$this->tab}_settings_name",
        esc_attr( "vtd_{$this->tab}_settings_admin_updated" ),
        __('General settings updated', $VTD_Cf_Posts_Fields->text_domain),
        'updated'
      );
    }

    return $new_input;
  }

  /** 
   * Print the Section text
   */
  public function default_settings_section_info() {
    global $VTD_Cf_Posts_Fields;
    _e('Enter your default settings below', $VTD_Cf_Posts_Fields->text_domain);
  }

  /** 
   * Print the Section text
   */
  public function fields_settings_section_info() {
    global $VTD_Cf_Posts_Fields;
    _e('configure your fields settings below', $VTD_Cf_Posts_Fields->text_domain);
  }
  
  
  
}