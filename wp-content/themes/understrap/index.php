<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
			
			<hr class="featurette-divider">    
			<h3>Недавно размещённые</h3>
			
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
                        <li class="d-inline col list-group-item"><small><?php the_terms( get_the_ID(), 'location', '&#10144; ', '', ', ' ); ?></small><?=$address;?></li>
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
			
			<hr class="featurette-divider">
			<div>
			    <h3>Города</h3>
			    
			    <div class="row row-cols-md-3">
			<?php
			    global $post;
			    $cities = get_posts( array(
            	    'post_type'   => 'cities_post',
            	    'publish' => true,
            ) );
            
            foreach( $cities as $post ){
                setup_postdata($post);
            ?>


            <?php // the_meta();?>
                  <div class="col mb-4">
                    <div class="card h-100">
                      <?php if ( has_post_thumbnail()) { ?>
                       <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                       <?php the_post_thumbnail('post-thumbnail', array('width' => '100%', 'class' => "bd-placeholder-img", 'alt'   => trim(strip_tags( $wp_postmeta->_wp_attachment_image_alt )), 'role' => "img", 'focusable' => "false", )); ?>
                       </a>
                       <?php } 
                       else {?>
                      <svg class="bd-placeholder-img card-img-top" width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" role="img"><rect width="100%" height="100%" fill="#868e96"></rect><text x="10%" y="50%" fill="#dee2e6" dy=".3em">&#x2612; Нет фотографии</text></svg>
                      <?php } ?>
                      <div class="card-body">
                        <h5 class="card-title"><?php the_title();?></h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                      </div>
                    </div>
                  </div>
                  <?php 
            }
            wp_reset_postdata(); // сброс
            ?>
                </div>
    
          <hr class="featurette-divider">
          <div class="card">
            <div class="card-header">
                Сортировка <span class="text-muted">(в разработке)</span></div>
  <div class="card-body">

<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
  <div class="form-group col-md-8">
      <?php
        if( $terms = get_terms( 'tip_nedvizhimosti', 'orderby=name' ) ) :
    	    echo '<select name="categoryfilter" class="form-control"><option>Выберите тип недвижимости...</option>';
        	foreach ($terms as $term) :
        		echo '<option value="' . $term->term_id . '" >' . $term->name . '</option>';
        	endforeach;
        	echo '</select>';
        endif;
        ?>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <input type="text" name="cena_min" class="form-control" placeholder="Минимальная цена" >
    </div>
    <div class="form-group col-md-4">
      <input type="text" name="cena_max" class="form-control" placeholder="Максимальная цена" >
    </div>
  </div>
  <fieldset class="form-group">
    <div class="row">
      <div class="col-sm-8">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="date" id="gridRadios1" value="ASC" >
          <label class="form-check-label" for="gridRadios1">
            Дата: по возрастанию
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="date" id="gridRadios2" value="DESC" checked >
          <label class="form-check-label" for="gridRadios2">
            Дата: по убыванию
          </label>
        </div>
      </div>
    </div>
  </fieldset>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Только с миниатюрой
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Применить фильтр</button>
</form>
</div>
</div>
            
			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
			<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
			

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
