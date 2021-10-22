<?php
/**
 * Footer.
 *
 * @package Oliorama
 * @subpackage Oliorama-Theme
 * @since Oliorama-Theme 1.0
 */
?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->
	<footer id="colophon" class="bg-gray-wolf pl-10 pr-10 pt-16 pb-10" role="contentinfo">
        <div class="grid justify-center w-full">
			<!-- logo -->
			<div class="pb-16">
				<?php get_template_part( 'templates/footer/footer-logo' ); ?>
			</div>
			<!-- Footer Navigatiom -->
			<div class="flex justify-center items-center">
				<?php get_template_part( 'templates/footer/footer-nav' ); ?>
			</div>
			<!-- line -->
			<div class="border border-dark-gray border-solid mt-10 w-ful"></div>
			<!-- bottom -->
			<div class="flex justify-center items-center gap-9 pt-14">
				<?php get_template_part( 'templates/footer/bottom-bar' ); ?>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
