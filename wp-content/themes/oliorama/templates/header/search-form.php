<section id="search-form" class="fixed h-full overflow-scroll lg:h-4/6 w-full bg-gray-wolf top-0 left-0 pr-8 pl-8 hidden">

    <div class="w-full flex justify-center items-center pt-14">
        <!-- Search Form -->
        <div class="w-4/5">
            <form class="w-full" method="POST" action="https://oliorama.com/">
                <label for="s" class="hidden">Search product</label>
                <input
                    id="auto-search"
                    class="w-full h-8 bg-transparent border-0 text-white font-normal text-2xl focus-visible:shadow-none focus-visible:border-0 focus-visible:ring-0" 
                    type="text" 
                    name="s" 
                    onkeyup="" 
                    placeholder="Search..." 
                    autocomplete="off"
                />
                <input type="hidden" type="product" />
            </form>
        </div>
        <!-- X Button -->
        <div class="flex justify-center items-center w-1/5 " onclick="emptySearch()">
            <?php get_template_part( 'templates/svg/x-icon' ); ?>        
        </div>
    </div>

    <!-- Autocomplete -->
    <div>
    </div>

    <!-- Suggestions -->
    <div class="w-full mt-52">

        <!-- line -->
        <div class="border-dark-gray border-2"></div>
        
        <div class="pt-11">
            <h2 class="font-normal text-gray-cloud text-base">Suggestions</h2>
        </div>
        
        <!-- Best Sellers -->
        <div class="pt-10 max-w-full flex justify-start items-center overflow-hidden">
            <!-- <div class="flex justify-center items-center overflow-scroll"> -->
            <?php

                $args = array(
                    'post_type' => 'product',
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'posts_per_page' => 7,
                );

                $loop = new WP_Query( $args );

                while ( $loop->have_posts() ) : $loop->the_post(); 

                global $product;
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
            <?php endwhile; ?>
            <!-- </div> -->
            <?php wp_reset_query(); ?>
        </div>
    </div>

    <!-- Close Button -->
    <div class="flex justify-center items-center mt-10 pb-20">
        <div onclick="closeSearch()" class="close w-16 h-16 rounded-full flex justify-center items-center bg-carbon-gray hover:bg-dim-gray focus:bg-dark-gray cursor-pointer">
            <?php get_template_part( 'templates/svg/x-icon' ); ?>
        </div>
    </div>

</section>