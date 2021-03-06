<?php
class Zendvn_Theme_Widget_Main {

    private $_widget_options = array();

	public function __construct(){
		$this->_widget_options = array(
                    'searchForm' 	=> true,
                    'social' 		=> true,
                    'tabs' 			=> true,
					'sliders'		=> true,
					'last_posts'	=> true,
                );
        
        foreach ($this->_widget_options as $key => $val){	
            if($val == true){
                add_action('widgets_init',array($this,$key));
            }
        }
	}
	
	public function last_posts(){
		require_once ZENDVN_THEME_WIDGET_DIR . '/last_post.php';
		register_widget('Zendvn_Theme_Widget_LastPost');
	}

	public function sliders(){
		require_once ZENDVN_THEME_WIDGET_DIR . '/sliders.php';
		register_widget('Zendvn_Theme_Widget_Sliders');
	}
    
	public function searchForm(){
		require_once ZENDVN_THEME_WIDGET_DIR . '/searchForm.php';
		register_widget('Zendvn_Theme_Widget_SearchForm');
    }
    
	public function social(){
		require_once ZENDVN_THEME_WIDGET_DIR . '/social.php';
		register_widget('Zendvn_Theme_Widget_Social');
    }
    
	public function tabs(){
		require_once ZENDVN_THEME_WIDGET_DIR . '/tabs.php';
		register_widget('Zendvn_Theme_Widget_Tabs');
	}
}