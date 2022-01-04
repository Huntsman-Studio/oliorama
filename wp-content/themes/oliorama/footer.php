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
			<div class="pb-16 lg:grid lg:justify-items-center">
				<?php get_template_part( 'templates/footer/footer-logo' ); ?>
			</div>

			<!-- Footer Navigatiom -->
			<div class="flex justify-center items-center">
				<?php get_template_part( 'templates/footer/footer-nav' ); ?>
			</div>

			<!-- line -->
			<div class="border border-dark-gray border-solid mt-10 w-ful lg:hidden"></div>

			<!-- social icons -->
			<div class="lg:flex hidden justify-center items-center gap-5">
				<!-- facebook -->
				<button class="bg-black rounded-full w-10 h-10 text-white" onclick="window.open('https://www.facebook.com', '_blank');">
					f
				</button>
				<!-- instagram -->
				<button class="bg-black rounded-full w-10 h-10 text-white" onclick="window.open('https://www.instagram.com', '_blank');">
					i
				</button>
				<!-- linkedin -->
				<button class="bg-black rounded-full w-10 h-10 text-white" onclick="window.open('https://www.facebook.com', '_blank');">
					in
				</button>
			</div>

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
