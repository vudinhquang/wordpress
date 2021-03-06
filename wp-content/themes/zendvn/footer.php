	<?php global $zendvnCustomize;?>
	<footer id="footer-wrap" class="site-footer clr">
		<?php require_once ZENDVN_THEME_INC_DIR . '/footer.php';?>
		<!-- #footer -->
		<div id="footer-bottom" class="clr">
			<div class="container clr">
				<div id="copyright" class="clr" role="contentinfo">
					<?php 
						echo $zendvnCustomize->general_setion('copyright');
					?>
				</div>
				<!-- #copyright -->
				<?php require_once ZENDVN_THEME_INC_DIR . '/bottom-menu.php';?>
			</div>
			<!-- .container -->
		</div>
		<!-- #footer-bottom -->
	</footer>
	<!-- #footer-wrap -->

	<a href="#" class="site-scroll-top"><span class="fa fa-arrow-up"></span></a>
	<?php echo wp_footer() ?>
</body>
</html>