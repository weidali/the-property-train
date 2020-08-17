<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>
                    
                    <h2><?php the_title() ?></h2>
                    <?php
                     if ( has_post_thumbnail()) {
                       $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                       echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" target="blank">';
                       the_post_thumbnail('thumbnail');
                       echo '</a>';
                     }
                     ?>
                    
                    <!-- Выводим текст поста в теге div. -->
            		<div class="entry">
            		   <?php the_content(); ?>
            		</div>
					<?php understrap_post_nav(); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
					
					<hr>
					<h3>Обявления в этом городе</h3>
					
					<div class="row row-cols-md-3">	
			<?php 
           $posts = get_posts( array(
            	'post_type'   => 'nedvizhimost',
            	'publish' => true,
            ) );
            
            foreach( $posts as $post ){
            	setup_postdata($post);
                  
                $cost = get_post_meta( get_the_ID(), 'object_cost', true);
                $address = get_post_meta( get_the_ID(), 'address_field', true);
            ?>
            <div class="col mb-4">
                    <div class="card h-100">
                        <?php if ( has_post_thumbnail()) { ?>
                       <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                       <?php the_post_thumbnail('post-thumbnail', array('width' => '100%', 'class' => "bd-placeholder-img", 'alt'   => trim(strip_tags( $wp_postmeta->_wp_attachment_image_alt )), 'role' => "img", )); ?>
                       </a>
                       <?php } 
                       else {?>
                       <svg class="bd-placeholder-img card-img-top" width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" role="img"><rect width="100%" height="100%" fill="#868e96"></rect><text x="10%" y="50%" fill="#dee2e6" dy=".3em">&#x2612; Нет фотографии</text></svg>
                      <?php } ?>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?=$address;?></li>
                      </ul>
                      <div class="card-body">
                        <h5 class="card-title"><?php the_title();?></h5>
                        <small class="text-muted">Размещено: <?php the_date(); ?></small>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                      </div>
                      <div class="card-footer">
                          <p class="card-text text-info"><?=number_format_i18n((int)$cost);?>₽</p>
                        </div>
                    </div>
                </div>
            <?php 
                
            }
            wp_reset_postdata(); // сброс
            
            ?>
			</div>
					

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
