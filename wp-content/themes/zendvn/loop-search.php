<?php global $zendvnSupport; ?>

<div class="clr" id="blog-wrap">
<?php
    $i = 1;
?>
<?php while (have_posts()): the_post(); ?>
<?php
    $col = ($i%2) ? 1 : 2;
    $col = 'col-' . $col;
    $i ++;
?>
    <article class="clr loop-entry <?php echo $col; ?>">
        <div class="loop-entry-media clr">
            <?php
                $width = 620;
                $height = 350;
                $feature_img = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                if($feature_img == false){
                    $imgUrl = $zendvnSupport->get_img_url($post->post_content); 
                }else{
                    $imgUrl = $feature_img;
                }
                if(!empty($imgUrl)){
                    $imgUrl = $zendvnSupport->get_new_img_url($imgUrl, $width, $height);	
                }
            ?>
            <figure class="loop-entry-thumbnail">
                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                    <div class="post-thumbnail">
                        <img width="620" height="350" alt="<?php the_title(); ?>" 
                            src="<?php echo $imgUrl; ?>">
                    </div>
                    <!-- .post-thumbnail -->
                </a>
            </figure>
            <!-- .loop-entry-thumbnail -->
        </div>
        <!-- .loop-entry-media -->
        <div class="loop-entry-content clr">
            <header>
                <h2 class="loop-entry-title">
                    <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="loop-entry-meta clr">
                    <div class="loop-entry-meta-date">
                        <span class="fa fa-clock-o"></span><?php the_modified_date(); ?>
                    </div>
                    <div class="loop-entry-meta-comments">
                        <span class="fa fa-comments"></span>
                        <a title="<?php the_title(); ?>" href="<?php comments_link(); ?>"><?php comments_number('No comment', 'one comment', '% comments'); ?></a>
                    </div>
                </div>
                <!-- .loop-entry-meta -->
            </header>
            <div class="loop-entry-excerpt entry clr">
                <?php echo mb_substr(get_the_excerpt(), 0, 200) . '...'; ?>
            </div>
            <!-- .loop-entry-excerpt -->
        </div>
        <!-- .loop-entry-content -->
    </article>
    <!-- .loop-entry -->
    <?php endwhile; ?>
</div>
<!-- #blog-wrap -->
<?php include_once ZENDVN_THEME_DIR . '/paging.php'; ?>
<div class="ad-spot archive-bottom-ad clr">
    <a title="Ad" href="#">
        <img alt="Ad" src="http://wordpress.xyz/wp-content/themes/zendvn/images/ad-620x80.png" width="620" height="80" />
    </a>
</div>
<!-- .ad-spot -->
         