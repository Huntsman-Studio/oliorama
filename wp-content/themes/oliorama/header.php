<?php
/**
 * Header.
 *
 * @package Oliorama
 * @subpackage Oliorama-Theme
 * @since Oliorama-Theme 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/assets/images/favicon-light.png">

	<!-- scripts -->
	<script type="text/javascript">
		// Open navigation
		function openNav(){
			document.getElementById('nav').classList.remove('hidden');
			document.getElementById('main-body').classList.add('overflow-hidden');
		}

		// Close navigation
		function closeNav(){
			document.getElementById('nav').classList.add('hidden');
			document.getElementById('main-body').classList.remove('overflow-hidden');
		}

		// EmptySearch
		function emptySearch(){
			document.getElementById('auto-search').value = '';
		}

		// OpenSearch
		function openSearch(){
			document.getElementById('search-form').classList.remove('hidden');
			document.getElementById('main-body').classList.add('overflow-hidden');
		}

		// Close Search
		function closeSearch(){
			document.getElementById('search-form').classList.add('hidden');
			document.getElementById('main-body').classList.remove('overflow-hidden');
		}

		// Open Cart
		function openCart(){
			document.getElementById('cart-widget').classList.remove('hidden');
			document.getElementById('main-body').classList.add('overflow-hidden');
		}

		// Close Cart
		function closeCart(){
			document.getElementById('cart-widget').classList.add('hidden');
			document.getElementById('main-body').classList.remove('overflow-hidden');
		}
	</script>
	<?php wp_head(); ?>
</head>

<body id="main-body" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site 2xl:max-w-screen-2xl">
	<a class="skip-link screen-reader-text" href="#content"></a>

	<?php get_template_part( 'templates/header/site-header' ); ?>
	<?php get_template_part( 'templates/header/site-menu' ); ?>
	<?php get_template_part( 'templates/header/search-form' ); ?>
	<?php get_template_part( 'templates/header/cart-widget' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
