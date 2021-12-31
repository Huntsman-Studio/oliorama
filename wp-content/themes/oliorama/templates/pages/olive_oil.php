<div class="flex flex-col justify-center items-center pl-6 pr-6">

    <h2 class="text-white font-extrabold text-xl">Extra Virgin Olive Oil</h2>

    <p class="pt-4 font-normal text-left text-white text-sm">In Greece more and more olive oil producers are changing their olive groves from conventional to organic. In organic olive oil farming, no chemical fertilizers or pesticides are used at any stage of production, harvesting is done by hand or mechanized harvest machines, while olive oil is produced by cold extraction at low temperatures to ensure the best, most natural and safest result.</p>

    <!-- Loop Products -->
    <?php

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'product_cat'    => 'olive-oil'
        );

        $loop = new WP_Query( $args );

            while ( $loop->have_posts() ) : $loop->the_post();
                global $product;
                // print_r($product);
                ?>

                <?php
                echo '<br /><a href="'.$product->get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().' '.$product->get_price().'</a>';
            endwhile;

            wp_reset_query();
    ?>
</div>