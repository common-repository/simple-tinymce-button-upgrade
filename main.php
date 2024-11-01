<?php
/**
 * @package Simple TinyMCE
 * @version 3.2.1.3
 */
/*
Plugin Name: Simple TinyMCE
Plugin URI: http://www.joshlobe.com/2011/11/adding-buttons-to-tinymce-in-wordpress/
Description: Beef up your visual tinymce editor with a plethora of advanced options: Google Fonts, Emoticons, Tables, Styles, Advanced links, images, and drop-downs, too many features to list.
Author: Josh Lobe
Version: 3.2.1.3
Author URI: http://joshlobe.com

*/

/*  Copyright 2011  Josh Lobe  (email : joshlobe@joshlobe.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
function simple_tinymce_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/main.php' ) ) {
		$links[] = '<a href="plugins.php?page=simple-tinymce">'.__('Settings').'</a>';
	}

	return $links;
}
add_filter( 'plugin_action_links', 'simple_tinymce_plugin_action_links', 10, 2 );
*/

/**
 * Add Settings link to plugins - code from GD Star Ratings
 */
function add_simpletinymce_settings_link($links, $file) {
static $this_plugin;
if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
 
if ($file == $this_plugin){
$settings_link = '<a href="admin.php?page=simple-tinymce">'.__("Settings").'</a>';
array_unshift($links, $settings_link);
}
return $links;
}
add_filter('plugin_action_links', 'add_simpletinymce_settings_link', 10, 2 );

// Call our external stylesheet
function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/admin_panel.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');



// Add the admin options page

	add_action('admin_menu', 'jwl_admin_add_page');
	
	function jwl_admin_add_page() {
	
		add_options_page(
						   'Simple TinyMCE Plugin Page', 
						   'Simple TinyMCE', 
						   'manage_options', 
						   'simple-tinymce', 
						   'jwl_options_page'
						  );
	
	}

// Display the admin options page
	function jwl_options_page() {
	?>
	
	<div class="wrap">
		<h2>Simple TinyMCE Plugin Menu</h2>

            <div class="metabox-holder" style="width:65%; float:left; margin-right:10px;">
                <div class="postbox">  
                <div class="inside" style="padding:0px 0px 0px 0px;">
                	<form action="options.php" method="post">
                    <?php settings_fields('jwl_options_group'); ?>
                    <?php do_settings_sections('simple-tinymce'); ?><br /><br />  
                    
                    <br /><br />     
                </div>
                </div>
                
                <div class="postbox">
                <div class="inside" style="padding:0px 0px 0px 0px;">
                	
                    <?php settings_fields('jwl_options_group'); ?>
                    <?php do_settings_sections('simple-tinymce2'); ?><br /> 
                       
                    <br /><br />
                </div>
                </div>
                <center><input class="button-primary" type="submit" name="Save" value="<?php _e('Save Your Selection'); ?>" id="submitbutton" /></center>
                </form>
            </div>
              
            
 
    		<div class="metabox-holder" style="width:30%; float:left;">
 
            
            <div class="postbox">
                <h3 style="cursor:default;">Donations</h3>
                <div class="inside" style="padding:0px 6px 6px 6px;">
                <p><strong>&nbsp;&nbsp;Even the smallest donations are gratefully accepted.</strong></p>
                        
                <!--  Donate Button -->
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="A9E5VNRBMVBCS">
                <center><input type="image" src="http://www.joshlobe.com/images/donate.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></center>
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
                </div>
            </div>
            
            <div class="postbox">
                <h3 style="cursor:default;">Additional Resources</h3>
                <div class="inside" style="padding:6px 6px 6px 6px;">
                <a href="http://www.joshlobe.com/2011/10/adding-buttons-to-tinymce-in-wordpress/" target="_blank">Get help from my personal blog.</a><br /><br />
                <a href="http://wordpress.org/tags/simple-tinymce-button-upgrade?forum_id=10#postform" target="_blank">Post a thread in the Wordpress Plugin Page.</a><br /><br />
                <a href="http://www.joshlobe.com/contact-me/" target="_blank">Email me directly using my contact form.</a><br /><br />
                <a href="http://www.joshlobe.com/feed/" target="_blank">Subscribe to my RSS Feed.</a><br /><br />
                Follow me on <a target="_blank" href="http://www.facebook.com/joshlobe">Facebook</a> and <a target="_blank" href="http://twitter.com/#!/joshlobe">Twitter</a>.<br />
                </div>
            </div>
            
            <div class="postbox">
                <h3 style="cursor:default;">Please VOTE and click WORKS.</h3>
                <div class="inside" style="padding:12px 12px 12px 12px;">
                <a href="http://wordpress.org/extend/plugins/simple-tinymce-button-upgrade/" target="_blank">Click Here to Vote...</a><br /><br />Voting helps my plugin get more exposure and higher rankings on the searches.<br /><br />Please help spread this wonderful plugin by showing your support.  Thank you!
                
                </div>
            </div>
        
              
    	</div>
               
	</div>
    
	
	<?php 
	}




// ------------------------------------------------------------------
 // Add all your sections, fields and settings during admin_init
 // ------------------------------------------------------------------
 //
 
 function jwl_settings_api_init() {
 	// Add the section to simple-tinymce settings so we can add our
 	// fields to it
 	add_settings_section('jwl_setting_section', 'Row 3 Button Settings', 'jwl_setting_section_callback_function', 'simple-tinymce');
	add_settings_section('jwl_setting_section2', 'Row 4 Button Settings', 'jwl_setting_section_callback_function2', 'simple-tinymce2');
 	
 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
	
	// These are the settings for Row 3
 	add_settings_field('jwl_fontselect_field_id', 'Font Select Box', 'jwl_fontselect_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_fontsizeselect_field_id', 'Font Size Box', 'jwl_fontsizeselect_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_styleselect_field_id', 'Style Select Box', 'jwl_styleselect_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_cut_field_id', 'Cut Box', 'jwl_cut_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_copy_field_id', 'Copy Box', 'jwl_copy_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_paste_field_id', 'Paste Box', 'jwl_paste_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_backcolorpicker_field_id', 'Background Color Picker Box', 'jwl_backcolorpicker_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_forecolorpicker_field_id', 'Foreground Color Picker Box', 'jwl_forecolorpicker_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_hr_field_id', 'Horizontal Row Box', 'jwl_hr_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_visualaid_field_id', 'Visual Aid Box', 'jwl_visualaid_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_anchor_field_id', 'Anchor Box', 'jwl_anchor_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_sub_field_id', 'Subscript Box', 'jwl_sub_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_sup_field_id', 'Superscript Box', 'jwl_sup_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_search_field_id', 'Search Box', 'jwl_search_callback_function', 'simple-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_replace_field_id', 'Replace Box', 'jwl_replace_callback_function', 'simple-tinymce', 'jwl_setting_section');
	
	add_settings_field('jwl_moods_field_id', 'Josh\'s Ultimate Moods Box', 'jwl_moods_callback_function', 'simple-tinymce', 'jwl_setting_section');
	
	// These are the settings for Row 4
	add_settings_field('jwl_tablecontrols_field_id', 'Table Controls Box', 'jwl_tablecontrols_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_emotions_field_id', 'Emotions Box', 'jwl_emotions_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_image_field_id', 'Advanced Image Box', 'jwl_image_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_preview_field_id', 'Preview Box', 'jwl_preview_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_cite_field_id', 'Citations Box', 'jwl_cite_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_abbr_field_id', 'Abbreviations Box', 'jwl_abbr_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_acronym_field_id', 'Acronym Box', 'jwl_acronym_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_del_field_id', 'Delete Box', 'jwl_del_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_ins_field_id', 'Insert Box', 'jwl_ins_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_attribs_field_id', 'Attributes Box', 'jwl_attribs_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_styleprops_field_id', 'Styleprops Box', 'jwl_styleprops_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_code_field_id', 'HTML Code Box', 'jwl_code_callback_function', 'simple-tinymce2', 'jwl_setting_section2');
 	
 	
	// Register our setting so that $_POST handling is done for us and
 	// our callback function just has to echo the <input>
	
	// Register settings for Row 3
 	register_setting('jwl_options_group','jwl_fontselect_field_id');
	register_setting('jwl_options_group','jwl_fontsizeselect_field_id');
	register_setting('jwl_options_group','jwl_styleselect_field_id');
	register_setting('jwl_options_group','jwl_cut_field_id');
	register_setting('jwl_options_group','jwl_copy_field_id');
	register_setting('jwl_options_group','jwl_paste_field_id');
	register_setting('jwl_options_group','jwl_backcolorpicker_field_id');
	register_setting('jwl_options_group','jwl_forecolorpicker_field_id');
	register_setting('jwl_options_group','jwl_hr_field_id');
	register_setting('jwl_options_group','jwl_visualaid_field_id');
	register_setting('jwl_options_group','jwl_anchor_field_id');
	register_setting('jwl_options_group','jwl_sub_field_id');
	register_setting('jwl_options_group','jwl_sup_field_id');
	register_setting('jwl_options_group','jwl_search_field_id');
	register_setting('jwl_options_group','jwl_replace_field_id');
	
	register_setting('jwl_options_group','jwl_moods_field_id');
	
	
	// Register settings for Row 4
	register_setting('jwl_options_group','jwl_tablecontrols_field_id');
	register_setting('jwl_options_group','jwl_emotions_field_id');
	register_setting('jwl_options_group','jwl_image_field_id');
	register_setting('jwl_options_group','jwl_preview_field_id');
	register_setting('jwl_options_group','jwl_cite_field_id');
	register_setting('jwl_options_group','jwl_abbr_field_id');
	register_setting('jwl_options_group','jwl_acronym_field_id');
	register_setting('jwl_options_group','jwl_del_field_id');
	register_setting('jwl_options_group','jwl_ins_field_id');
	register_setting('jwl_options_group','jwl_attribs_field_id');
	register_setting('jwl_options_group','jwl_styleprops_field_id');
	register_setting('jwl_options_group','jwl_code_field_id');

 }
 
 add_action('admin_init', 'jwl_settings_api_init');  
 
  
 // ------------------------------------------------------------------
 // Settings section callback function
 // ------------------------------------------------------------------
 //
 // This function is needed if we added a new section. This function 
 // will be run at the start of our section
 //
 
 function jwl_setting_section_callback_function() {
 	echo '<p>Here you can select which buttons to include in row 3 of the TinyMCE editor.</p>';
 }
 
 function jwl_setting_section_callback_function2() {
 	echo '<p>Here you can select which buttons to include in row 4 of the TinyMCE editor.</p>';
 }
 
 // ------------------------------------------------------------------
 // Callback function for our example setting
 // ------------------------------------------------------------------
 //
 // creates a checkbox true/false option. Other types are surely possible
 //
 
 
  // Callback Functions for Row 3 Buttons
 function jwl_fontselect_callback_function() {
 	echo '<input name="jwl_fontselect_field_id" id="fontselect" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_fontselect_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/fontselect.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
  
 function jwl_fontsizeselect_callback_function() {
 	echo '<input name="jwl_fontsizeselect_field_id" id="fontsize" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_fontsizeselect_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/fontsizeselect.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }

 function jwl_styleselect_callback_function() {
 	echo '<input name="jwl_styleselect_field_id" id="styleselect" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_styleselect_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/styleselect.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_cut_callback_function() {
 	echo '<input name="jwl_cut_field_id" id="cut" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_cut_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/cut.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_copy_callback_function() {
 	echo '<input name="jwl_copy_field_id" id="copy" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_copy_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/copy.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_paste_callback_function() {
 	echo '<input name="jwl_paste_field_id" id="paste" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_paste_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/paste.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_backcolorpicker_callback_function() {
 	echo '<input name="jwl_backcolorpicker_field_id" id="backcolorpicker" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_backcolorpicker_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/backcolorpicker.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_forecolorpicker_callback_function() {
 	echo '<input name="jwl_forecolorpicker_field_id" id="forecolorpicker" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_forecolorpicker_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/forecolorpicker.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_hr_callback_function() {
 	echo '<input name="jwl_hr_field_id" id="hr" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_hr_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/hr.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_visualaid_callback_function() {
 	echo '<input name="jwl_visualaid_field_id" id="visualaid" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_visualaid_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/visualaid.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_anchor_callback_function() {
 	echo '<input name="jwl_anchor_field_id" id="anchor" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_anchor_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/anchor.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_sub_callback_function() {
 	echo '<input name="jwl_sub_field_id" id="sub" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_sub_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/sub.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_sup_callback_function() {
 	echo '<input name="jwl_sup_field_id" id="sup" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_sup_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/sup.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
  function jwl_search_callback_function() {
 	echo '<input name="jwl_search_field_id" id="search" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_search_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/search.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
  function jwl_replace_callback_function() {
 	echo '<input name="jwl_replace_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_replace_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/replace.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 
 function jwl_moods_callback_function() {
 	echo '<input name="jwl_moods_field_id" id="moods" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_moods_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/moods.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 
 // Callback Functions for Row 4 Buttons
 function jwl_tablecontrols_callback_function() {
 	echo '<input name="jwl_tablecontrols_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_tablecontrols_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/tablecontrols.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_emotions_callback_function() {
 	echo '<input name="jwl_emotions_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_emotions_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/emotions.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_image_callback_function() {
 	echo '<input name="jwl_image_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_image_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/image.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_preview_callback_function() {
 	echo '<input name="jwl_preview_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_preview_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/preview.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_cite_callback_function() {
 	echo '<input name="jwl_cite_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_cite_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/cite.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_abbr_callback_function() {
 	echo '<input name="jwl_abbr_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_abbr_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/abbr.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_acronym_callback_function() {
 	echo '<input name="jwl_acronym_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_acronym_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/acronym.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_del_callback_function() {
 	echo '<input name="jwl_del_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_del_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/del.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_ins_callback_function() {
 	echo '<input name="jwl_ins_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_ins_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/ins.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_attribs_callback_function() {
 	echo '<input name="jwl_attribs_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_attribs_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/attribs.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_styleprops_callback_function() {
 	echo '<input name="jwl_styleprops_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_styleprops_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/styleprops.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 function jwl_code_callback_function() {
 	echo '<input name="jwl_code_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_code_field_id'), false ) . ' /> ';
	?><img src="../../../../wp-content/plugins/simple-tinymce-button-upgrade/img/code.png" style="margin-left:10px;margin-bottom:-5px;" /><?php
 }
 
 
 


// Functions for Getting Values for Row 3
function tinymce_add_button_fontselect($buttons) {
$jwl_fontselect = get_option('jwl_fontselect_field_id');
if ($jwl_fontselect == "1")
$buttons[] = 'fontselect';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_fontselect");

function tinymce_add_button_fontsizeselect($buttons) {
$jwl_fontsizeselect = get_option('jwl_fontsizeselect_field_id');
if ($jwl_fontsizeselect == "1")
$buttons[] = 'fontsizeselect';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_fontsizeselect");

function tinymce_add_button_styleselect($buttons) {
$jwl_styleselect = get_option('jwl_styleselect_field_id');
if ($jwl_styleselect == "1")
$buttons[] = 'styleselect';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_styleselect");

function tinymce_add_button_cut($buttons) {
$jwl_cut = get_option('jwl_cut_field_id');
if ($jwl_cut == "1")
$buttons[] = 'cut';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_cut");

function tinymce_add_button_copy($buttons) {
$jwl_copy = get_option('jwl_copy_field_id');
if ($jwl_copy == "1")
$buttons[] = 'copy';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_copy");

function tinymce_add_button_paste($buttons) {
$jwl_paste = get_option('jwl_paste_field_id');
if ($jwl_paste == "1")
$buttons[] = 'paste';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_paste");

function tinymce_add_button_backcolorpicker($buttons) {
$jwl_backcolorpicker = get_option('jwl_backcolorpicker_field_id');
if ($jwl_backcolorpicker == "1")
$buttons[] = 'backcolorpicker';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_backcolorpicker");

function tinymce_add_button_forecolorpicker($buttons) {
$jwl_forecolorpicker = get_option('jwl_forecolorpicker_field_id');
if ($jwl_forecolorpicker == "1")
$buttons[] = 'forecolorpicker';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_forecolorpicker");

function tinymce_add_button_hr($buttons) {
$jwl_hr = get_option('jwl_hr_field_id');
if ($jwl_hr == "1")
$buttons[] = 'hr';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_hr");

function tinymce_add_button_visualaid($buttons) {
$jwl_visualaid = get_option('jwl_visualaid_field_id');
if ($jwl_visualaid == "1")
$buttons[] = 'visualaid';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_visualaid");

function tinymce_add_button_anchor($buttons) {
$jwl_anchor = get_option('jwl_anchor_field_id');
if ($jwl_anchor == "1")
$buttons[] = 'anchor';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_anchor");

function tinymce_add_button_sub($buttons) {
$jwl_sub = get_option('jwl_sub_field_id');
if ($jwl_sub == "1")
$buttons[] = 'sub';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_sub");

function tinymce_add_button_sup($buttons) {
$jwl_sup = get_option('jwl_sup_field_id');
if ($jwl_sup == "1")
$buttons[] = 'sup';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_sup");

function tinymce_add_button_search($buttons) {
$jwl_search = get_option('jwl_search_field_id');
if ($jwl_search == "1")
$buttons[] = 'search';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_search");

function tinymce_add_button_replace($buttons) {
$jwl_replace = get_option('jwl_replace_field_id');
if ($jwl_replace == "1")
$buttons[] = 'replace';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_replace");


function tinymce_add_button_moods($buttons) {
$jwl_moods = get_option('jwl_moods_field_id');
if ($jwl_moods == "1")
$buttons[] = 'moods';
return $buttons;
}
add_filter("mce_buttons_3", "tinymce_add_button_moods");


// Functions for Getting Values for Row 4
function tinymce_add_button_tablecontrols($buttons) {
$jwl_tablecontrols = get_option('jwl_tablecontrols_field_id');
if ($jwl_tablecontrols == "1")
$buttons[] = 'tablecontrols';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_tablecontrols");

function tinymce_add_button_emotions($buttons) {
$jwl_emotions = get_option('jwl_emotions_field_id');
if ($jwl_emotions == "1")
$buttons[] = 'emotions';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_emotions");

function tinymce_add_button_image($buttons) {
$jwl_image = get_option('jwl_image_field_id');
if ($jwl_image == "1")
$buttons[] = 'image';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_image");

function tinymce_add_button_preview($buttons) {
$jwl_preview = get_option('jwl_preview_field_id');
if ($jwl_preview == "1")
$buttons[] = 'preview';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_preview");

function tinymce_add_button_cite($buttons) {
$jwl_cite = get_option('jwl_cite_field_id');
if ($jwl_cite == "1")
$buttons[] = 'cite';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_cite");

function tinymce_add_button_abbr($buttons) {
$jwl_abbr = get_option('jwl_abbr_field_id');
if ($jwl_abbr == "1")
$buttons[] = 'abbr';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_abbr");

function tinymce_add_button_acronym($buttons) {
$jwl_acronym = get_option('jwl_acronym_field_id');
if ($jwl_acronym == "1")
$buttons[] = 'acronym';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_acronym");

function tinymce_add_button_del($buttons) {
$jwl_del = get_option('jwl_del_field_id');
if ($jwl_del == "1")
$buttons[] = 'del';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_del");

function tinymce_add_button_ins($buttons) {
$jwl_ins = get_option('jwl_ins_field_id');
if ($jwl_ins == "1")
$buttons[] = 'ins';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_ins");

function tinymce_add_button_attribs($buttons) {
$jwl_attribs = get_option('jwl_attribs_field_id');
if ($jwl_attribs == "1")
$buttons[] = 'attribs';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_attribs");

function tinymce_add_button_styleprops($buttons) {
$jwl_styleprops = get_option('jwl_styleprops_field_id');
if ($jwl_styleprops == "1")
$buttons[] = 'styleprops';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_styleprops");

function tinymce_add_button_code($buttons) {
$jwl_code = get_option('jwl_code_field_id');
if ($jwl_code == "1")
$buttons[] = 'code';
return $buttons;
}
add_filter("mce_buttons_4", "tinymce_add_button_code");



/*
	function tinymce_add_buttons($buttons) {
	 $buttons[] = 'fontselect';
	 $buttons[] = 'fontsizeselect';
	 $buttons[] = 'styleselect';
	 $buttons[] = '|';
	 $buttons[] = '|';
	 $buttons[] = 'cut';
	 $buttons[] = 'copy';
	 $buttons[] = 'paste';
	 $buttons[] = '|';
	 $buttons[] = '|';
	 $buttons[] = 'backcolorpicker';
	 $buttons[] = 'forecolorpicker';
	 $buttons[] = '|';
	 $buttons[] = '|';
	 $buttons[] = 'hr';
	 $buttons[] = 'visualaid';
	 $buttons[] = 'anchor';
	 $buttons[] = '|';
	 $buttons[] = '|';
	 $buttons[] = 'sub';
	 $buttons[] = 'sup';
	 $buttons[] = 'search';
	 $buttons[] = 'replace';
	
	 return $buttons;
	}
	
	add_filter("mce_buttons_3", "tinymce_add_buttons");
	
*/



	class mce_table_buttons
	{
		function __construct() 
		{
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'content_save_pre', array( $this, 'content_save_pre'), 100 ); 
		}
		
		function admin_init()
		{
			add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) ); 
			//add_filter( 'mce_buttons_4', array( $this, 'mce_buttons_4' ) );
			add_filter( 'theme_advanced_fonts', array( $this, 'theme_advanced_fonts' ) );
		}
		
		function mce_external_plugins( $plugin_array )
		{
			if ( get_option('db_version') < 17056 )
				$plugin_array['table'] = plugin_dir_url( __FILE__ ) . 'table-old/editor_plugin.js';
			else 
				$plugin_array['table'] = plugin_dir_url( __FILE__ ) . 'table/editor_plugin.js';
				$plugin_array['emotions'] = plugin_dir_url(__FILE__) . 'emotions/editor_plugin.js';
				$plugin_array['advlist'] = plugin_dir_url(__FILE__) . 'advlist/editor_plugin.js';
				$plugin_array['advlink'] = plugin_dir_url(__FILE__) . 'advlink/editor_plugin.js';
				$plugin_array['advimage'] = plugin_dir_url(__FILE__) . 'advimage/editor_plugin.js';
				$plugin_array['searchreplace'] = plugin_dir_url(__FILE__) . 'searchreplace/editor_plugin.js';
				$plugin_array['preview'] = plugin_dir_url(__FILE__) . 'preview/editor_plugin.js';
				$plugin_array['xhtmlxtras'] = plugin_dir_url(__FILE__) . 'xhtmlxtras/editor_plugin.js';
				$plugin_array['style'] = plugin_dir_url(__FILE__) . 'style/editor_plugin.js';
				
				$plugin_array['moods'] = plugin_dir_url(__FILE__) . 'moods/editor_plugin.js';
				   
				return $plugin_array;
		}
		
		/*
		function mce_buttons_4( $buttons )
		{
			array_push( $buttons, 'tablecontrols', '|', 'emotions', '|', 'image', '|', 'preview', '|','cite', 'abbr', 'acronym', 'del', 'ins', 'attribs', '|', 'styleprops', 'code');
			return $buttons;
		}
		*/
		
		function content_save_pre( $content )
		{
			if ( substr( $content, -8 ) == '</table>' )
				$content = $content . "\n<br />";
			
			return $content;
		}
	}
	
	$mce_table_buttons = new mce_table_buttons;



	/*
     * register with hook 'wp_print_styles'
     */
    add_action('admin_print_styles', 'add_josh_stylesheet');
	add_action('wp_print_styles', 'add_josh_stylesheet');

    /*
     * Enqueue style-file, if it exists.
     */

    function add_josh_stylesheet() {
        $myStyleUrl = plugins_url('josh-font-style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
        $myStyleFile = WP_PLUGIN_DIR . '/simple-tinymce-button-upgrade/josh-font-style.css';
        if ( file_exists($myStyleFile) ) {
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style( 'myStyleSheets');
        }
    }
	
	function josh_stbu_custom_options( $opt ) {
	//format drop down list
	//$opt['theme_advanced_blockformats'] = 'p,pre,code,h3,h4';
	//font list
	/*$opt['theme_advanced_fonts'] = 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;Aclonica=Aclonica, sans-serif;Michroma=Michroma, sans-serif;Paytone One=Paytone One, sans-serif;Permanent Marker=Permanent Marker, cursive;Unkempt=Unkempt, cursive;Julee=Julee, cursive;Rammetto One=Rammetto One, cursive;Yeseva One=Yeseva One, serif;Irish Grover=Irish Grover, cursive;The Girl Next Door=The Girl Next Door, cursive;Bitter=Bitter, serif;Eater Caps=Eater Caps, cursive;Waiting for the Sunrise=Waiting for the Sunrise, cursive;Rancho=Rancho, cursive;Sancreek=Sancreek, cursive;Leckerli One=Leckerli One, cursive;Aclonica=Aclonica, sans-serif;Zeyada=Zeyada, cursive;Indie Flower=Indie Flower, cursive;Miltonian=Miltonian, cursive;MedievalSharp=MedievalSharp, cursive;Delius Unicase=Delius Unicase, cursive;Miltonian Tattoo=Miltonian Tattoo, cursive;Pacifico=Pacifico, cursive;Homemade Apple=Homemade Apple, cursive;Modern Antiqua=Modern Antiqua, cursive';*/
	
	$opt['theme_advanced_fonts'] = 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;Abel=Abel, sans-serif;Abril Fatface=Abril Fatface, cursive;Aclonica=Aclonica, sans-serif;Actor=Actor, sans-serif;Adamina=Adamina, serif;Aldrich=Aldrich, sans-serif;Alice=Alice, serif;Alike Angular=Alike Angular, serif;Alike=Alike, serif;Allan=Allan, cursive;Allerta Stencil=Allerta Stencil, sans-serif;Allerta=Allerta, sans-serif;Amaranth=Amaranth, sans-serif;Amatic SC=Amatic SC, cursive;Andada=Andada, serif;Andika=Andika, sans-serif;Annie Use Your Telescope=Annie Use Your Telescope, cursive;Anonymous Pro=Anonymous Pro, sans-serif;Antic=Antic, sans-serif;Anton=Anton, sans-serif;Arapey=Arapey, serif;Architects Daughter=Architects Daughter, cursive;Arimo=Arimo, sans-serif;Artifika=Artifika, serif;Arvo=Arvo, serif;Asset=Asset, cursive;Astloch=Astloch, cursive;Atomic Age=Atomic Age, cursive;Aubrey=Aubrey, cursive;Bangers=Bangers, cursive;Bentham=Bentham, serif;Bevan=Bevan, serif;Bigshot One=Bigshot One, cursive;Bitter=Bitter, serif;Black Ops One=Black Ops One, cursive;Bowlby One SC=Bowlby One SC, sans-serif;Bowlby One=Bowlby One, sans-serif;Brawler=Brawler, serif;Buda=Buda, sans-serif;Butcherman Caps=Butcherman Caps, cursive;Cabin Sketch=Cabin Sketch, cursive;Cabin=Cabin, sans-serif;Calligraffitti=Calligraffitti, cursive;Candal=Candal, sans-serif;Cantarell=Cantarell, sans-serif;Cardo=Cardo, serif;Carme=Carme, sans-serif;Carter One=Carter One, sans-serif;Caudex=Caudex, serif;Cedarville Cursive=Cedarville Cursive, cursive;Changa One=Changa One, cursive;Cherry Cream Soda=Cherry Cream Soda, cursive;Chewy=Chewy, cursive;Chivo=Chivo, sans-serif;Coda Caption=Coda Caption, sans-serif;Coda=Coda, cursive;Comfortaa=Comfortaa, cursive;Coming Soon=Coming Soon, cursive;Contrail One=Contrail One, cursive;Convergence=Convergence, sans-serif;Cookie=Cookie, cursive;Copse=Copse, serif;Corben=Corben, cursive;Cousine=Cousine, sans-serif;Coustard=Coustard, serif;Covered By Your Grace=Covered By Your Grace, cursive;Crafty Girls=Crafty Girls, cursive;Creepster Caps=Creepster Caps, cursive;Crimson Text=Crimson Text, serif;Crushed=Crushed, cursive;Cuprum=Cuprum, sans-serif;Damion=Damion, cursive;Dancing Script=Dancing Script, cursive;Dawning of a New Day=Dawning of a New Day, cursive;Days One=Days One, sans-serif;Delius Swash Caps=Delius Swash Caps, cursive;Delius Unicase=Delius Unicase, cursive;Delius=Delius, cursive;Didact Gothic=Didact Gothic, sans-serif;Dorsa=Dorsa, sans-serif;Droid Sans Mono=Droid Sans Mono, sans-serif;Droid Sans=Droid Sans, sans-serif;Droid Serif=Droid Serif, serif;Eater Caps=Eater Caps, cursive;EB Garamond=EB Garamond, serif;Expletus Sans=Expletus Sans, cursive;Fanwood Text=Fanwood Text, serif;Federant=Federant, cursive;Federo=Federo, sans-serif;Fjord One=Fjord One, serif;Fontdiner Swanky=Fontdiner Swanky, cursive;Forum=Forum, cursive;Francois One=Francois One, sans-serif;Gentium Basic=Gentium Basic, serif;Gentium Book Basic=Gentium Book Basic, serif;Geo=Geo, sans-serif;Geostar Fill=Geostar Fill, cursive;Geostar=Geostar, cursive;Give You Glory=Give You Glory, cursive;Gloria Hallelujah=Gloria Hallelujah, cursive;Goblin One=Goblin One, cursive;Gochi Hand=Gochi Hand, cursive;Goudy Bookletter 1911=Goudy Bookletter 1911, serif;Gravitas One=Gravitas One, cursive;Gruppo=Gruppo, sans-serif;Hammersmith One=Hammersmith One, sans-serif;Holtwood One SC=Holtwood One SC, serif;Homemade Apple=Homemade Apple, cursive;IM Fell Double Pica SC=IM Fell Double Pica SC, serif;IM Fell Double Pica=IM Fell Double Pica, serif;IM Fell DW Pica SC=IM Fell DW Pica SC, serif;IM Fell DW Pica=IM Fell DW Pica, serif;IM Fell English SC=IM Fell English SC, serif;IM Fell English=IM Fell English, serif;IM Fell French Canon SC=IM Fell French Canon SC, serif;IM Fell French Canon=IM Fell French Canon, serif;IM Fell Great Primer SC=IM Fell Great Primer SC, serif;IM Fell Great Primer=IM Fell Great Primer, serif;Inconsolata=Inconsolata, sans-serif;Indie Flower=Indie Flower, cursive;Irish Grover=Irish Grover, cursive;Istok Web=Istok Web, sans-serif;Jockey One=Jockey One, sans-serif;Josefin Sans=Josefin Sans, sans-serif;Josefin Slab=Josefin Slab, serif;Judson=Judson, serif;Julee=Julee, cursive;Jura=Jura, sans-serif;Just Another Hand=Just Another Hand, cursive;Just Me Again Down Here=Just Me Again Down Here, cursive;Kameron=Kameron, serif;Kelly Slab=Kelly Slab, cursive;Kenia=Kenia, sans-serif;Kranky=Kranky, cursive;Kreon=Kreon, serif;Kristi=Kristi, cursive;La Belle Aurore=La Belle Aurore, cursive;Lancelot=Lancelot, cursive;Lato=Lato, sans-serif;League Script=League Script, cursive;Leckerli One=Leckerli One, cursive;Lekton=Lekton, sans-serif;Limelight=Limelight, cursive;Linden Hill=Linden Hill, serif;Lobster Two=Lobster Two, cursive;Lobster=Lobster, cursive;Lora=Lora, serif;Love Ya Like A Sister=Love Ya Like A Sister, cursive;Loved by the King=Loved by the King, cursive;Luckiest Guy=Luckiest Guy, cursive;Maiden Orange=Maiden Orange, cursive;Mako=Mako, sans-serif;Marck Script=Marck Script, cursive;Marvel=Marvel, sans-serif;Mate SC=Mate SC, serif;Mate=Mate, serif;Maven Pro=Maven Pro, sans-serif;Meddon=Meddon, cursive;MedievalSharp=MedievalSharp, cursive;Megrim=Megrim, cursive;Merienda One=Merienda One, cursive;Merriweather=Merriweather, serif;Metrophobic=Metrophobic, sans-serif;Michroma=Michroma, sans-serif;Miltonian Tattoo=Miltonian Tattoo, cursive;Miltonian=Miltonian, cursive;Modern Antiqua=Modern Antiqua, cursive;Molengo=Molengo, sans-serif;Monofett=Monofett, cursive;Monoton=Monoton, cursive;Montez=Montez, cursive;Mountains of Christmas=Mountains of Christmas, cursive;Muli=Muli, sans-serif;Neucha=Neucha, cursive;Neuton=Neuton, serif;News Cycle=News Cycle, sans-serif;Nixie One=Nixie One, cursive;Nobile=Nobile, sans-serif;Nosifer Caps=Nosifer Caps, cursive;Nothing You Could Do=Nothing You Could Do, cursive;Nova Cut=Nova Cut, cursive;Nova Flat=Nova Flat, cursive;Nova Mono=Nova Mono, cursive;Nova Oval=Nova Oval, cursive;Nova Round=Nova Round, cursive;Nova Script=Nova Script, cursive;Nova Slim=Nova Slim, cursive;Nova Square=Nova Square, cursive;Numans=Numans, sans-serif;Nunito=Nunito, sans-serif;Old Standard TT=Old Standard TT, serif;Open Sans Condensed=Open Sans Condensed, sans-serif;Open Sans=Open Sans, sans-serif;Orbitron=Orbitron, sans-serif;Oswald=Oswald, sans-serif;Over the Rainbow=Over the Rainbow, cursive;Ovo=Ovo, serif;Pacifico=Pacifico, cursive;Passero One=Passero One, cursive;Patrick Hand=Patrick Hand, cursive;Paytone One=Paytone One, sans-serif;Permanent Marker=Permanent Marker, cursive;Petrona=Petrona, serif;Philosopher=Philosopher, sans-serif;Pinyon Script=Pinyon Script, cursive;Play=Play, sans-serif;Playfair Display=Playfair Display, serif;Podkova=Podkova, serif;Poller One=Poller One, cursive;Poly=Poly, serif;Pompiere=Pompiere, cursive;Prata=Prata, serif;Prociono=Prociono, serif;PT Sans Caption=PT Sans Caption, sans-serif;PT Sans Narrow=PT Sans Narrow, sans-serif;PT Sans=PT Sans, sans-serif;PT Serif Caption=PT Serif Caption, serif;PT Serif=PT Serif, serif;Puritan=Puritan, sans-serif;Quattrocento Sans=Quattrocento Sans, sans-serif;Quattrocento=Quattrocento, serif;Questrial=Questrial, sans-serif;Quicksand=Quicksand, sans-serif;Radley=Radley, serif;Raleway=Raleway, cursive;Rammetto One=Rammetto One, cursive;Rancho=Rancho, cursive;Rationale=Rationale, sans-serif;Redressed=Redressed, cursive;Reenie Beanie=Reenie Beanie, cursive;Rochester=Rochester, cursive;Rock Salt=Rock Salt, cursive;Rokkitt=Rokkitt, serif;Rosario=Rosario, sans-serif;Ruslan Display=Ruslan Display, cursive;Salsa=Salsa, cursive;Sancreek=Sancreek, cursive;Sansita One=Sansita One, cursive;Satisfy=Satisfy, cursive;Schoolbell=Schoolbell, cursive;Shadows Into Light=Shadows Into Light, cursive;Shanti=Shanti, sans-serif;Short Stack=Short Stack, cursive;Sigmar One=Sigmar One, sans-serif;Six Caps=Six Caps, sans-serif;Slackey=Slackey, cursive;Smokum=Smokum, cursive;Smythe=Smythe, cursive;Sniglet=Sniglet, cursive;Snippet=Snippet, sans-serif;Sorts Mill Goudy=Sorts Mill Goudy, serif;Special Elite=Special Elite, cursive;Spinnaker=Spinnaker, sans-serif;Stardos Stencil=Stardos Stencil, cursive;Sue Ellen Francisco=Sue Ellen Francisco, cursive;Sunshiney=Sunshiney, cursive;Supermercado One=Supermercado One, cursive;Swanky and Moo Moo=Swanky and Moo Moo, cursive;Syncopate=Syncopate, sans-serif;Tangerine=Tangerine, cursive;Tenor Sans=Tenor Sans, sans-serif;Terminal Dosis=Terminal Dosis, sans-serif;The Girl Next Door=The Girl Next Door, cursive;Tienne=Tienne, serif;Tinos=Tinos, serif;Tulpen One=Tulpen One, cursive;Ubuntu Condensed=Ubuntu Condensed, sans-serif;Ubuntu Mono=Ubuntu Mono, sans-serif;Ubuntu=Ubuntu, sans-serif;Ultra=Ultra, serif;UnifrakturCook=UnifrakturCook, cursive;UnifrakturMaguntia=UnifrakturMaguntia, cursive;Unkempt=Unkempt, cursive;Unna=Unna, serif;Varela Round=Varela Round, sans-serif;Varela=Varela, sans-serif;Vast Shadow=Vast Shadow, cursive;Vibur=Vibur, cursive;Vidaloka=Vidaloka, serif;Volkhov=Volkhov, serif;Vollkorn=Vollkorn, serif;Voltaire=Voltaire, sans-serif;VT323=VT323, cursive;Waiting for the Sunrise=Waiting for the Sunrise, cursive;Wallpoet=Wallpoet, cursive;Walter Turncoat=Walter Turncoat, cursive;Wire One=Wire One, sans-serif;Yanone Kaffeesatz=Yanone Kaffeesatz, sans-serif;Yellowtail=Yellowtail, cursive;Yeseva One=Yeseva One, serif;Zeyada=Zeyada, cursive';
	
	//font size
	//$opt['theme_advanced_font_sizes'] = '10px,12px,14px,16px,24px';
	//default foreground color
	//$opt['theme_advanced_default_foreground_color'] = '#000000';
	//default background color
	//$opt['theme_advanced_default_background_color'] = '#FFFFFF';
	//$opt['content_css'] = 'http://fonts.googleapis.com/css?family=Aclonica,http://fonts.googleapis.com/css?family=Michroma,http://fonts.googleapis.com/css?family=Paytone+One,http://fonts.googleapis.com/css?family=Permanent+Marker,http://fonts.googleapis.com/css?family=Unkempt,http://fonts.googleapis.com/css?family=Julee,http://fonts.googleapis.com/css?family=Rammetto+One,http://fonts.googleapis.com/css?family=Yeseva+One,http://fonts.googleapis.com/css?family=Irish+Grover,http://fonts.googleapis.com/css?family=The+Girl+Next+Door,http://fonts.googleapis.com/css?family=Bitter,http://fonts.googleapis.com/css?family=Eater+Caps,http://fonts.googleapis.com/css?family=Waiting+for+the+Sunrise,http://fonts.googleapis.com/css?family=Rancho,http://fonts.googleapis.com/css?family=Sancreek,http://fonts.googleapis.com/css?family=Leckerli+One,http://fonts.googleapis.com/css?family=Zeyada,http://fonts.googleapis.com/css?family=Indie+Flower,http://fonts.googleapis.com/css?family=Miltonian,http://fonts.googleapis.com/css?family=MedievalSharp,http://fonts.googleapis.com/css?family=Delius+Unicase,http://fonts.googleapis.com/css?family=Miltonian+Tattoo,http://fonts.googleapis.com/css?family=Pacifico,http://fonts.googleapis.com/css?family=Homemade+Apple,http://fonts.googleapis.com/css?family=Modern+Antiqua';
	
	$opt['content_css'] = 'http://fonts.googleapis.com/css?family=Questrial,http://fonts.googleapis.com/css?family=Astloch,http://fonts.googleapis.com/css?family=IM+Fell+English+SC,http://fonts.googleapis.com/css?family=Lekton,http://fonts.googleapis.com/css?family=Nova+Round,http://fonts.googleapis.com/css?family=Nova+Oval,http://fonts.googleapis.com/css?family=League+Script,http://fonts.googleapis.com/css?family=Caudex,http://fonts.googleapis.com/css?family=IM+Fell+DW+Pica,http://fonts.googleapis.com/css?family=Nova+Script,http://fonts.googleapis.com/css?family=Nixie+One,http://fonts.googleapis.com/css?family=IM+Fell+DW+Pica+SC,http://fonts.googleapis.com/css?family=Puritan,http://fonts.googleapis.com/css?family=Prociono,http://fonts.googleapis.com/css?family=Abel,http://fonts.googleapis.com/css?family=Snippet,http://fonts.googleapis.com/css?family=Kristi,http://fonts.googleapis.com/css?family=Mako,http://fonts.googleapis.com/css?family=Ubuntu+Mono,http://fonts.googleapis.com/css?family=Nova+Slim,http://fonts.googleapis.com/css?family=Patrick+Hand,http://fonts.googleapis.com/css?family=Crafty+Girls,http://fonts.googleapis.com/css?family=Brawler,http://fonts.googleapis.com/css?family=Droid+Sans,http://fonts.googleapis.com/css?family=Geostar,http://fonts.googleapis.com/css?family=Yellowtail,http://fonts.googleapis.com/css?family=Permanent+Marker,http://fonts.googleapis.com/css?family=Just+Another+Hand,http://fonts.googleapis.com/css?family=Unkempt,http://fonts.googleapis.com/css?family=Jockey+One,http://fonts.googleapis.com/css?family=Lato,http://fonts.googleapis.com/css?family=Arvo,http://fonts.googleapis.com/css?family=Cabin,http://fonts.googleapis.com/css?family=Playfair+Display,http://fonts.googleapis.com/css?family=Crushed,http://fonts.googleapis.com/css?family=Asset,http://fonts.googleapis.com/css?family=Sue+Ellen+Francisco,http://fonts.googleapis.com/css?family=Julee,http://fonts.googleapis.com/css?family=Judson,http://fonts.googleapis.com/css?family=Neuton,http://fonts.googleapis.com/css?family=Sorts+Mill+Goudy,http://fonts.googleapis.com/css?family=Mate,http://fonts.googleapis.com/css?family=News+Cycle,http://fonts.googleapis.com/css?family=Michroma,http://fonts.googleapis.com/css?family=Lora,http://fonts.googleapis.com/css?family=Give+You+Glory,http://fonts.googleapis.com/css?family=Rammetto+One,http://fonts.googleapis.com/css?family=Pompiere,http://fonts.googleapis.com/css?family=PT+Sans,http://fonts.googleapis.com/css?family=Andika,http://fonts.googleapis.com/css?family=Cabin+Sketch,http://fonts.googleapis.com/css?family=Delius+Swash+Caps,http://fonts.googleapis.com/css?family=Coustard,http://fonts.googleapis.com/css?family=Cherry+Cream+Soda,http://fonts.googleapis.com/css?family=Maiden+Orange,http://fonts.googleapis.com/css?family=Syncopate,http://fonts.googleapis.com/css?family=PT+Sans+Narrow,http://fonts.googleapis.com/css?family=Montez,http://fonts.googleapis.com/css?family=Short+Stack,http://fonts.googleapis.com/css?family=Poller+One,http://fonts.googleapis.com/css?family=Tinos,http://fonts.googleapis.com/css?family=Philosopher,http://fonts.googleapis.com/css?family=Neucha,http://fonts.googleapis.com/css?family=Gravitas+One,http://fonts.googleapis.com/css?family=Corben,http://fonts.googleapis.com/css?family=Istok+Web,http://fonts.googleapis.com/css?family=Federo,http://fonts.googleapis.com/css?family=Yeseva+One,http://fonts.googleapis.com/css?family=Petrona,http://fonts.googleapis.com/css?family=Arimo,http://fonts.googleapis.com/css?family=Irish+Grover,http://fonts.googleapis.com/css?family=Quicksand,http://fonts.googleapis.com/css?family=Paytone+One,http://fonts.googleapis.com/css?family=Kelly+Slab,http://fonts.googleapis.com/css?family=Nova+Flat,http://fonts.googleapis.com/css?family=Vast+Shadow,http://fonts.googleapis.com/css?family=Ubuntu,http://fonts.googleapis.com/css?family=Smokum,http://fonts.googleapis.com/css?family=Ruslan+Display,http://fonts.googleapis.com/css?family=La+Belle+Aurore,http://fonts.googleapis.com/css?family=Federant,http://fonts.googleapis.com/css?family=Podkova,http://fonts.googleapis.com/css?family=IM+Fell+French+Canon,http://fonts.googleapis.com/css?family=PT+Serif+Caption,http://fonts.googleapis.com/css?family=The+Girl+Next+Door,http://fonts.googleapis.com/css?family=Artifika,http://fonts.googleapis.com/css?family=Marck+Script,http://fonts.googleapis.com/css?family=Droid+Sans+Mono,http://fonts.googleapis.com/css?family=Contrail+One,http://fonts.googleapis.com/css?family=Swanky+and+Moo+Moo,http://fonts.googleapis.com/css?family=Wire+One,http://fonts.googleapis.com/css?family=Tenor+Sans,http://fonts.googleapis.com/css?family=Nova+Mono,http://fonts.googleapis.com/css?family=Josefin+Sans,http://fonts.googleapis.com/css?family=Bitter,http://fonts.googleapis.com/css?family=Supermercado+One,http://fonts.googleapis.com/css?family=PT+Serif,http://fonts.googleapis.com/css?family=Limelight,http://fonts.googleapis.com/css?family=Coda+Caption:800,http://fonts.googleapis.com/css?family=Lobster,http://fonts.googleapis.com/css?family=Gentium+Basic,http://fonts.googleapis.com/css?family=Atomic+Age,http://fonts.googleapis.com/css?family=Mate+SC,http://fonts.googleapis.com/css?family=Eater+Caps,http://fonts.googleapis.com/css?family=Bigshot+One,http://fonts.googleapis.com/css?family=Kreon,http://fonts.googleapis.com/css?family=Rationale,http://fonts.googleapis.com/css?family=Sniglet:800,http://fonts.googleapis.com/css?family=Smythe,http://fonts.googleapis.com/css?family=Waiting+for+the+Sunrise,http://fonts.googleapis.com/css?family=Gochi+Hand,http://fonts.googleapis.com/css?family=Reenie+Beanie,http://fonts.googleapis.com/css?family=Kameron,http://fonts.googleapis.com/css?family=Anton,http://fonts.googleapis.com/css?family=Holtwood+One+SC,http://fonts.googleapis.com/css?family=Schoolbell,http://fonts.googleapis.com/css?family=Tulpen+One,http://fonts.googleapis.com/css?family=Redressed,http://fonts.googleapis.com/css?family=Ovo,http://fonts.googleapis.com/css?family=Shadows+Into+Light,http://fonts.googleapis.com/css?family=Rokkitt,http://fonts.googleapis.com/css?family=Josefin+Slab,http://fonts.googleapis.com/css?family=Passero+One,http://fonts.googleapis.com/css?family=Copse,http://fonts.googleapis.com/css?family=Walter+Turncoat,http://fonts.googleapis.com/css?family=Sigmar+One,http://fonts.googleapis.com/css?family=Convergence,http://fonts.googleapis.com/css?family=Gloria+Hallelujah,http://fonts.googleapis.com/css?family=Fontdiner+Swanky,http://fonts.googleapis.com/css?family=Tienne,http://fonts.googleapis.com/css?family=Calligraffitti,http://fonts.googleapis.com/css?family=UnifrakturCook:700,http://fonts.googleapis.com/css?family=Tangerine,http://fonts.googleapis.com/css?family=Days+One,http://fonts.googleapis.com/css?family=Cantarell,http://fonts.googleapis.com/css?family=IM+Fell+Great+Primer,http://fonts.googleapis.com/css?family=Antic,http://fonts.googleapis.com/css?family=Muli,http://fonts.googleapis.com/css?family=Monofett,http://fonts.googleapis.com/css?family=Just+Me+Again+Down+Here,http://fonts.googleapis.com/css?family=Geostar+Fill,http://fonts.googleapis.com/css?family=Candal,http://fonts.googleapis.com/css?family=Cousine,http://fonts.googleapis.com/css?family=Merienda+One,http://fonts.googleapis.com/css?family=Goblin+One,http://fonts.googleapis.com/css?family=Monoton,http://fonts.googleapis.com/css?family=Ubuntu+Condensed,http://fonts.googleapis.com/css?family=EB+Garamond,http://fonts.googleapis.com/css?family=Droid+Serif,http://fonts.googleapis.com/css?family=Lancelot,http://fonts.googleapis.com/css?family=Cookie,http://fonts.googleapis.com/css?family=Fjord+One,http://fonts.googleapis.com/css?family=Arapey,http://fonts.googleapis.com/css?family=Rancho,http://fonts.googleapis.com/css?family=Sancreek,http://fonts.googleapis.com/css?family=Butcherman+Caps,http://fonts.googleapis.com/css?family=Salsa,http://fonts.googleapis.com/css?family=Amatic+SC,http://fonts.googleapis.com/css?family=Creepster+Caps,http://fonts.googleapis.com/css?family=Chivo,http://fonts.googleapis.com/css?family=Linden+Hill,http://fonts.googleapis.com/css?family=Nosifer+Caps,http://fonts.googleapis.com/css?family=Marvel,http://fonts.googleapis.com/css?family=Alice,http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister,http://fonts.googleapis.com/css?family=Pinyon+Script,http://fonts.googleapis.com/css?family=Stardos+Stencil,http://fonts.googleapis.com/css?family=Leckerli+One,http://fonts.googleapis.com/css?family=Nothing+You+Could+Do,http://fonts.googleapis.com/css?family=Sansita+One,http://fonts.googleapis.com/css?family=Poly,http://fonts.googleapis.com/css?family=Alike,http://fonts.googleapis.com/css?family=Fanwood+Text,http://fonts.googleapis.com/css?family=Bowlby+One+SC,http://fonts.googleapis.com/css?family=Actor,http://fonts.googleapis.com/css?family=Terminal+Dosis,http://fonts.googleapis.com/css?family=Aclonica,http://fonts.googleapis.com/css?family=Gentium+Book+Basic,http://fonts.googleapis.com/css?family=Rosario,http://fonts.googleapis.com/css?family=Satisfy,http://fonts.googleapis.com/css?family=Sunshiney,http://fonts.googleapis.com/css?family=Aubrey,http://fonts.googleapis.com/css?family=Jura,http://fonts.googleapis.com/css?family=Ultra,http://fonts.googleapis.com/css?family=Zeyada,http://fonts.googleapis.com/css?family=Changa+One,http://fonts.googleapis.com/css?family=Varela,http://fonts.googleapis.com/css?family=Black+Ops+One,http://fonts.googleapis.com/css?family=Open+Sans,http://fonts.googleapis.com/css?family=Alike+Angular,http://fonts.googleapis.com/css?family=Prata,http://fonts.googleapis.com/css?family=Bowlby+One,http://fonts.googleapis.com/css?family=Megrim,http://fonts.googleapis.com/css?family=Damion,http://fonts.googleapis.com/css?family=Coda,http://fonts.googleapis.com/css?family=Vidaloka,http://fonts.googleapis.com/css?family=Radley,http://fonts.googleapis.com/css?family=Indie+Flower,http://fonts.googleapis.com/css?family=Over+the+Rainbow,http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,http://fonts.googleapis.com/css?family=Abril+Fatface,http://fonts.googleapis.com/css?family=Miltonian,http://fonts.googleapis.com/css?family=Delius,http://fonts.googleapis.com/css?family=Six+Caps,http://fonts.googleapis.com/css?family=Francois+One,http://fonts.googleapis.com/css?family=Dorsa,http://fonts.googleapis.com/css?family=Aldrich,http://fonts.googleapis.com/css?family=Buda:300,http://fonts.googleapis.com/css?family=Rochester,http://fonts.googleapis.com/css?family=Allerta,http://fonts.googleapis.com/css?family=Bevan,http://fonts.googleapis.com/css?family=Wallpoet,http://fonts.googleapis.com/css?family=Quattrocento,http://fonts.googleapis.com/css?family=Dancing+Script,http://fonts.googleapis.com/css?family=Amaranth,http://fonts.googleapis.com/css?family=Unna,http://fonts.googleapis.com/css?family=PT+Sans+Caption,http://fonts.googleapis.com/css?family=Geo,http://fonts.googleapis.com/css?family=Quattrocento+Sans,http://fonts.googleapis.com/css?family=Oswald,http://fonts.googleapis.com/css?family=Carme,http://fonts.googleapis.com/css?family=Spinnaker,http://fonts.googleapis.com/css?family=MedievalSharp,http://fonts.googleapis.com/css?family=Nova+Square,http://fonts.googleapis.com/css?family=IM+Fell+French+Canon+SC,http://fonts.googleapis.com/css?family=Voltaire,http://fonts.googleapis.com/css?family=Raleway:100,http://fonts.googleapis.com/css?family=Delius+Unicase,http://fonts.googleapis.com/css?family=Shanti,http://fonts.googleapis.com/css?family=Expletus+Sans,http://fonts.googleapis.com/css?family=Crimson+Text,http://fonts.googleapis.com/css?family=Nunito,http://fonts.googleapis.com/css?family=Numans,http://fonts.googleapis.com/css?family=Hammersmith+One,http://fonts.googleapis.com/css?family=Miltonian+Tattoo,http://fonts.googleapis.com/css?family=Allerta+Stencil,http://fonts.googleapis.com/css?family=Vollkorn,http://fonts.googleapis.com/css?family=Pacifico,http://fonts.googleapis.com/css?family=Cedarville+Cursive,http://fonts.googleapis.com/css?family=Cardo,http://fonts.googleapis.com/css?family=Merriweather,http://fonts.googleapis.com/css?family=Loved+by+the+King,http://fonts.googleapis.com/css?family=Slackey,http://fonts.googleapis.com/css?family=Nova+Cut,http://fonts.googleapis.com/css?family=Rock+Salt,http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz,http://fonts.googleapis.com/css?family=Molengo,http://fonts.googleapis.com/css?family=Nobile,http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911,http://fonts.googleapis.com/css?family=Bangers,http://fonts.googleapis.com/css?family=Old+Standard+TT,http://fonts.googleapis.com/css?family=Orbitron,http://fonts.googleapis.com/css?family=Comfortaa,http://fonts.googleapis.com/css?family=Varela+Round,http://fonts.googleapis.com/css?family=Forum,http://fonts.googleapis.com/css?family=Maven+Pro,http://fonts.googleapis.com/css?family=Volkhov,http://fonts.googleapis.com/css?family=Allan:700,http://fonts.googleapis.com/css?family=Luckiest+Guy,http://fonts.googleapis.com/css?family=Gruppo,http://fonts.googleapis.com/css?family=Cuprum,http://fonts.googleapis.com/css?family=Anonymous+Pro,http://fonts.googleapis.com/css?family=UnifrakturMaguntia,http://fonts.googleapis.com/css?family=Covered+By+Your+Grace,http://fonts.googleapis.com/css?family=Homemade+Apple,http://fonts.googleapis.com/css?family=Lobster+Two,http://fonts.googleapis.com/css?family=Coming+Soon,http://fonts.googleapis.com/css?family=Mountains+of+Christmas,http://fonts.googleapis.com/css?family=Architects+Daughter,http://fonts.googleapis.com/css?family=Dawning+of+a+New+Day,http://fonts.googleapis.com/css?family=Kranky,http://fonts.googleapis.com/css?family=Adamina,http://fonts.googleapis.com/css?family=Carter+One,http://fonts.googleapis.com/css?family=Bentham,http://fonts.googleapis.com/css?family=IM+Fell+Great+Primer+SC,http://fonts.googleapis.com/css?family=Chewy,http://fonts.googleapis.com/css?family=IM+Fell+English,http://fonts.googleapis.com/css?family=Inconsolata,http://fonts.googleapis.com/css?family=Vibur,http://fonts.googleapis.com/css?family=Andada,http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica,http://fonts.googleapis.com/css?family=Kenia,http://fonts.googleapis.com/css?family=Meddon,http://fonts.googleapis.com/css?family=Metrophobic,http://fonts.googleapis.com/css?family=Play,http://fonts.googleapis.com/css?family=Special+Elite,http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica+SC,http://fonts.googleapis.com/css?family=Didact+Gothic,http://fonts.googleapis.com/css?family=Modern+Antiqua,http://fonts.googleapis.com/css?family=VT323,http://fonts.googleapis.com/css?family=Annie+Use+Your+Telescope';
	
	return $opt;
		
	}
	add_filter('tiny_mce_before_init', 'josh_stbu_custom_options');

?>