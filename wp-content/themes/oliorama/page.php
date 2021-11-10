<!-- Header -->
<?php get_header(); ?>

<!-- Page Content -->
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

    <?php the_content()?>

<?php endwhile; else : endif; ?>
    
<!-- Footer -->
<?php get_footer(); ?>