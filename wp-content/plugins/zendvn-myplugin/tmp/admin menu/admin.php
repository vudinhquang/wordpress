<?php
require_once ZENDVN_MP_PLUGIN_DIR . '/includes/support.php';
class ZendvnMpAdmin {

	public function __construct(){
        // echo '<br>' . __METHOD__;
        // add_action('admin_menu', array($this,'settingMenu'));
        // add_action('admin_menu', array($this,'settingMenu2'));
        // add_action('admin_menu', array($this,'settingMenu3'));
        add_action('admin_menu', array($this,'settingMenu4'));
        // add_action('admin_menu', array($this,'removeMenu'));
    }
    
	//=======================================================
	//1. Them mot submenu vao Dashboard cua WP menus
	//=======================================================
	public function settingMenu(){
		$menuSlug = 'zendvn-mp-my-setting';
		add_posts_page('My Setting title', 'My Setting', 'manage_options', 
							$menuSlug, array($this,'settingPage'));
    }
    
	//=======================================================
	//2. Them mot nhom menu moi vao he thong menu WP
	//=======================================================
	public function settingMenu2(){
		$menuSlug = 'zendvn-mp-my-setting';		
		add_menu_page('My Setting title', 'My Setting', 'manage_options',
                        $menuSlug,array($this,'settingPage'),
                        ZENDVN_MP_IMAGES_URL . '/icon-setting16x16.png');
                        
        add_menu_page('My Setting 2 title', 'My Setting 2', 'manage_options',
						$menuSlug . '-2',array($this,'settingPage'));
    }
    
	//=======================================================
	//3. Them mot nhom menu moi vao he thong menu WP
	//=======================================================
	public function settingMenu3(){
		$menuSlug = 'zendvn-mp-my-setting';
		add_menu_page('My Setting title', 'My Setting', 'manage_options',
						$menuSlug,array($this,'settingPage'),
						ZENDVN_MP_IMAGES_URL . '/icon-setting16x16.png');
		
		add_submenu_page($menuSlug, "About title", "About", 'manage_options', 
						$menuSlug . '-about',array($this,'aboutPage'));
						
		add_submenu_page($menuSlug, "Help title", "Help", 'manage_options',
						$menuSlug . '-help',array($this,'helpPage'));
	
    }
    
	//=======================================================
	//4. Them mot nhom menu moi vao vi tri bat ky
	//=======================================================
	public function settingMenu4(){
		$menuSlug = 'zendvn-mp-my-setting';
		add_menu_page('My Setting title', 'My Setting', 'manage_options',
						$menuSlug,array($this,'settingPage'),
						ZENDVN_MP_IMAGES_URL . '/icon-setting16x16.png',1);
	
		add_submenu_page($menuSlug, "About title", "About", 'manage_options',
		$menuSlug . '-about',array($this,'aboutPage'));
	
		add_submenu_page($menuSlug, "Help title", "Help", 'manage_options',
		$menuSlug . '-help',array($this,'helpPage'));
	
    }
    
	//=======================================================
	//5. Xoa bo cac menu trong he thong menu cua WP
	//=======================================================
	public function removeMenu(){
		$menuSlug = 'zendvn-mp-my-setting';
		remove_submenu_page( $menuSlug, $menuSlug . '-about' );
		remove_menu_page( $menuSlug );
		
		remove_submenu_page( 'edit.php', 'post-new.php');
		remove_menu_page( 'edit.php' );
	
    }
    	
	public function settingPage(){
		require ZENDVN_MP_VIEWS_DIR . '/setting-page.php';
    }
    
	public function aboutPage(){
		require ZENDVN_MP_VIEWS_DIR . '/about-page.php';
    }

	public function helpPage(){
		require ZENDVN_MP_VIEWS_DIR . '/help-page.php';
	}
    
}