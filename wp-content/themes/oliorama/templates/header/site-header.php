<?php
/**
 * Displays the site header.
 *
 * @package Oliorama
 * @subpackage Oliorama-Theme
 * @since Oliorama-Theme 1.0
 */
?>

<header class="flex justify-center items-center bg-davys-gray pl-4 pr-4 pt-8 pb-8 lg:pr-16 lg:pl-16" role="banner">

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
		<div class="flex justify-center items-center  lg:hidden">
			<?php get_template_part( 'templates/header/logo' ); ?>
		</div>
	</div>
	<!-- Right -->
	<div class="flex-none">
		<div class="flex justify-center items-center gap-7 w-20">
			<!-- search icon -->
			<div>
				<div class="flex justify-center items-center">
					<svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<path class="a" d="M10.569,0A10.569,10.569,0,1,0,21.138,10.569,10.581,10.581,0,0,0,10.569,0Zm0,19.187a8.618,8.618,0,1,1,8.618-8.618A8.628,8.628,0,0,1,10.569,19.187Z"/>
						<g transform="translate(16.455 16.455)">
							<path class="a" d="M358.3,356.925l-5.594-5.593a.975.975,0,0,0-1.38,1.38l5.593,5.594a.976.976,0,0,0,1.38-1.38Z" transform="translate(-351.046 -351.046)"/>
						</g>
					</svg>
				</div>
			</div>
			<!-- basket -->
			<div>
				<div class="flex justify-center items-center rounded-full w-8 h-8 bg-opacity-70 bg-carbon-gray">
					<p class="text-gray-cloud font-normal text-base">
						<?php echo WC()->cart->cart_contents_count ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</header>