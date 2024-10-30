<?php
/*
Plugin Name: CCG Quickly
Plugin URI: https://ccgos.com/ccg-quickly/
Description: Quickly Access Wordpress Pages from Menu
Version: 1.2.6
Requires at least: 5.2
Author: CCG Online Services
Author URI: http://ccgos.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: ccgquickly
@copyright Copyright (C) 2013 CCG Online Services Limited
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function ccgquickly_add_toolbar_items($admin_bar){
	
	if( is_user_logged_in() ) 
	{
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		//echo print_r($roles);
		//echo $roles[0];

		if ($roles[0]=="administrator") 
		{
			$admin_bar->add_menu( array(
				'id'    => 'ccgos_quickly-item',
				'title' => 'CCG Quickly',
				'href'  => admin_url('tools.php?page=ccgquickly_quickly'),
				'meta'  => array(
					'title' => __('Quickly'),            
				),
			));
			if (get_option('pages_setting')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-pages',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Pages',
					'href'  => admin_url('edit.php?post_type=page'),
					'meta'  => array(
						'title' => __('Pages'),            
					),
				));
			
		
				
				$page_ids= get_all_page_ids();
			   foreach($page_ids as $id)
				{
					$page_title=get_the_title($id);
					$admin_bar->add_menu( array(
						'id'    => get_the_title($id),
						'parent'=> 'ccgos_quickly-item-pages',
						'title' => $page_title,
						'href'  => admin_url('post.php?post='.$id.'&action=edit'),
						
					));
					
					
				}
				
				
			}
			
			if (get_option('ccgquickly_media')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-media',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Media',
					'href'  => admin_url('upload.php'),
					'meta'  => array(
						'title' => __('Media','ccg-quickly'),            
					),
				));
			}
					
			if (get_option('ccgquickly_addmedia')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-add-media',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Add Media',
					'href'  => admin_url('media-new.php'),
					'meta'  => array(
						'title' => __('Add Media','ccg-quickly'),            
					),
				));
			}
							
			if (get_option('ccgquickly_settings')=="yes")
			{				
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-settings',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Settings',
					'href'  => admin_url('options-general.php'),
					'meta'  => array(
						'title' => __('Settings','ccg-quickly'),            
					),
				));
			}
			if (get_option('ccgquickly_post')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-posts',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Posts',
					'href'  => admin_url('edit.php'),
					'meta'  => array(
						'title' => __('Posts','ccg-quickly'),            
					),
				));
			}
			if (get_option('ccgquickly_addpost')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-add-post',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Add Post',
					'href'  => admin_url('post-new.php'),
					'meta'  => array(
						'title' => __('Add Post','ccg-quickly'),            
					),
				));
			}
			if (get_option('ccgquickly_tools')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-tools',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Tools',
					'href'  => admin_url('tools.php'),
					'meta'  => array(
						'title' => __('Tools','ccg-quickly'),            
					),
				));
			}
				
			if (get_option('ccgquickly_users')=="yes")
			{
				$admin_bar->add_menu( array(
					'id'    => 'ccgos_quickly-item-users',
					'parent'=> 'ccgos_quickly-item',
					'title' => 'Users',
					'href'  => admin_url('users.php'),
					'meta'  => array(
						'title' => __('Users','ccg-quickly'),            
					),
				));
			}
			
			if ((get_option('ccgquickly_media')!="yes") and (get_option('ccgquickly_addmedia')!="yes") and (get_option('ccgquickly_settings')!="yes") and (get_option('ccgquickly_post')!="yes") and (get_option('ccgquickly_addpost')!="yes") and (get_option('ccgquickly_tools')!="yes") and (get_option('ccgquickly_users')!="yes"))
			{

			$admin_bar->add_menu( array(
								'id'    => 'ccgos_quickly-item-users',
								'parent'=> 'ccgos_quickly-item',
								'title' => 'Set Settings',
								'href'  => admin_url('tools.php?page=ccgquickly_quickly'),
								'meta'  => array(
									'title' => __('Set Settings','ccgquickly_quickly'),            
								),
							));

			}



		}
	}
}


function ccgquickly_plugin_menu() {
	
	
	add_submenu_page(
		'tools.php', // parent page slug
		'Quickly Settings',
		'CCG Quickly',
		'manage_options',
		'ccgquickly_quickly',
		'ccgquickly_plugin_settings_page',
		0 // menu position
	);
	
}


function ccgquickly_plugin_settings_page() {
	
	//$nonce= wp_nonce_field( 'upadte-preferences_'.$comment_id );
	
?>
<div class="wrap">
<script type="text/javascript">  
function selects(){  

	var element1=document.getElementById('pages_setting').checked=true;  
	var element2=document.getElementById('ccgquickly_media').checked=true;
	var element3=document.getElementById('ccgquickly_addmedia').checked=true;
	var element4=document.getElementById('ccgquickly_settings').checked=true;
	var element5=document.getElementById('ccgquickly_post').checked=true;
	var element6=document.getElementById('ccgquickly_addpost').checked=true;
	var element7=document.getElementById('ccgquickly_tools').checked=true;
	var element8=document.getElementById('ccgquickly_users').checked=true;  
	return false;
}  
function deSelect(){  
	var element1=document.getElementById('pages_setting').checked=false;  
	var element2=document.getElementById('ccgquickly_media').checked=false;
	var element3=document.getElementById('ccgquickly_addmedia').checked=false;
	var element4=document.getElementById('ccgquickly_settings').checked=false;
	var element5=document.getElementById('ccgquickly_post').checked=false;
	var element6=document.getElementById('ccgquickly_addpost').checked=false;
	var element7=document.getElementById('ccgquickly_tools').checked=false;
	var element8=document.getElementById('ccgquickly_users').checked=false;
	return false;
}             
        </script>  
<h1>CCG Quickly</h1>
Select below what you wish to show in the CCG Quickly Menu.<br>
Turning on <i>Show Individual Pages</i> will show a submenu of every Page.<br>
<form method="post" action="options.php">
    <?php settings_fields( 'ccgquickly-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'ccgquickly-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Show Individual Pages</th>
        <td>   
		<?php
		
		if (get_option('pages_setting')=="yes")
		{
			echo ' <input type="checkbox" id="pages_setting" name="pages_setting" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="pages_setting" name="pages_setting" value="yes"  > ';
		}			
		
		
		?>
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">Show Media</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_media')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_media" name="ccgquickly_media" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_media" name="ccgquickly_media" value="yes"  > ';
		}			
		
		
		?>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Add Media</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_addmedia')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_addmedia" name="ccgquickly_addmedia" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_addmedia" name="ccgquickly_addmedia" value="yes"  > ';
		}			
		
		?>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Settings</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_settings')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_settings" name="ccgquickly_settings" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_settings" name="ccgquickly_settings" value="yes"  > ';
		}			
		
		
		?>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Post</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_post')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_post" name="ccgquickly_post" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_post" name="ccgquickly_post" value="yes"  > ';
		}			
		
		
		?>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Add Post</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_addpost')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_addpost" name="ccgquickly_addpost" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_addpost" name="ccgquickly_addpost" value="yes"  > ';
		}			
		
		
		?>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Tools</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_tools')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_tools" name="ccgquickly_tools" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_tools" name="ccgquickly_tools" value="yes"  > ';
		}			
		
		
		?>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Users</th>
        <td>   
		<?php
		
		if (get_option('ccgquickly_users')=="yes")
		{
			echo ' <input type="checkbox" id="ccgquickly_users" name="ccgquickly_users" value="yes" checked > ';
		}
		else
		{
			echo ' <input type="checkbox" id="ccgquickly_users" name="ccgquickly_users" value="yes"  > ';
		}			
		
		
		?>
		</td>
        </tr>
         
        
    </table>
    	<br>
		<a href="#" onclick="selects();">Select All</a> / <a href="#" onclick="deSelect();">Deselect All</a>
		
    <?php submit_button(); ?>
</form>
</div>
<?php 

} 


function ccgquickly__plugin_settings() {
	register_setting( 'ccgquickly-plugin-settings-group', 'pages_setting' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_media' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_addmedia' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_settings' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_post' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_addpost' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_tools' );
	register_setting( 'ccgquickly-plugin-settings-group', 'ccgquickly_users' );
	//register_setting( 'ccgquickly-plugin-settings-group', 'special_enabled' );
}


function ccgquickly_notice() {
	if (isset($_REQUEST['_wpnonce']))
	{
	$nonce_check=wp_verify_nonce( sanitize_text_field(wp_unslash($_REQUEST['_wpnonce'])) );
	if ($nonce_check)
	{
	if( 
		isset( $_GET[ 'page' ] ) 
		&& 'ccgquickly_quickly' == $_GET[ 'page' ]
		&& isset( $_GET[ 'settings-updated' ] ) 
		&& true == $_GET[ 'settings-updated' ]
	) {
		?>
			<div class="notice notice-success is-dismissible">
				<p>
					<strong>CCG Quickly settings saved.</strong>
				</p>
			</div>
		<?php
	}
	}
	}
}



add_action( 'admin_init', 'ccgquickly__plugin_settings' );

add_action( 'admin_notices', 'ccgquickly_notice' );

add_action('admin_menu', 'ccgquickly_plugin_menu');

add_action('admin_bar_menu', 'ccgquickly_add_toolbar_items', 80);



?>