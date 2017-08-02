<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class VTD_Cf_Posts_Fields_Frontend {

	public function __construct() {		
		add_filter( 'wpcf7_mail_components', array($this,'add_post_data_in_cfmail'),10,2);
	}


	function add_post_data_in_cfmail($components, $form){
		global $VTD_Cf_Posts_Fields;
		$message = '';
		$settings = get_option('vtd_vtd_cf_posts_fields_general_settings_name');
		if(isset($settings['is_enable'])){
			$submission = WPCF7_Submission::get_instance();
			if($submission){
				$unit_tag = $submission->get_meta( 'unit_tag' );
				if ( $unit_tag	&& preg_match( '/^wpcf7-f(\d+)-p(\d+)-o(\d+)$/', $unit_tag, $matches ) ) {
					$post_id = absint( $matches[2] );	
					$post = get_post($post_id);

					if($post->post_type == 'post' && isset($settings['is_post_enable'])){
						if(isset($settings['title_enable']) || isset($settings['url_enable']) || isset($settings['author_enable']) || isset($settings['post_id_enable']) || (isset($settings['custom_post_meta']) && !empty($settings['custom_post_meta']))){

							$message = "<div style='width:100%;'>";
							if(isset($settings['title_enable'])) {
								$message .= __("Post Title : ",$VTD_Cf_Posts_Fields->text_domain).$post->post_title."<br/>";
							}
							if(isset($settings['url_enable'])) {
								$message .= __("Post Url : ",$VTD_Cf_Posts_Fields->text_domain).get_permalink($post->ID)."<br/>";
							}
							if(isset($settings['author_enable'])) {
								$message .= __("Post Author : ",$VTD_Cf_Posts_Fields->text_domain).get_the_author_meta('login',$post->post_author)."<br/>";
							}
							if(isset($settings['post_id_enable'])) {
								$message .= __("Post ID : ",$VTD_Cf_Posts_Fields->text_domain).$post->ID."<br/>";
							}

							if(isset($settings['custom_post_meta']) && !empty($settings['custom_post_meta'])) {
								$metamsg = '';
								$post_metas_arr = explode(',',$settings['custom_post_meta']);
								if(is_array($post_metas_arr) && !empty($post_metas_arr)) {
									foreach($post_metas_arr as $post_meta){
										$post_meta_arr = explode(':',$post_meta);
										if(is_array($post_meta_arr) && !empty($post_meta_arr)){
											$metavalue  = get_post_meta($post->ID, $post_meta_arr[0], true);
											if(isset($post_meta_arr[1]) && !empty($post_meta_arr[1])) {
												$metamsg .= $post_meta_arr[1].' : '.$metavalue.'   ,';   
											}
											else {
												$metamsg .= $post_meta_arr[0].' : '.$metavalue.'   ,';
											}
										}
									}
								}

								$message .= __("Post Meta : ",$VTD_Cf_Posts_Fields->text_domain).$metamsg."<br/>";
							}
							
							$message .= "</div><br/>";
						}

					}
					elseif($post->post_type == 'page' && isset($settings['is_page_enable'])){
						if(isset($settings['title_enable']) || isset($settings['url_enable']) || isset($settings['author_enable']) || isset($settings['post_id_enable']) || (isset($settings['custom_post_meta']) && !empty($settings['custom_post_meta']))){
							
							$message = "<div style='width:100%;'>";
							if(isset($settings['title_enable'])) {
								$message .= __("Page Title : ",$VTD_Cf_Posts_Fields->text_domain).$post->post_title."<br/>";
							}
							if(isset($settings['url_enable'])) {
								$message .= __("Page Url : ",$VTD_Cf_Posts_Fields->text_domain).get_permalink($post->ID)."<br/>";
							}
							if(isset($settings['author_enable'])) {
								$message .= __("Page Author : ",$VTD_Cf_Posts_Fields->text_domain).get_the_author_meta('login',$post->post_author)."<br/>";
							}
							if(isset($settings['post_id_enable'])) {
								$message .= __("Page ID : ",$VTD_Cf_Posts_Fields->text_domain).$post->ID."<br/>";
							}

							if(isset($settings['custom_post_meta']) && !empty($settings['custom_post_meta'])) {
								$metamsg = '';
								$post_metas_arr = explode(',',$settings['custom_post_meta']);
								if(is_array($post_metas_arr) && !empty($post_metas_arr)) {
									foreach($post_metas_arr as $post_meta){
										$post_meta_arr = explode(':',$post_meta);
										if(is_array($post_meta_arr) && !empty($post_meta_arr)){
											$metavalue  = get_post_meta($post->ID, $post_meta_arr[0], true);
											if(isset($post_meta_arr[1]) && !empty($post_meta_arr[1])) {
												$metamsg .= $post_meta_arr[1].' : '.$metavalue.'   ,';   
											}
											else {
												$metamsg .= $post_meta_arr[0].' : '.$metavalue.'   ,';
											}
										}
									}
								}

								$message .= __("Page Meta : ",$VTD_Cf_Posts_Fields->text_domain).$metamsg."<br/>";
							}
							
							$message .= "</div><br/>";

						}

					}	
					elseif($post->post_type == 'product' && isset($settings['is_product_enable'])){
						if(isset($settings['title_enable']) || isset($settings['url_enable']) || isset($settings['author_enable']) || isset($settings['post_id_enable']) || (isset($settings['custom_post_meta']) && !empty($settings['custom_post_meta']))){
							$message = "<div style='width:100%;'>";
							if(isset($settings['title_enable'])) {
								$message .= __("Product Title : ",$VTD_Cf_Posts_Fields->text_domain).$post->post_title."<br/>";
							}
							if(isset($settings['url_enable'])) {
								$message .= __("Product Url : ",$VTD_Cf_Posts_Fields->text_domain).get_permalink($post->ID)."<br/>";
							}
							if(isset($settings['author_enable'])) {
								$message .= __("Product Author : ",$VTD_Cf_Posts_Fields->text_domain).get_the_author_meta('login',$post->post_author)."<br/>";
							}
							if(isset($settings['post_id_enable'])) {
								$message .= __("Product ID : ",$VTD_Cf_Posts_Fields->text_domain).$post->ID."<br/>";
							}

							if(isset($settings['custom_post_meta']) && !empty($settings['custom_post_meta'])) {
								$metamsg = '';
								$post_metas_arr = explode(',',$settings['custom_post_meta']);
								if(is_array($post_metas_arr) && !empty($post_metas_arr)) {
									foreach($post_metas_arr as $post_meta){
										$post_meta_arr = explode(':',$post_meta);
										if(is_array($post_meta_arr) && !empty($post_meta_arr)){
											$metavalue  = get_post_meta($post->ID, $post_meta_arr[0], true);
											if(isset($post_meta_arr[1]) && !empty($post_meta_arr[1])) {
												$metamsg .= $post_meta_arr[1].' : '.$metavalue.'   ,';   
											}
											else {
												$metamsg .= $post_meta_arr[0].' : '.$metavalue.'   ,';
											}
										}
									}
								}

								$message .= __("Product Meta : ",$VTD_Cf_Posts_Fields->text_domain).$metamsg."<br/>";
							}
							
							$message .= "</div><br/>";
						}

					}			
				}
			}
		}

		$components['body'] = $message.$components['body'];		

		return $components;
	}

	
	
	

}
