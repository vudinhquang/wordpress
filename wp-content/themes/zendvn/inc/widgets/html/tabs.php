<div class="wpex-tabs-widget clr">
    <div class="wpex-tabs-widget-inner clr">
        <div class="wpex-tabs-widget-tabs clr">
            <ul>
				<?php if(!empty($instance['popular_title'])):?>
				<li><a href="#" data-tab="#wpex-widget-popular-tab" class="active"><?php echo $instance['popular_title'];?></a></li>
				<?php endif;?>
				
				<?php if(!empty($instance['recent_title'])):?>
				<li><a href="#" data-tab="#wpex-widget-recent-tab"><?php echo $instance['recent_title'];?></a></li>
				<?php endif;?>
				
				<?php if(!empty($instance['comment_title'])):?>
				<li><a href="#" data-tab="#wpex-widget-comments-tab" class="last"><?php echo $instance['comment_title'];?></a></li>
				<?php endif;?>
			</ul>
        </div>

        <!-- .wpex-tabs-widget-tabs -->
        <?php if(!empty($instance['popular_title'])):?>
            <?php 
			$popular_items = ((int)$instance['popular_items']==0)?5:$instance['popular_items'];
			
			$meta_key = 'zendvn_post_views_count';
			
			$args = array(
						'post_type' 		=> 'post',
						'order'				=> 'DESC',
						'posts_per_page' 	=> $popular_items,
						'post_status'		=> 'publish',
						'ignore_sticky_posts'=> true,
						'meta_key'			=> $meta_key,
						'orderby'			=> 'meta_value'
					);
			
			$wpQuery = new WP_Query($args);
			/* echo '<pre>';
			print_r($wpQuery);
			echo '</pre>'; */
			$i = 1;
        ?>
        <?php if($wpQuery->have_posts()):?>
        <div id="wpex-widget-popular-tab"
            class="wpex-tabs-widget-tab active-tab clr">
            <ul class="clr">
            <?php while($wpQuery->have_posts()) : $wpQuery->the_post(); ?>
                <li class="clr">
                    <a href="<?php the_permalink();?>" title="<?php the_title();?>" class="clr">
                        <span class="counter"><?php echo $i; $i++;?></span>
                        <span class="title strong"><?php the_title();?></span> 
                        <?php echo mb_substr(get_the_excerpt(), 0,55) . '...';?>
                    </a>
                </li>
            <?php endwhile;?>
            </ul>
        </div>
        <?php endif;?>
        <?php endif;?>
        <?php wp_reset_postdata();?>	

        <!-- wpex-tabs-widget-tab -->
        <div id="wpex-widget-recent-tab"
            class="wpex-tabs-widget-tab  clr">
            <ul class="clr">
                <li class="clr">
                    <a href="#" title="Formula 1 Is Boring But The Cars Are Super Awesome" class="clr">
                        <img src="http://wordpress.xyz/wp-content/themes/zendvn/files/uploads/2014/02/shutterstock_80791570-100x100.jpg" alt="Formula 1 Is Boring But The Cars Are Super Awesome" width="100" height="100" />
                        <span class="title strong">Formula 1 Is Boring But The Cars Are Super Awesome:</span> Quisque
                        pellentesque fringilla scelerisque. Donec porta urna eu
                        fringilla adipiscing.&hellip;
                    </a>
                </li>
            </ul>
        </div>
        <!-- wpex-tabs-widget-tab -->
        <div id="wpex-widget-comments-tab"
            class="wpex-tabs-widget-tab clr">
            <ul class="clr">
                <li class="clr">
                    <a href="#" title="Homepage" class="clr"> 
                        <img src='http://wordpress.xyz/wp-content/themes/zendvn/files/avatar/1c292955bf55ec6172964107fd325638.png' class="avatar avatar-100 photo" />
                        <span class="title strong">AJ Clarke:</span> Aenean ut blandit lorem. Nullam ut ultrices nulla, non tristique&hellip;&hellip;
                    </a>
                </li>
            </ul>
        </div>
        <!-- .wpex-tabs-widget-tab -->
    </div>
    <!-- .wpex-tabs-widget-inner -->
</div>
<!-- .wpex-tabs-widget -->
