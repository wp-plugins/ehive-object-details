<?php
/*
	Plugin Name: eHive Object Details
	Plugin URI: http://developers.ehive.com/wordpress-plugins/
	Author: Vernon Systems limited
	Description: Displays an eHive object. The <a href="http://developers.ehive.com/wordpress-plugins#ehiveaccess" target="_blank">eHiveAccess plugin</a> must be installed.
	Version: 2.1.4
	Author URI: http://vernonsystems.com
	License: GPL2+
*/
/*
	Copyright (C) 2012 Vernon Systems Limited

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
if (in_array('ehive-access/EHiveAccess.php', (array) get_option('active_plugins', array()))) {

    class EHiveObjectDetails {
    	
    	const CURRENT_VERSION = 1; // Increment each time an upgrade is required / options added or deleted.
    	const EHIVE_OBJECT_DETAILS_OPTIONS = "ehive_object_details_options";
    	
        function __construct() {        	        	
        	add_action("admin_init", array(&$this, "ehive_object_details_admin_options_init"));
        	add_action("admin_menu", array(&$this, "ehive_object_details_admin_menu"));
        	
        	add_action( 'wp_print_styles', array(&$this,'enqueue_styles'));
        	add_action( 'wp_print_scripts', array(&$this,'enqueue_scripts'));  

        	add_shortcode('ehive_object_details', array(&$this, 'ehive_object_details_shortcode'));        	         	
        }
        
        function ehive_object_details_admin_options_init(){
        	
        	$this->ehive_plugin_update();
        
        	register_setting(self::EHIVE_OBJECT_DETAILS_OPTIONS, self::EHIVE_OBJECT_DETAILS_OPTIONS, array(&$this, 'plugin_options_validate') );
        	 
        	add_settings_section('comment_section', '', array(&$this, 'comment_section_fn'), __FILE__);
        	 
        	add_settings_section('object_section', 'Object Details', array(&$this, 'object_section_fn'), __FILE__);
        
        	add_settings_section('style_section', 'CSS - Styleheet', array(&$this, 'style_section_fn'), __FILE__);
        	
        	add_settings_section('css_inline_section', 'CSS - inline', array(&$this, 'css_inline_section_fn'), __FILE__);
        }
        
        //
        //	Validation
        //
        function plugin_options_validate($input) {
        	add_settings_error(self::EHIVE_OBJECT_DETAILS_OPTIONS, 'updated', 'eHive Object Details settings saved.', 'updated');
        	        	 
        	$input["update_version"] = self::CURRENT_VERSION; // Retain the plugin version on save of opotions.
        	
        	return $input;
        }
        
        //
        //	Plugin options content
        //
        function comment_section_fn() {
        	echo "<p><em>An overview of the plugin and shortcode documentation is available in the help.</em></p>";
        }
        
        function object_section_fn() {
        	add_settings_field('public_profile_name_enabled', 'Show public profile name', array(&$this, 'public_profile_name_enabled_fn'), __FILE__, 'object_section');
        	add_settings_field('public_profile_name_link_enabled', 'Enable public profile name link', array(&$this, 'public_profile_name_link_enabled_fn'), __FILE__, 'object_section');        	
        	add_settings_field('pretty_photo_enabled', 'Enable prettyPhoto with object images', array(&$this, 'pretty_photo_enabled_fn'), __FILE__, 'object_section');
        	add_settings_field('images_to_display', 'Images to display', array(&$this, 'images_to_display_fn'), __FILE__, 'object_section');
        	add_settings_field('image_link_enabled', 'Enable image link', array(&$this, 'image_link_enabled_fn'), __FILE__, 'object_section');
        }
        
        function style_section_fn() {
        	add_settings_field('css_class', 'Custom class selector', array(&$this, 'css_class_fn'), __FILE__, 'style_section');
        	add_settings_field('plugin_css_enabled', 'Enable plugin stylesheet', array(&$this, 'plugin_css_enabled_fn'), __FILE__, 'style_section');
        }
        
        function css_inline_section_fn() {
        	add_settings_field('gallery_background_colour', 'Gallery background colour', array(&$this, 'gallery_background_colour_fn'), __FILE__, 'css_inline_section');
        	add_settings_field('gallery_border_colour', 'Gallery border', array(&$this, 'gallery_border_colour_fn'), __FILE__, 'css_inline_section');
        	add_settings_field('image_background_colour', 'Image background colour', array(&$this, 'image_background_colour_fn'), __FILE__, 'css_inline_section');
        	add_settings_field('image_padding', 'Image padding', array(&$this, 'image_padding_fn'), __FILE__, 'css_inline_section');
        	add_settings_field('image_border_colour', 'Image border', array(&$this, 'image_border_colour_fn'), __FILE__, 'css_inline_section');
        }
        
        //
        //	OBJECT SECTION
        //
        function public_profile_name_enabled_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	if($options['public_profile_name_enabled']) {
        		$checked = ' checked="checked" ';
        	}
        	echo "<input ".$checked." id='public_profile_name_enabled' name='ehive_object_details_options[public_profile_name_enabled]' type='checkbox' />";
        }
        
        function public_profile_name_link_enabled_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	if($options['public_profile_name_link_enabled']) {
        		$checked = ' checked="checked" ';
        	}
        	echo "<input ".$checked." id='public_profile_name_link_enabled' name='ehive_object_details_options[public_profile_name_link_enabled]' type='checkbox' />";
        }
        
        function pretty_photo_enabled_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	if($options['pretty_photo_enabled']) {
        		$checked = ' checked="checked" ';
        	}
        	echo "<input ".$checked." id='pretty_photo_enabled' name='ehive_object_details_options[pretty_photo_enabled]' type='checkbox' />";
        	echo '<p>Some themes may conflict with the prettyPhoto implementation in the eHive Object Details plugin. <br/>Use this option to disable prettyPhoto in the eHive Object Details plugin.';
        }
        
        function images_to_display_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	$items = array("All images", "First image");
        	foreach($items as $item) {
        		$checked = ($options['images_to_display']==$item) ? ' checked="checked" ' : '';
        		echo "<label><input ".$checked." value='$item' name='ehive_object_details_options[images_to_display]' type='radio' /> $item</label><br />";
        	}
        }
        
        function image_link_enabled_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	if($options['image_link_enabled']) {
        		$checked = ' checked="checked" ';
        	}
        	echo "<input ".$checked." id='image_link_enabled' name='ehive_object_details_options[image_link_enabled]' type='checkbox' />";
        	echo '<p>When prettyPhoto is disabled the image link option allows linking to larger images.';
        }
        
        
        //
        //	CSS SECTION
        //
        function plugin_css_enabled_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	if($options['plugin_css_enabled']) {
        		$checked = ' checked="checked" ';
        	}
        	echo "<input ".$checked." id='plugin_css_enabled' name='ehive_object_details_options[plugin_css_enabled]' type='checkbox' />";
        }
        
        function css_class_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	echo "<input class='regular-text' id='css_class' name='ehive_object_details_options[css_class]' type='text' value='{$options['css_class']}' />";
        	echo '<p>Adds a class name to the ehive-object-detail div.';
        }
        
        //
        //	inline CSS optons
        //
        function gallery_background_colour_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	echo "<input class='medium-text' id='gallery_background_colour' name='ehive_object_details_options[gallery_background_colour]' type='text' value='{$options['gallery_background_colour']}' />";
        	echo '<div id="gallery_background_colourpicker"></div>';
			
        	if(isset($options['gallery_background_colour_enabled']) && $options['gallery_background_colour_enabled'] == 'on') {
        		$checked = ' checked="checked" ';
        	}        	 
        	echo "<td><input ".$checked." id='gallery_background_colour_enabled' name='ehive_object_details_options[gallery_background_colour_enabled]' type='checkbox' /></td>";
			
			echo "<td rowspan='10'><img src='/wp-content/plugins/ehive-object-details/images/object_details_item.png' /></td>";			
        }
        
        function gallery_border_colour_fn() {
			$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
			echo "<input class='medium-text' id='gallery_border_colour' name='ehive_object_details_options[gallery_border_colour]' type='text' value='{$options['gallery_border_colour']}' />";
			echo '<div id="gallery_border_colourpicker"></div>';

			echo "<input class='small-text' id='gallery_border_width' name='ehive_object_details_options[gallery_border_width]' type='number' value='{$options['gallery_border_width']}' />";
				
			if(isset($options['gallery_border_colour_enabled']) && $options['gallery_border_colour_enabled'] == 'on') {
				$checked = ' checked="checked" ';
			}
			echo "<td><input ".$checked." id='gallery_border_colour_enabled' name='ehive_object_details_options[gallery_border_colour_enabled]' type='checkbox' /></td>";
        }
                
        function image_background_colour_fn() {
			$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
			echo "<input class='medium-text' id='image_background_colour' name='ehive_object_details_options[image_background_colour]' type='text' value='{$options['image_background_colour']}' />";
			echo '<div id="image_background_colourpicker"></div>';
			
			if(isset($options['image_background_colour_enabled']) && $options['image_background_colour_enabled'] == 'on') {
				$checked = ' checked="checked" ';
			}				
			echo "<td><input ".$checked." id='image_background_colour_enabled' name='ehive_object_details_options[image_background_colour_enabled]' type='checkbox' /></td>";
		}
        
		function image_padding_fn() {
			$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	echo "<input class='small-text' id='image_padding' name='ehive_object_details_options[image_padding]' type='number' value='{$options['image_padding']}' />";

        	if(isset($options['image_padding_enabled']) && $options['image_padding_enabled'] == 'on') {
        		$checked = ' checked="checked" ';
        	}        	 
        	echo "<td><input ".$checked." id='image_padding_enabled' name='ehive_object_details_options[image_padding_enabled]' type='checkbox' /></td>";
		}
        
		
		function image_border_colour_fn() {
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
			echo "<input class='medium-text' id='image_border_colour' name='ehive_object_details_options[image_border_colour]' type='text' value='{$options['image_border_colour']}' />";
			echo '<div id="image_border_colourpicker"></div>';

			echo "<input class='small-text' id='image_border_width' name='ehive_object_details_options[image_border_width]' type='number' value='{$options['image_border_width']}' />";
				
			
			if(isset($options['image_border_colour_enabled']) && $options['image_border_colour_enabled'] == 'on') {
				$checked = ' checked="checked" ';
			}
			echo "<td><input ".$checked." id='image_border_colour_enabled' name='ehive_object_details_options[image_border_colour_enabled]' type='checkbox' /></td>";				
		}
        
		       
		
        //
		//	Admin menu setup
		//
		function ehive_object_details_admin_menu() {
        
        	global $ehive_object_details_options_page;
        
        	$ehive_object_details_options_page = add_submenu_page('ehive_access', 'eHive Object Details', 'Object Details', 'manage_options', 'ehive_object_details', array(&$this, 'ehive_object_details_options_page'));
        
        	add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'ehive_object_details_plugin_action_links'), 10, 2);
        	
        	add_action("load-$ehive_object_details_options_page",array(&$this, "ehive_object_details_options_help"));
        	        	 
        	add_action("admin_print_styles-" . $ehive_object_details_options_page, array(&$this, "ehive_object_details_admin_enqueue_styles") );
        }
        
        //
        //	Admin menu link
        //
        function ehive_object_details_plugin_action_links($links, $file) {
        	$settings_link = '<a href="admin.php?page=ehive_object_details">' . __('Settings') . '</a>';
        	array_unshift($links, $settings_link); // before other links
        	return $links;
        }
                
        //
        //	Plugin options help
        //
        function ehive_object_details_options_help() {
        	global $ehive_object_details_options_page;
        
        	$screen = get_current_screen();
        	if ($screen->id != $ehive_object_details_options_page) {
        		return;
        	}
        
        	$screen->add_help_tab(array('id'      => 'ehive-object-details-overview',
                                		'title'   => 'Overview',
                                		'content' => "<p>Displays the details for an eHive object",
        	));
        	
        	$htmlShortcode = "<p><strong>Shortcode</strong> [ehive_object_details]</p>";
        	$htmlShortcode.= "<p><strong>Attributes:</strong></p>";
        	$htmlShortcode.= "<ul>";
        	
        	$htmlShortcode.= '<li><strong>css_class</strong> - Adds a custom class selector to the plugin markup.</li>';
        	
        	$htmlShortcode.= '<li><strong>public_profile_name_enabled</strong> - Display the public profile name for the account owning the object. Valid attribute value "on". Defaults to the options setting Show public profile name.</li>';

        	$htmlShortcode.= '<li><strong>object_record_id</strong> - Display the eHive object details for the object record id. Attribute, a valid object record id.</li>';
        	      	
        	$htmlShortcode.= '<p><strong>Examples:</strong></p>';
        	$htmlShortcode.= '<p>[ehive_object_details]<br/>Shortcode with no attributes. Attributes default to the options settings.</p>';
        	$htmlShortcode.= '<p>[ehive_object_details css_class="myClass" object_record_id="146136"]<br/>Displays the details for the eHive object with object record id "146136" with a custom class selector "myClass".</p>';
        	$htmlShortcode.= '<p>[ehive_object_details public_profile_name_enabled="on"]<br/>Display the details for an eHive object including the public profile name for the account owning the object.</p>';
        	$htmlShortcode.= "</ul>";
        	 
        	$screen->add_help_tab( array('id'		=> 'ehive-object-details-shortcode',
        								 'title'	=> 'Shortcode',
        								 'content'	=> $htmlShortcode
        	));
        		
        	$screen->set_help_sidebar('<p><strong>For more information:</strong></p><p><a href="http://developers.ehive.com/wordpress-plugins#ehiveobjectdetails" target="_blank">Documentation for eHive plugins</a></p>');   	 
        }
        
        //
        //	Add admin stylesheet
        //
        function ehive_object_details_admin_enqueue_styles() {
        	wp_enqueue_style('eHiveAdminCSS');
        }
        
                        
        
        //
        //	Options page setup
        //
        function ehive_object_details_options_page() {
        	?>
            <div class="wrap">
        		<div class="icon32" id="icon-options-ehive"><br></div>
        			<h2>eHive Object Details Settings</h2>
        			<?php settings_errors();?>        		
        			<form action="options.php" method="post">
        				<?php settings_fields('ehive_object_details_options'); ?>
        				<?php do_settings_sections(__FILE__); ?>
        				<p class="submit">
        					<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
        				</p>
        			</form>
        		</div>
        	<?php
        }
        
        //
        //	Add plugin stylesheet
        //
        public function enqueue_styles() {
        	
        	global $eHiveAccess;
        	 
        	$objectDetailsPageId = $eHiveAccess->getObjectDetailsPageId();
        	 
        	if (is_page( $objectDetailsPageId )) {
        
        		$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
                		
        		if ($options['plugin_css_enabled'] == 'on') {
        			wp_register_style($handle = 'eHiveObjectDetailsCSS', $src = plugins_url('eHiveObjectDetails.css', '/ehive-object-details/css/eHiveObjectDetails.css'), $deps = array(), $ver = '0.0.1', $media = 'all');
        			wp_enqueue_style( 'eHiveObjectDetailsCSS');
        		}
        
        		if ($options['pretty_photo_enabled'] == 'on') {
        			wp_register_style($handle = 'prettyPhoto', $src = plugins_url('prettyPhoto.css', '/ehive-object-details/js/prettyPhoto/css/prettyPhoto'), $deps = array(), $ver = '1.0.0', $media = 'all');
        			wp_enqueue_style( 'prettyPhoto');
        		}
        	}        	
        }
        
        //
        //	Add plugin scripts
        //
        public function enqueue_scripts() {

        	global $eHiveAccess;
        	         
        	$objectDetailsPageId = $eHiveAccess->getObjectDetailsPageId();
        	 
        	if (is_page( $objectDetailsPageId )){
        		 
				$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);

        		wp_enqueue_script( 'jquery' );
        
        		if ($options['pretty_photo_enabled'] == 'on') {
        
        			wp_register_script($handle = 'prettyPhoto', $src= plugins_url('jquery.prettyPhoto.js', '/ehive-object-details/js/prettyPhoto/js/jquery.prettyPhoto.js'), $deps = array('jquery'), $ver = '1.0.0', false);
        			wp_enqueue_script( 'prettyPhoto' );

        			wp_register_script($handle = 'jcarousellite', $src= plugins_url('jcarousellite_1.0.1.min.js', '/ehive-object-details/js/jcarousellite_1.0.1.min.js'), $deps = array('jquery','prettyPhoto'), $ver = '1.0.0', false);
        			wp_enqueue_script( 'jcarousellite' );
        			         			
        			wp_register_script($handle = 'eHiveObjectDetails', $src= plugins_url('eHiveObjectDetails.js', '/ehive-object-details/js/eHiveObjectDetails.js'), $deps = array('jquery','prettyPhoto','jcarousellite'), $ver = '1.0.0', false);
        			wp_enqueue_script( 'eHiveObjectDetails' );        			 
        		}
        	}        	
        }
        
        //
        //	Shortcode setup
        //
        public function ehive_object_details_shortcode($atts) {
        	
        	$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
        	        	        	
        	extract(shortcode_atts(array('public_profile_name_enabled' 				=> isset($options['public_profile_name_enabled']) ? 'on' : 'off',
        								 'object_record_name_as_page_title_enabled' => isset($options['object_record_name_as_page_title_enabled']) ? 'on' : 'off',
            							 'object_record_id'			  				=> 0,
        								 'css_class'				   				=> array_key_exists('css_class', $options) ? $options['css_class'] : '',
        								 'gallery_background_colour'				=> array_key_exists('gallery_background_colour', $options) ? $options['gallery_background_colour'] : '#f3f3f3',
										 'gallery_background_colour_enabled'		=> array_key_exists('gallery_background_colour_enabled', $options) ? $options['gallery_background_colour_enabled'] : 'on',
										 'gallery_border_colour'					=> array_key_exists('gallery_border_colour', $options) ? $options['gallery_border_colour'] : '#666666',
										 'gallery_border_colour_enabled'			=> array_key_exists('gallery_border_colour_enabled', $options) ? $options['gallery_border_colour_enabled'] : '',
										 'gallery_border_width' 					=> array_key_exists('gallery_border_width', $options) ? $options['gallery_border_width'] : '2',
										 'image_background_colour'					=> array_key_exists('image_background_colour', $options) ? $options['image_background_colour'] : '#ffffff',
										 'image_background_colour_enabled'			=> array_key_exists('image_background_colour_enabled', $options) ? $options['image_background_colour_enabled'] : 'on',
										 'image_padding' 							=> array_key_exists('image_padding', $options) ? $options['image_padding'] : '1',
										 'image_padding_enabled' 					=> array_key_exists('image_padding_enabled', $options) ? $options['image_padding_enabled'] : 'on',
										 'image_border_colour'						=> array_key_exists('image_border_colour', $options) ? $options['image_border_colour'] : '#666666',
										 'image_border_colour_enabled'				=> array_key_exists('image_border_colour_enabled', $options) ? $options['image_border_colour_enabled'] : 'on',
										 'image_border_width' 						=> array_key_exists('image_border_width', $options) ? $options['image_border_width'] : '2'), $atts));
                        
            if ($object_record_id == 0) {
            	$object_record_id = ehive_get_var('ehive_object_record_id');            	
            }
                                                                                    
            global $eHiveAccess;
            
            $siteType = $eHiveAccess->getSiteType();
            $accountId = $eHiveAccess->getAccountId();
            $communityId = $eHiveAccess->getCommunityId();

            $eHiveApi = $eHiveAccess->eHiveApi();
            
            try {
	            $object = $eHiveApi->getObjectRecord($object_record_id);
	            
	            // FIXME getObjectRecord should return account summary information. Reduce the number of server calls.	           
	            if ($public_profile_name_enabled == 'on') {
	            	$account = $eHiveApi->getAccount( $object->accountId );
	            }
	            
            } catch (Exception $exception) {
            	error_log('EHive Object Details plugin returned and error while accessing the eHive API: ' . $exception->getMessage());
            	$eHiveApiErrorMessage = " ";
            	if ($eHiveAccess->getIsErrorNotificationEnabled()) {
            		$eHiveApiErrorMessage = $eHiveAccess->getErrorMessage();
            	}
            }
            
            $template = locate_template(array('eHiveObjectDetails.php'));
            if ('' == $template) {
            	$template = "templates/eHiveObjectDetails.php";
            }
            
            ob_start();
            require($template);
            return apply_filters('ehive_object_details', ob_get_clean());
        }
                

        function add_rewrite_rules($rules) {
            global $eHiveAccess, $wp_rewrite;

            $pageId = $eHiveAccess->getObjectDetailsPageId();	
            
            if ($pageId != 0) {            
	            $page = get_post($pageId);	            
	            $objectRecordIdToken = '%eHiveObjectId%';                        
	            $wp_rewrite->add_rewrite_tag($objectRecordIdToken, '([0-9]+)', "pagename={$page->post_name}&ehive_object_record_id=");            
	            $rules = $wp_rewrite->generate_rewrite_rules($wp_rewrite->root . "/{$page->post_name}/$objectRecordIdToken") + $rules;
            }
            return $rules;
        }

        function query_vars($vars) {
        	$vars[] = 'ehive_object_record_id';
        	return $vars;
        }
       
        function flushRules() {        	
        	global $wp_rewrite;
        	$wp_rewrite->flush_rules();
        }

        //
        //	Setup the plugin options, handle upgrades to the plugin.
        //
        function ehive_plugin_update() {
									        	
			// Add the default options.					
			if ( get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS) === false ) {
				
				$options = array("update_version"=>self::CURRENT_VERSION,
								 "public_profile_name_enabled"=>"on",
								 "public_profile_name_link_enabled"=>"on",
								 "pretty_photo_enabled"=>"on",
								 "plugin_css_enabled"=>"on",
								 "images_to_display"=>"All images",
								 "image_link_enabled"=>"on",
								 "css_class"=>"",

								 "gallery_background_colour"=>"#f3f3f3",
								 "gallery_background_colour_enabled"=>'on',

								 "gallery_border_colour"=>"#666666",
								 "gallery_border_colour_enabled"=>'',
								 "gallery_border_width"=>"2",

								 "image_background_colour"=>"#ffffff",
								 "image_background_colour_enabled"=>'on',

								 "image_padding"=>"1",
								 "image_padding_enabled"=>"on",

								 "image_border_colour"=>"#666666",
								 "image_border_colour_enabled"=>'on',
								 "image_border_width"=>"2" );
					
				add_option(self::EHIVE_OBJECT_DETAILS_OPTIONS, $options);				
												
			} else { 
						
				$options = get_option(self::EHIVE_OBJECT_DETAILS_OPTIONS);
				
				if ( array_key_exists("update_version", $options)) {
					$updateVersion = $options["update_version"];					
				} else {
					$updateVersion = 0; 
				}
								
				if ( $updateVersion == self::CURRENT_VERSION ) {
					// Nothing to do.			
				}  else {
								
					if ( $updateVersion == 0 ) {
																			
						$options["public_profile_name_link_enabled"] = "on";
						$options["pretty_photo_enabled"] = "on";
						$options["images_to_display"] = "All images";					
						$options["image_link_enabled"] = "on";
							
						$updateVersion = 1; 
					}
					
					// End of the update chain, save the options to the database.
					$options["update_version"] = self::CURRENT_VERSION;
					update_option(self::EHIVE_OBJECT_DETAILS_OPTIONS, $options);						
				}				
			}				
		}
                
        //
        //	On plugin activate
        //	
        public function activate() {        	        	       	
        }

        //
        //	On plugin deactivate
        //
        public function deactivate() { 
        }
    }

    $eHiveObjectDetails = new EHiveObjectDetails();
   
    add_filter('rewrite_rules_array', array(&$eHiveObjectDetails, 'add_rewrite_rules'));
    add_filter('query_vars', array(&$eHiveObjectDetails, 'query_vars'));
    add_filter('init', array(&$eHiveObjectDetails, 'flushRules'));
    
    add_action('activate_ehive-object-details/EHiveObjectDetails.php', array(&$eHiveObjectDetails, 'activate'));
    add_action('deactivate_ehive-object-details/EHiveObjectDetails.php', array(&$eHiveObjectDetails, 'deactivate'));    
}
?>