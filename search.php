<?php get_header(); ?>

<?php
$categories = get_terms( [ 
	'taxonomy'   => 'danh-muc-nha-dat',
	'hide_empty' => false,
	'parent'     => 0,
	'meta_key'   => 'order',
	'orderby'    => 'meta_value_num',
] );
?>
<section class="list-product">
	<div class="container list-product__wrap">
		<?php if ( have_posts() ) : ?>
			<div class="entries">
				<?php
				global $count;
				$count = 1;
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'bds' );
					$count++;
				}
				?>
			</div>
			<?php
			the_posts_pagination(
				[ 
					'screen_reader_text' => '',
					'mid_size'           => 1,
					'prev_text'          => __( '<', 'bat-dong-san' ),
					'next_text'          => __( '>', 'bat-dong-san' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '', 'bat-dong-san' ) . ' </span>',
				]
			);
			?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content/none' ); ?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>