<!-- Header -->
<?php get_header(); ?>

<div class="bg-davys-gray pt-12 pl-4 pr-4 pb-10">

    <?php

        // Olive Oil
        if( is_page(47) ){
            get_template_part('templates/pages/olive_oil');
        }

        if( is_page(51) ){
            get_template_part('templates/pages/honey');
        }
    ?>
    
</div>
    
<!-- Footer -->
<?php get_footer(); ?>