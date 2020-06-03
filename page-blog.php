<?php
/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>
    <style>
    .posts-container {
        grid-template-columns: repeat(2,1fr);
        display: grid;
        align-items: stretch;
        grid-column-gap: 5px;
        grid-row-gap: 5px;
    }

    article.post-grid-item {
        display: flex;
    }

.post-card {
    background-color: #ffffff;
    border: 3px solid #efefef;
    border-radius: 0px;
    padding: 20px;
    width: 100%;
    min-height: 100%;
}

.post-card a {
    color: #DF1C22;
    font-size: 2rem;
    font-weight: 900;
    text-transform: uppercase;
}
.post-card .post-excerpt{
    font-size: 1.25vw;
    font-weight: 300;
    color#777;
}
    </style>
  
<?php
$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );
while ( have_posts() ) : the_post();
get_template_part( 'template-parts/custom-field-parts/page-heading-banner' );

$query = new WP_Query(array(
    'posts_per_page' => 12,
    'paged'=>1
  ));
?>
  <div class="posts-container">
<?php
  while ($query->have_posts()) {
    $query->the_post(); ?>
        <article class="post-grid-item">
            <div class="post-card">
                <div class="post-text">
                    <h2 class="post-title">
                        <a href="<?php echo get_the_permalink();?>"><?php   echo get_the_title(); ?></a>
                    </h2>
                    <div class="post-excerpt">
                        <?php echo get_the_excerpt(); ?>
                    </div>
                </div>
            </div>
        </article>
    <?php 
  } ?>
  </div>
  <div class="pagination">
  <?php 
    $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;
  echo paginate_links(array(
            'base' => '%_%',
            'format' => '?page=%#%',
            'total' => $the_query->max_num_pages,
            'prev_next' => True,
            'prev_text' => __( '<< Previous' ),
            'next_text' => __( 'Next >>' )
        ));
  ?>
  </div> 
  <?php

  wp_reset_postdata();
?>


	<?php
endwhile;
get_footer();
