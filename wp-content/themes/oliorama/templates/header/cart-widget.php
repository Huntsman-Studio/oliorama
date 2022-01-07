<section id="cart-widget" class="fixed z-50 w-full lg:w-2/5 h-full overflow-scroll top-0 right-0 bg-gray-wolf pl-6 pr-6 pt-10 pb-16 hidden">
    
    <div class="flex justify-between items-center w-full pb-16">
        <div>
            <p class="text-gray-goose font-normal text-sm">Cart(<?php echo WC()->cart->cart_contents_count; ?>)</p>
        </div>
        <div >
            <div onclick="closeCart()" id="cart-icon-x" class="rounded-full w-16 h-16 bg-carbon-gray hover:bg-dim-gray focus:bg-dark-gray cursor-pointer flex justify-center items-center">
                <?php get_template_part('templates/svg/x-icon'); ?>
            </div>
        </div>
    </div>

    <?php
        // if cart is empty
        if(WC()->cart->is_empty()){
            ?>
                <div class="w-full grid justify-center">
                    <h2 class="text-white fon-bold text-xl">Your cart is empty...</h2>
                    <div class="olive-cart flex justify-center items-center mt-16 rounded-full w-52 h-52">
                        <?php get_template_part('templates/svg/olive-icon'); ?>
                    </div>
                </div>
            <?php
        } else {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $product = $cart_item['data'];
                $product_id = $cart_item['product_id'];
                $quantity = $cart_item['quantity'];
                $price = WC()->cart->get_product_price( $product );
                $subtotal = WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] );
                $link = $product->get_permalink( $cart_item );
                // $attributes = $product->getAttributeText('liter');
                // $attributes  = $cart_item['variation']['liter'];
                
                // json_encode($product);
                // $data = json_decode(json_encode($product),true);

                // echo "<p class='text-white'>".$data.['attributes'].['pa_liter']."</p>";
                ?>
                    <div class="flex items-center gap-5">
                        <!-- Image -->
                        <div class="grid w-3/12">
                            <a href="<?php echo $product->get_permalink(); ?>">
                                <div class="bg-dark-gray flex justify-center items-center w-24 h-24 rounded-xl p-2">
                                    <?php echo $product->get_image(); ?>
                                </div>
                            </a>
                        </div>
                        <!-- Details -->
                        <div class="grid w-6/12">
                            <h5 class="text-white font-normal text-base"><?php echo $product->get_title(); ?></h5>
                        </div>
                        <!-- Remove -->
                        <div class="grid w-3/12">
                            <p class="text-white font-bold text-base"><?php echo $product->get_price_html(); ?></p>
                        </div>
                    </div>
                <?php
            }
        }
    ?>

    <!-- Widget footer -->
    <div class="fixed bottom-0 left-0 w-full lg:w-2/5 pr-6 pl-6 pb-10">
        <div class="border-t-2 border-dim-gray"></div>
        <div class="flex justify-between items-center pt-6">
            <div>
                <p class="text-gray-goose font-normal text-sm">Subtotal</p>
            </div>
            <div>
                <p class="text-white font-bold text-2xl">
                    <?php echo WC()->cart->get_cart_subtotal(); ?>
                </p>
            </div>
        </div>
        <div class="w-full pt-9 flex justify-center">
            <button onclick="closeCart()" class="bg-white pt-4 pb-4 pl-14 pr-14 text-black font-bold text-base rounded-full">Close Tab</button>
        </div>
    </div>

</section>