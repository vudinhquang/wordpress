<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<style>
#zendvn-mp-info{
	background-color: white;
	min-height: 300px;
	border: solid 1px #ccc;
	padding: 10px;
}
</style>
		<div id="container">
			<div id="content" role="main">
			<div id="zendvn-mp-info">
				<ul>
					<li>get_calendar()		: <?php get_calendar();?> </li>
				</ul>
			</div>
			<?php
			/*
			 * Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			get_template_part( 'loop', 'index' );
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
