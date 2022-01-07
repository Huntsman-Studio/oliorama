<?php
/**
 * Displays the site header.
 *
 * @package Oliorama
 * @subpackage Oliorama-Theme
 * @since Oliorama-Theme 1.0
 */
?>

<header class="flex justify-center items-center bg-davys-gray pl-4 pr-4 pt-8 pb-8 lg:pr-16 lg:pl-16 2xl:w-4/5" role="banner">

	<!-- Left -->
	<div class="flex-none w-20">

		<!-- Mobile: Menu -->
		<div onclick="openNav()" class="flex justify-center items-center w-12 h-12 rounded-full bg-white cursor-pointer lg:hidden">
			<svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
				<path class="a" d="M0,0H24V24H0Z"/>
				<line class="b" x2="16" transform="translate(4 8)"/>
				<line class="b" x2="16" transform="translate(4 16)"/>
			</svg>
		</div>

		<!-- Desktop: Logo -->
		<div class="hidden lg:block">
			<?php get_template_part( 'templates/header/logo' ); ?>
		</div>

	</div>

	<!-- Center -->
	<div class="flex-grow">

		<!-- Mobile: Logo -->
		<div class="flex justify-center items-center  lg:hidden">
			<?php get_template_part( 'templates/header/logo' ); ?>
		</div>

		<!-- Desktop: Menu -->
		<div class="lg:flex justify-center items-center hidden">
			<?php get_template_part( 'templates/header/large-menu' ); ?>
		</div>

	</div>

	<!-- Right -->
	<div class="flex-none">
		<div class="flex justify-center items-center gap-7 w-20">

			<!-- search icon -->
			<div>
				<div class="flex justify-center items-center cursor-pointer">
					<?php get_template_part( 'templates/svg/search-icon' ); ?>
				</div>
			</div>

			<!-- basket -->
			<div>
				<div onclick="openCart()" class="flex justify-center items-center rounded-full w-8 h-8 lg:w-10 lg:h-10 bg-opacity-70 bg-carbon-gray">
					<p class="text-gray-cloud font-normal text-base lg:text-xl">
						<?php echo WC()->cart->cart_contents_count ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</header>