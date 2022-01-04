<div class="flex flex-col justify-center items-center pl-6 pr-6 max-w-full">

    <div>
        <h2 class="text-white font-extrabold text-center text-xl">Extra Virgin Olive Oil</h2>

        <p class="pt-4 font-normal text-left text-white text-sm">In Greece more and more olive oil producers are changing their olive groves from conventional to organic. In organic olive oil farming, no chemical fertilizers or pesticides are used at any stage of production, harvesting is done by hand or mechanized harvest machines, while olive oil is produced by cold extraction at low temperatures to ensure the best, most natural and safest result.</p>

        <h3 class="pt-8 text-white font-bold text-left text-lg">Daily Treasure</h3>
    </div>

    <div>
        <div class="flex justify-start items-center overflow-hidden">
            <!-- Loop Products -->
            <?php

                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'product_cat'    => 'gifts'
                );

                $loop = new WP_Query( $args );

                    while ( $loop->have_posts() ) : $loop->the_post();
                        global $product;
                        // print_r($product);
                        $price = floatval($product->get_price());
                        ?>
                            <a class="pt-6 w-48" href="<?php echo $product->get_permalink(); ?>">
                                <div>
                                    <div>
                                        <?php echo woocommerce_get_product_thumbnail(); ?>
                                    </div>
                                    <h2 class="font-normal text-sm text-white text-center pt-3"> <?php echo get_the_title(); ?></h2>
                                    <p class="text-gainsboro font-bold text-sm text-center pt-1"> <?php echo number_format($price, 2, ',', '').' '.get_woocommerce_currency_symbol("EUR"); ?> </p>
                                </div>
                            </a>
                        <?php
                        // echo '<br /><a class="text-white" href="'.$product->get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().' '.$product->get_price().'</a>';
                    endwhile;

                    wp_reset_query();
            ?>
        </div>
    </div>

    <!-- Other Products -->
    <div class="pt-20 w-full">
        <div>
            <h2 class="text-light-gray font-bold text-lg text-left">More Products from Oliorama</h2>
        <div>
        <div class="rounded-xl bg-oliorama-honey bg-cover w-full pt-4 pb-40 mt-5">
            <h3 class="text-white font-bold text-xl text-center">Oliorama Olive Oil</h3>
        </div>
        <div class="rounded-xl bg-oliorama-honey bg-cover w-full pt-4 pb-40 mt-5">
            <h3 class="text-white font-bold text-xl text-center">Oliorama Honey</h3>
        </div>
    </div>
</div>