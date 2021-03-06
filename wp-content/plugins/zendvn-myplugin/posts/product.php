<?php
class Zendvn_Mp_Cp_Product{
	
	public function __construct(){
        // echo '<br/>' . __METHOD__;
        add_action('init', array($this,'create'));
        add_filter('pre_get_posts', array($this,'show_home'));
        add_filter( 'post_updated_messages', array($this,'zproduct_updated_messages'));
        add_filter( 'bulk_post_updated_messages', array($this,'filter_bulk_zproduct_updated_messages'), 10, 2  ); 

        add_filter('template_include', array($this,'load_template'));
    }

	public  function load_template($template_file){
		global $wp;
        /*
        echo __FUNCTION__;
		echo '<br/>' . $template_file;
		echo '<br/>' . $wp->query_vars['post_type'];
        echo '<br/>' . is_archive(); 
        */
		if(is_single()){
			
			if(isset($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == 'zproduct'){
				$file = ZENDVN_MP_CP_DIR . '/templates/loop-zproduct.php';
				if(file_exists($file)){
					$template_file = $file;
				}
			}
        }
        
		if(is_archive()){
				
			if(isset($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == 'zproduct'){
				$file = ZENDVN_MP_CP_DIR . '/templates/list-zproduct.php';
				if(file_exists($file)){
					$template_file = $file;
				}
			}
		}
		
		return $template_file;
	}

	public function show_home($query){
		
		if(is_home() && $query->is_main_query()){
			$query->set('post_type',array('post','zproduct'));
		}
		
		return $query;
	}
    
    public function create() {
		$labels = array(
            'name' 				=> __('Books'),
            'singular_name' 	=> __('Books'),
            'menu_name'			=> __('ZBooks'),
            'name_admin_bar' 	=> __('ZBooks'),
            'add_new'			=> __('Add Books'),
            'add_new_item'		=> __('Add New Books'),
            'search_items' 		=> __('Search Books'),
            'not_found'			=> __('No books found.'),
            'not_found_in_trash'=> __('No books found in Trash'),
            'view_item' 		=> __('View book'),
            'item_updated ' 	=> __('View book'),
            'edit_item'			=> __('Edit book'),
        );
		$args = array(
            'labels'               => $labels,
            'description'          => 'Hiển thị nội dung mô tả về phần Custom Post',
            'public'               => true,
            'hierarchical'         => true,
    		'exclude_from_search'  => null, //public
    		'publicly_queryable'   => null, //public
    		'show_ui'              => null, //public
    		'show_in_menu'         => null, 
            'show_in_nav_menus'    => true, //public
            'show_in_admin_bar'    => true, //public
            'menu_position'        => 5,
            'menu_icon'            => ZENDVN_MP_IMAGES_URL . '/icon-setting16x16.png',
            'capability_type'      => 'post',
            // 'capabilities'         => array(),
            //'map_meta_cap'         => null,
            'supports'             => array('title' ,'editor','author','thumbnail','excerpt','trackbacks' ,'custom-fields' ,'comments','revisions' ,'page-attributes','post-formats'),
            //'register_meta_box_cb' => null,
            'taxonomies'           => array('book-category'),
            'has_archive'          => true,
            'rewrite'              => array('slug'=>'zproduct'),
            //'query_var'            => true,
            //'can_export'           => true,
            //'delete_with_user'     => null,
            //'_builtin'             => false,
            '_edit_link'           => 'post.php?post=%d',
        );
        register_post_type('zproduct',$args);
        // flush_rewrite_rules(false);
    }

    function zproduct_updated_messages ( $messages ) {
        $preview_post_link_html   = '';
        $scheduled_post_link_html = '';
        $view_post_link_html      = '';
        $post             = get_post();
        $post_type        = get_post_type( $post );
        $post_type_object = get_post_type_object( $post_type );
        
        $permalink = get_permalink( $post->ID );
        if ( ! $permalink ) {
            $permalink = '';
        }

        $preview_url = get_preview_post_link( $post );
        $viewable = is_post_type_viewable( $post_type_object );
        if ( $viewable ) {
            // Preview post link.
            $preview_post_link_html = sprintf(
                ' <a target="_blank" href="%1$s">%2$s</a>',
                esc_url( $preview_url ),
                __( 'Preview post' )
            );
            // Scheduled post preview link.
            $scheduled_post_link_html = sprintf(
                ' <a target="_blank" href="%1$s">%2$s</a>',
                esc_url( $permalink ),
                __( 'Preview post' )
            );
            // View post link.
            $view_post_link_html = sprintf(
                ' <a href="%1$s">%2$s</a>',
                esc_url( $permalink ),
                __( 'View product' )
            );
        }

        $scheduled_date = sprintf(
            /* translators: Publish box date string. 1: Date, 2: Time. */
            __( '%1$s at %2$s' ),
            /* translators: Publish box date format, see https://www.php.net/date */
            date_i18n( _x( 'M j, Y', 'publish box date format' ), strtotime( $post->post_date ) ),
            /* translators: Publish box time format, see https://www.php.net/date */
            date_i18n( _x( 'H:i', 'publish box time format' ), strtotime( $post->post_date ) )
        );
        
        $messages['zproduct'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => __( 'Product updated.' ) . $view_post_link_html,
            2  => __( 'Custom field updated.' ),
            3  => __( 'Custom field deleted.'),
            4  => __( 'Product updated.' ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Product restored to revision from %s.' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => __( 'Product published.' ) . $view_post_link_html,
            7  => __( 'Product saved.' ),
            8  => __( 'Product saved.' ) . $preview_post_link_html,
            9  => sprintf( __( 'Post scheduled for: %s.' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_post_link_html,
            10 => __( 'Product draft updated.' ) . $preview_post_link_html,
        );

        return $messages;
    }

    function filter_bulk_zproduct_updated_messages( $bulk_messages, $bulk_counts ) { 
        $bulk_messages['zproduct']     = array(
            /* translators: %s: Number of pages. */
            'updated'   => _n( '%s product updated.', '%s products updated.', $bulk_counts['updated'] ),
            'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 product not updated, somebody is editing it.' ) :
                            /* translators: %s: Number of products. */
                            _n( '%s product not updated, somebody is editing it.', '%s products not updated, somebody is editing them.', $bulk_counts['locked'] ),
            /* translators: %s: Number of products. */
            'deleted'   => _n( '%s product permanently deleted.', '%s products permanently deleted.', $bulk_counts['deleted'] ),
            /* translators: %s: Number of products. */
            'trashed'   => _n( '%s product moved to the Trash.', '%s products moved to the Trash.', $bulk_counts['trashed'] ),
            /* translators: %s: Number of products. */
            'untrashed' => _n( '%s product restored from the Trash.', '%s products restored from the Trash.', $bulk_counts['untrashed'] ),
        );
        return $bulk_messages; 
    }

}