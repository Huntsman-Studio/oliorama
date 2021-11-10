<!-- Header -->
<?php get_header(); ?>

<div class="bg-davys-gray">

    <!-- Page Content -->
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

        <?php the_content()?>

    <?php endwhile; else : endif; ?>

    <?php if(is_page('Shop'))  get_template_part( 'templates/pages/test_page' ); ?>
    
</div>
    
<!-- Footer -->
<?php get_footer(); ?>