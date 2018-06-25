<footer id="composer-footer">
	<?php echo FFBLANK()->view->load_composer_layout( 'footer' ); ?>
</footer>

<footer id="footer">
	<div class="footer4 b-t spacer">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 m-b-30">
					
					<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
				
				</div>
				<div class="col-lg-3 col-md-6 m-b-30">
					
					<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
				
				</div>
				<div class="col-lg-3 col-md-6 m-b-30">
					
					<?php dynamic_sidebar( 'sidebar-footer-3' ); ?>
				
				</div>
				<div class="col-lg-3 col-md-6">
					
					<?php dynamic_sidebar( 'sidebar-footer-4' ); ?>
				
				</div>
			</div>
			<div id="bottom-bar" class="f4-bottom-bar">
				<div class="row">
					<div class="col-md-12">
						<div class="d-flex font-14">
							<div class="m-t-10 m-b-10 copyright"><?php echo \ffblank\helper\utils::get_option( 'bottom_bar_text' ); ?></div>
							<div class="links ml-auto m-t-10 m-b-10">
								
								<?php wp_nav_menu( array(
									'menu'            => 'bottom_bar_menu',
									'theme_location'  => 'bottom_bar_menu',
									'container'       => 'div',
									'container_id'    => 'bottom_bar_menu',
									'container_class' => '',
									'menu_id'         => false,
									'menu_class'      => '',
									'depth'           => 1,
								) ); ?>
							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>