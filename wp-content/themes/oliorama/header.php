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
	<link rel="icon" type="image/png" href="wp-content/uploads/2021/11/favicon-light.png">

	<!-- scripts -->
	<script type="text/javascript">
		// Open navigation
		function openNav(){
			document.getElementById('nav').classList.remove('hidden');
		}

		// Close navigation
		function closeNav(){
			document.getElementById('nav').classList.add('hidden');
		}
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"></a>

	<?php get_template_part( 'templates/header/site-header' ); ?>
	<?php get_template_part( 'templates/header/site-menu' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
