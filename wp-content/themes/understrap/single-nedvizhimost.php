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
	    
	    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Главная</a></li>
    <li class="breadcrumb-item"><a href="">Недвижимость</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
  </ol>
</nav>

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
			    
			    <hr class="featurette-divider">
			    <div class="row featurette">
                  <div class="col-md-7">
                    <h2 class="featurette-heading"><?php the_title(); ?>
                        <span class="text-muted col-6 col-md-4">
                        <small>Цена: <?php number_format_i18n((int)the_field('object_cost')); ?>₽</small></span>
                    </h2>
                    <div class="row justify-content-end">
                        <div class="col-4 text-info">
                              <small>Размещено: <?php the_time('j F Y'); ?></small>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="d-inline col text-muted">
                          <small>Адрес: <?php the_terms( get_the_ID(), 'location', '', '' ); ?> <?php the_field('address_field'); ?></small>
                        </div>
                        <div class="d-inline col text-muted">
                          <small>Этаж: <?php the_field('floor_field'); ?></small>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="d-inline col text-muted">
                          <small>Площадь: <?php the_field('sq_field'); ?></small>
                        </div>
                        <div class="d-inline col text-muted">
                          <small>Жилая площадь: <?php the_field('living_sq'); ?></small>
                        </div>
                    </div>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    
                    <p class="lead"><?php the_content(); ?></p>
                    
                    <?php endwhile; else: ?>
                    
                    <p>Не найдено записей по вашему запросу</p>
                    
                    <?php endif; ?>
                    
                    
                    
                  </div>
                  <div class="col-md-5">
                      
                    <?php the_post_thumbnail( 'oblect-preview', '' ); ?>
                    <!--<svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>-->
                  </div>
                </div>
                <hr class="featurette-divider">
                <p>Тип недвижимости: </p>
                <?php the_terms( get_the_ID(), 'tip_nedvizhimosti', ' • ', '' ); ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
