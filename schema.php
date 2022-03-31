<?php if ( has_shortcode($post->post_content, 'faqs') ) : ?>

            <?php
            /* FAQS SCHEMA */
            $faq_loop = new WP_Query( array(
                'post_type' => 'faq',
                'post_status'=>'publish',
                'posts_per_page' => -1,
                'id' => $post->ID
            ) );
            // recent faq for MainEntity
            $recent_faq = wp_get_recent_posts(array(
                'numberposts' => 1,
                'post_status' => 'publish',
                'post_type' => 'faq'
            ));

            $comma = ',';
            $num_count = 0;
            ?>

            <?php if ( $faq_loop->have_posts() ) : ?>
                    <!-- FAQS -->
                    <script type="application/ld+json">
                        {
                        <?php foreach( $recent_faq as $last ) : ?>
                            "@context": "https://schema.org",
                            "@type": "FAQPage",
                            "mainEntity": [{
                                "@type": "Question",
                                "name": "<?php echo strip_tags($last['post_content']) ?>",
                                "acceptedAnswer": {
                                    "@type": "Answer",
                                    "text": "<?php echo $last['post_title'] ?>"
                                }
                            }
                        <?php endforeach; ?>

                        <?php while ( $faq_loop->have_posts() ) : $faq_loop->the_post(); ?>

                            <?php $singleFaq =  '{
                                "@type": "Question",
                                "name": "'.strip_tags(get_the_title()).'",
                                "acceptedAnswer": {
                                    "@type": "Answer",
                                    "text": "'.strip_tags(get_the_content()).'"
                                }
                            }';

                            $num_count = $num_count + 1;

                            if ($num_count <= 5) {
                                echo ", ";
                            }

                            ?>


                            <?php echo $singleFaq ?>

                        <?php endwhile; //faq_loop ?>
                            ]
                        }
                    </script>

             <?php endif; //have_post check ?>

<?php endif; //check if this page has faq ?>
