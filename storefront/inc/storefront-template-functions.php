<?php
/**
 * Storefront template functions.
 *
 * @package storefront
 */

if ( ! function_exists( 'storefront_display_comments' ) ) {
	/**
	 * Storefront display comments
	 *
	 * @since  1.0.0
	 */
	function storefront_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'storefront_comment' ) ) {
	/**
	 * Storefront comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since 1.0.0
	 */
	function storefront_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-body">
		<div class="comment-meta commentmetadata">
			<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 128 ); ?>
			<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'storefront' ), get_comment_author_link() ); ?>
			</div>
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'storefront' ); ?></em>
				<br />
			<?php endif; ?>

			<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
				<?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
			</a>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-content">
		<?php endif; ?>
		<div class="comment-text">
		<?php comment_text(); ?>
		</div>
		<div class="reply">
		<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		<?php edit_comment_link( __( 'Edit', 'storefront' ), '  ', '' ); ?>
		</div>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
	}
}

if ( ! function_exists( 'storefront_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function storefront_footer_widgets() {
		if ( is_active_sidebar( 'footer-4' ) ) {
			$widget_columns = apply_filters( 'storefront_footer_widget_regions', 4 );
		} elseif ( is_active_sidebar( 'footer-3' ) ) {
			$widget_columns = apply_filters( 'storefront_footer_widget_regions', 3 );
		} elseif ( is_active_sidebar( 'footer-2' ) ) {
			$widget_columns = apply_filters( 'storefront_footer_widget_regions', 2 );
		} elseif ( is_active_sidebar( 'footer-1' ) ) {
			$widget_columns = apply_filters( 'storefront_footer_widget_regions', 1 );
		} else {
			$widget_columns = apply_filters( 'storefront_footer_widget_regions', 0 );
		}

		if ( $widget_columns > 0 ) : ?>

			<div class="footer-widgets col-<?php echo intval( $widget_columns ); ?> fix">
				<div class="footer-section-container">

					<?php
					$i = 0;
					while ( $i < $widget_columns ) : $i++;
						if ( is_active_sidebar( 'footer-' . $i ) ) : ?>

							<div class="block footer-widget-<?php echo intval( $i ); ?>">
								<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
							</div>

						<?php endif;
					endwhile; ?>

				</div>
			</div><!-- /.footer-widgets  -->

		<?php endif;
	}
}

if ( ! function_exists( 'storefront_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_credit() {
		?>
		<div class="site-info">
			<?php //echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' - - ' . date( 'Y' ) ) ); ?>
			<?php if ( apply_filters( 'storefront_credit_link', true ) ) { ?>
			<br /> <?php printf( esc_attr__( '%1$s designed by %2$s.', 'storefront' ), 'Storefront', '<a href="http://www.woocommerce.com" title="WooCommerce - The Best eCommerce Platform for WordPress" rel="author">WooCommerce</a>' ); ?>
			<?php } ?>
		</div><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'storefront_header_widget_region' ) ) {
	/**
	 * Display header widget region
	 *
	 * @since  1.0.0
	 */
	function storefront_header_widget_region() {
		if ( is_active_sidebar( 'header-1' ) ) {
		?>
		<div class="header-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'header-1' ); ?>
			</div>
		</div>
		<?php
		}
	}
}

if ( ! function_exists( 'storefront_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_site_branding() {
		?>
		<div class="kp-site-branding -site-branding -1">
			<?php storefront_site_title_or_logo(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'storefront_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @since 2.1.0
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function storefront_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
		} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			// Copied from jetpack_the_site_logo() function.
			$logo    = site_logo()->logo;
			$logo_id = get_theme_mod( 'custom_logo' ); // Check for WP 4.5 Site Logo
			$logo_id = $logo_id ? $logo_id : $logo['id']; // Use WP Core logo if present, otherwise use Jetpack's.
			$size    = site_logo()->theme_size();
			$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image(
					$logo_id,
					$size,
					false,
					array(
						'class'     => 'site-logo attachment-' . $size,
						'data-size' => $size,
						'itemprop'  => 'logo'
					)
				)
			);

			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
		} else {
			$tag = is_home() ? 'h1' : 'div';

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html;
	}
}

if ( ! function_exists( 'storefront_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
					)
			);

			wp_nav_menu(
				array(
					'theme_location'	=> 'handheld',
					'container_class'	=> 'handheld-navigation',
					)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'storefront_secondary_navigation' ) ) {
	/**
	 * Display Secondary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_secondary_navigation() {
	    if ( has_nav_menu( 'secondary' ) ) {
		    ?>
		    <nav class="secondary-navigation" role="navigation" aria-label="<?php esc_html_e( 'Secondary Navigation', 'storefront' ); ?>">
			    <?php
				    wp_nav_menu(
					    array(
						    'theme_location'	=> 'secondary',
						    'fallback_cb'		=> '',
					    )
				    );
			    ?>
		    </nav><!-- #site-navigation -->
		    <?php
		}
	}
}

if ( ! function_exists( 'storefront_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @since  1.4.1
	 * @return void
	 */
	function storefront_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'storefront' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'storefront' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'storefront_page_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function storefront_page_header() {
		?>
		<header class="entry-header">
			<?php
			storefront_post_thumbnail( 'full' );
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'storefront_page_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function storefront_page_content() {
		?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'storefront_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function storefront_post_header() {
		?>
		<header class="entry-header">
		<?php
      	the_title( '<h1 class="kp-entry-title --entry-title">', '</h1>' );
      // Mihail update 05-10-19
		/*if ( is_single() ) {
			storefront_posted_on();
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			if ( 'post' == get_post_type() ) {
				storefront_posted_on();
			}

			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}*/
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'storefront_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function storefront_post_content() {
		?>
		<div class="kp-entry-content --entry-content">
		<?php

		/**
		 * Functions hooked in to storefront_post_content_before action.
		 *
		 * @hooked storefront_post_thumbnail - 10
		 */
		do_action( 'storefront_post_content_before' );

      // Mihail update 05-10-19
		/*the_content(
			sprintf(
				__( 'Continue reading %s', 'storefront' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);*/
      	the_content();
      	echo '<a href="/feedback/">Оставить отзыв</>';

		do_action( 'storefront_post_content_after' );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'storefront_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0.0
	 */
	function storefront_post_meta() {
		?>
		<aside class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search.

			?>
			<div class="author">
				<?php
					echo get_avatar( get_the_author_meta( 'ID' ), 128 );
					echo '<div class="label">' . esc_attr( __( 'Written by', 'storefront' ) ) . '</div>';
					the_author_posts_link();
				?>
			</div>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'storefront' ) );

			if ( $categories_list ) : ?>
				<div class="cat-links">
					<?php
					echo '<div class="label">' . esc_attr( __( 'Posted in', 'storefront' ) ) . '</div>';
					echo wp_kses_post( $categories_list );
					?>
				</div>
			<?php endif; // End if categories. ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'storefront' ) );

			if ( $tags_list ) : ?>
				<div class="tags-links">
					<?php
					echo '<div class="label">' . esc_attr( __( 'Tagged', 'storefront' ) ) . '</div>';
					echo wp_kses_post( $tags_list );
					?>
				</div>
			<?php endif; // End if $tags_list. ?>

		<?php endif; // End if 'post' == get_post_type(). ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<div class="comments-link">
					<?php echo '<div class="label">' . esc_attr( __( 'Comments', 'storefront' ) ) . '</div>'; ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'storefront' ), __( '1 Comment', 'storefront' ), __( '% Comments', 'storefront' ) ); ?></span>
				</div>
			<?php endif; ?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'storefront_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function storefront_paging_nav() {
		global $wp_query;

		$args = array(
			'type' 	    => 'list',
			'next_text' => _x( 'Next', 'Next post', 'storefront' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'storefront' ),
			);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'storefront_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function storefront_post_nav() {
		$args = array(
			'next_text' => '%title',
			'prev_text' => '%title',
			);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'storefront_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function storefront_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			_x( 'Posted on %s', 'post date', 'storefront' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo wp_kses( apply_filters( 'storefront_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span>', $posted_on ), array(
			'span' => array(
				'class'  => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		) );
	}
}

if ( ! function_exists( 'storefront_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_product_categories( $args ) {

		if ( storefront_is_woocommerce_activated() ) {

			$args = apply_filters( 'storefront_product_categories_args', array(
				'limit' 			=> 0,
				'columns' 			=> 5,
				'child_categories' 	=> 0,
				'orderby' 			=> 'name',
				'title'				=> __( 'Shop by Category', 'storefront' ),
			) );



      echo '<section class="storefront-product-section-2 storefront-recent-products-2" aria-label="Recent Products 2">';

      echo '<h2 class="section-title">АКЦИЯ</h2>';
/*
      echo "<p>Здравствуйте дорогие коллеги!<br/>
      Компания Комплект Премьер запустила акцию на различные материалы нашей компании (декоры, молдинги, клеи и т.д.).<br/>
      Только до 31.12.2017 года мы вам даём скидку от 40 до 50 %.<br/>
      Перечень материалов на которые действует скидка уточняйте у менеджеров.</p>";
*/
      echo "<p>Здравствуйте, Дорогие коллеги!<br/>
Компания Комплект Премьер, запустила АКЦИЮ!!!! на различные материалы нашей компании ( Декоры, Молдинги, Клеи и т.д.).<br/>
Только до 31.12.2017 года мы вам даём скидку от 40 до 50 %.<br/>
Перечень материалов на которые действует скидка, уточняйте у менеджеров.</p>";

      echo '</section>';



			echo '<section class="storefront-product-section storefront-product-categories" aria-label="Product Categories">';

			do_action( 'storefront_homepage_before_product_categories' );

/*Mihail add 21-10-19 Осенний ценопад на главной*/
echo '<div style="margin-top:6em;">
<div style="display:block;background-color:#f9f9f9;border:2px #008c3e solid;padding:25px;margin-bottom:20px;text-align:center;box-shadow: 3px 10px 3px rgba(0,0,0,0.1)">

<h2 style="color: #008c3e; text-align:center;">ОСЕННИЙ ЦЕНОПАД от Комплект Премьер</h2>

<h3 style="color: #dc3545; text-align:center;">Ограниченные партии резных молдингов, молдингов и декоров ПВХ по специальным ценам</h3>

<div style="display:inline-block; padding:20px; border:1px #f0f0f0 solid;margin-bottom:15px;background-color:#fff;box-shadow: 3px 7px 3px rgba(0,0,0,0.1)">
<h4>Молдинги резные из массива бука</h4>
<p>Придают интерьеру изысканный и роскошный вид. Они не только преображают стены и потолки, но и выполняют в помещении конкретные практические функции. С их помощью комната удобно разделяется на отдельные зоны. Обрамленные ими окна, двери, арки и камины становятся более аккуратными и приобретают завершенный вид.</p>

<div style="display:block; margin-bottom:10px;">
<a href="/wp-content/uploads/2019/10/sales-molding-wood-10-19.pdf" target="_blank" style="background-color:#dc3545;color:#fff;padding:8px 12px;"><i class="fa fa-file-pdf-o" style="margin-right:10px;"></i>Скачать прайс</a>
</div>
</div>

<div style="display:inline-block; padding:20px; border:1px #f0f0f0 solid;margin-bottom:15px;background-color:#fff;box-shadow: 3px 7px 3px rgba(0,0,0,0.1)">

<h4>Молдинги и декоры ПВХ</h4>
<p>Используют в качестве декорирования фасадных частей мебели изготавливаемых с использованием финишного покрытия пленкой ПВХ и под окраску эмалью с эффектом Декапе (нанесение различных цветов патины).</p>

<div style="display:block; margin-bottom:10px;">
<a href="/wp-content/uploads/2019/10/sales-molding-decore-pvh-10-19.pdf" target="_blank" style="background-color:#dc3545;color:#fff;padding:8px 12px;"><i class="fa fa-file-pdf-o" style="margin-right:10px;"></i>Скачать прайс</a>
</div>
</div>

</div>
</div>';
/* end add */
          
			echo '<div class="homepage-discount"><a href="/product-category/klej/poliuretanovyj-klej-na-vodnoj-osnove/" style="display:none">Полиуретановый клей на водной основе по 440 рублей!</a></div>';
			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storefront_homepage_after_product_categories_title' );

			echo storefront_do_shortcode( 'product_categories', array(
				'number'  => intval( $args['limit'] ),
				'columns' => intval( $args['columns'] ),
				'orderby' => esc_attr( $args['orderby'] ),
				'parent'  => esc_attr( $args['child_categories'] ),
			) );

			do_action( 'storefront_homepage_after_product_categories' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storefront_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_recent_products( $args ) {

		if ( storefront_is_woocommerce_activated() ) {

			$args = apply_filters( 'storefront_recent_products_args', array(
				'limit' 			=> 4,
				'columns' 		=> 4,
				'title'				=> __( 'New In', 'storefront' ),
			) );

			echo '<section class="storefront-product-section storefront-recent-products" aria-label="Recent Products 1">';

			do_action( 'storefront_homepage_before_recent_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storefront_homepage_after_recent_products_title' );

			echo storefront_do_shortcode( 'recent_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'storefront_homepage_after_recent_products' );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'storefront_new_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_new_products( $atts, $content = null ) {
  
		
		// Define Query Arguments
		$args = array( 
					'post_type' 	 => 'product', 
					'posts_per_page' => 4, 
					'product_tag' 	 => 'новинка' 
					);
		
		$loop = new WP_Query( $args );
		$product_count = $loop->post_count;
		if( $product_count > 0 ) :
			echo '<section class="storefront-product-section storefront-recent-products" aria-label="Recent Products">';
			echo '<h2 class="section-title">Новинки</h2>';
            echo '<div class="woocommerce columns-0">';
			echo '<ul class="products new-products">';
				while ( $loop->have_posts() ) : $loop->the_post(); global $product;
					global $post;
					echo '<li class="product new-product type-product status-publish has-post-thumbnail product_cat-virdzhiniya product_cat-dobor-virdzhiniya product_cat-fasady pa_proizvoditel-kuhni-premer pa_material-massiv-yasenya pa_razmery-716h90 pa_edinitsy-izmerenij-sht instock purchasable product-type-simple">';
					echo '<a href="http://komplekt-premier.ru/product/' . $loop->post->post_name . '/" class="woocommerce-LoopProduct-link">';
					if (has_post_thumbnail( $loop->post->ID )) 
						echo  get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
					else 
						echo '<img src="'.$woocommerce->plugin_url().'/assets/images/placeholder.png" alt="" width="'.$woocommerce->get_image_size('shop_catalog_image_width').'px" height="'.$woocommerce->get_image_size('shop_catalog_image_height').'px" />';
					echo '<h3>' . $loop->post->post_title . '</h3>
							</a>
							<a rel="nofollow" href="/?add-to-cart=' . $loop->post->ID . '" data-quantity="1" data-product_id="' . $loop->post->ID . '" data-product_sku="" class="button product_type_simple add_to_cart_button ajax_add_to_cart">В корзину</a>
						</li>';
				endwhile;
			echo '</ul>';
            echo '</div><!--/.products-->';
			echo '</section>';

		endif;
		//return ob_get_clean();
		return;
	}
}


if ( ! function_exists( 'storefront_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_featured_products( $args ) {

		if ( storefront_is_woocommerce_activated() ) {

			$args = apply_filters( 'storefront_featured_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'We Recommend', 'storefront' ),
			) );

			echo '<section class="storefront-product-section storefront-featured-products" aria-label="Featured Products">';

			do_action( 'storefront_homepage_before_featured_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storefront_homepage_after_featured_products_title' );

			echo storefront_do_shortcode( 'featured_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) );

			do_action( 'storefront_homepage_after_featured_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storefront_our_advantages' ) ) {
	/**
	 * Display Our Advantages
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_our_advantages() {

			/**/
			$args = array(
				'numberposts' => 5,
				'category_name'    => 'our_advantages',
				'orderby'     => 'date',
				'order'       => 'DESC',
				'include'     => array(),
				'exclude'     => array(),
				'meta_key'    => '',
				'meta_value'  =>'',
				'post_type'   => 'post',
				'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
			);
			/**/
			echo '<section class="storefront-product-section storefront-our-advantages" aria-label="Our Advantages">';
			echo '<h2 class="section-title">Наши преимущества</h2>';
			$html = '<div class="woocommerce columns-5"><ul class="products">';
			$postsArray = get_posts( $args );
			foreach ($postsArray as $post) {
				$html .= '<li class="product type-product status-publish has-post-thumbnail product_cat-ugolok-k-u-profilyu product_cat-upakovka pa_proizvoditel-isofom pa_razmery-a100-mm-3-b100-mm-3 pa_fasovka-1000-sht instock featured purchasable product-type-simple">
					<a href="#" class="woocommerce-LoopProduct-link">'
					. '<img width="300" height="300" src="' . get_the_post_thumbnail_url($post->ID, 'post-thumbnail')
					. '" class="attachment-shop_catalog size-shop_catalog wp-post-image round-img" alt="'
					. $post->post_title
					. '" title="' . $post->post_title . '" sizes="(max-width: 300px) 100vw, 300px">'
					. '<h3>' . $post->post_title . '</h3></a><p>' . $post->post_content . '</p></li>';
			}
			$html .= '</ul></div>';
			echo $html;
			echo '</section>';
	}
}

if ( ! function_exists( 'storefront_our_clients' ) ) {
	/**
	 * Display Our Advantages
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_our_clients() {


			echo '<section class="storefront-product-section storefront-our-clients" aria-label="Our Advantages">';
			echo '<h2 class="section-title">Наши партнеры</h2>';
			$html = '<div class="col-full"><div class="flexslider-carousel">
			  <ul class="slides">
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-1.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-2.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-3.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-4.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-5.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-6.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-1.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-2.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-3.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-4.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-5.jpg" />
			    </li>
			    <li>
			      <img src="/wp-content/themes/storefront/assets/images/wist/clients/client-6.jpg" />
			    </li>
			  </ul>
			</div></div>';
			echo $html;

			echo "<style>
						.flex-container a:active,.flexslider-carousel a:active,.flex-container a:focus,.flexslider-carousel a:focus{outline:none}.slides,.flex-control-nav,.flex-direction-nav{margin:0;padding:0;list-style:none}.flexslider{margin:0;padding:0}.flexslider-carousel .slides > li{display:none;-webkit-backface-visibility:hidden}.flexslider-carousel .slides img{width:100%;display:block}.flex-pauseplay span{text-transform:capitalize}.slides:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}html[xmlns] .slides{display:block}* html .slides{height:1%}.no-js .slides > li:first-child{display:block}.flexslider{margin:0 0 60px;position:relative;zoom:1}.flex-viewport{max-height:2000px;-webkit-transition:all 1s ease;-moz-transition:all 1s ease;-o-transition:all 1s ease;transition:all 1s ease}.loading .flex-viewport{max-height:300px}.flexslider-carousel .slides{zoom:1}.carousel li{margin-right:5px}.flex-direction-nav{*height:0}.flex-direction-nav a{text-decoration:none;display:block;width:40px;height:40px;margin:-20px 0 0;position:absolute;top:50%;z-index:10;overflow:hidden;opacity:0;cursor:pointer;color:rgba(0,0,0,0.8);text-shadow:1px 1px 0 rgba(255,255,255,0.3);-webkit-transition:all .3s ease;-moz-transition:all .3s ease;transition:all .3s ease}.flex-direction-nav .flex-prev{left:-50px}.flex-direction-nav .flex-next{right:-50px;text-align:right}.flexslider:hover .flex-prev{opacity:0.7;left:10px}.flexslider:hover .flex-next{opacity:0.7;right:10px}.flexslider:hover .flex-next:hover,.flexslider:hover .flex-prev:hover{opacity:1}.flex-direction-nav .flex-disabled{opacity:0 !important;filter:alpha(opacity=0);cursor:default}.flex-direction-nav a:before{font-family:'flexslider-icon';font-size:40px;line-height:1;display:inline-block;content:'\f001'}.flex-direction-nav a.flex-next:before{content:'\f002'}.flex-pauseplay a{display:block;width:20px;height:20px;position:absolute;bottom:5px;left:10px;opacity:0.8;z-index:10;overflow:hidden;cursor:pointer;color:#000}.flex-pauseplay a:before{font-family:'flexslider-icon';font-size:20px;display:inline-block;content:'\f004'}.flex-pauseplay a:hover{opacity:1}.flex-pauseplay a.flex-play:before{content:'\f003'}.flex-control-nav{width:100%;position:absolute;bottom:-40px;text-align:center}.flex-control-nav li{margin:0 6px;display:inline-block;zoom:1;*display:inline}.flex-control-paging li a{width:11px;height:11px;display:block;background:#666;background:rgba(0,0,0,0.5);cursor:pointer;text-indent:-9999px;-webkit-border-radius:20px;-moz-border-radius:20px;-o-border-radius:20px;border-radius:20px;-webkit-box-shadow:inset 0 0 3px rgba(0,0,0,0.3);-moz-box-shadow:inset 0 0 3px rgba(0,0,0,0.3);-o-box-shadow:inset 0 0 3px rgba(0,0,0,0.3);box-shadow:inset 0 0 3px rgba(0,0,0,0.3)}.flex-control-paging li a:hover{background:#333;background:rgba(0,0,0,0.7)}.flex-control-paging li a.flex-active{background:#000;background:rgba(0,0,0,0.9);cursor:default}.flex-control-thumbs{margin:5px 0 0;position:static;overflow:hidden}.flex-control-thumbs li{width:25%;float:left;margin:0}.flex-control-thumbs img{width:100%;display:block;opacity:.7;cursor:pointer}.flex-control-thumbs img:hover{opacity:1}.flex-control-thumbs .flex-active{opacity:1;cursor:default}@media screen and (max-width: 860px){.flex-direction-nav .flex-prev{opacity:1;left:10px}.flex-direction-nav .flex-next{opacity:1;right:10px}}</style></section>";
	}
}

if ( ! function_exists( 'storefront_bottom_contact' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_bottom_contact( $args ) {
		if ( storefront_is_woocommerce_activated() ) {
			echo '<section class="storefront-product-section storefront-bottom-contact" aria-label="bottom contact">';
			echo '<h2 class="section-title">Обратная связь</h2>';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'page' );
			}
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storefront_popular_products' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_popular_products( $args ) {

		if ( storefront_is_woocommerce_activated() ) {

			$args = apply_filters( 'storefront_popular_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'Fan Favorites', 'storefront' ),
			) );

			echo '<section class="storefront-product-section storefront-popular-products" aria-label="Popular Products">';

			do_action( 'storefront_homepage_before_popular_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storefront_homepage_after_popular_products_title' );

			echo storefront_do_shortcode( 'top_rated_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'storefront_homepage_after_popular_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storefront_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_on_sale_products( $args ) {

		if ( storefront_is_woocommerce_activated() ) {

			$args = apply_filters( 'storefront_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'On Sale', 'storefront' ),
			) );

			echo '<section class="storefront-product-section storefront-on-sale-products" aria-label="On Sale Products">';

			do_action( 'storefront_homepage_before_on_sale_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storefront_homepage_after_on_sale_products_title' );

			echo storefront_do_shortcode( 'sale_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'storefront_homepage_after_on_sale_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storefront_best_selling_products' ) ) {
	/**
	 * Display Best Selling Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since 2.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storefront_best_selling_products( $args ) {
		if ( storefront_is_woocommerce_activated() ) {
			$args = apply_filters( 'storefront_best_selling_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'	  => esc_attr__( 'Best Sellers', 'storefront' ),
			) );
			echo '<section class="storefront-product-section storefront-best-selling-products" aria-label="Best Selling Products">';
			do_action( 'storefront_homepage_before_best_selling_products' );
			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';
			do_action( 'storefront_homepage_after_best_selling_products_title' );
			echo storefront_do_shortcode( 'best_selling_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );
			do_action( 'storefront_homepage_after_best_selling_products' );
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storefront_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function storefront_homepage_content() {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'content', 'page' );

		} // end of the loop.
	}
}

if ( ! function_exists( 'storefront_homepage_slider' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function storefront_homepage_slider() {
		$args = array(
			'numberposts' => 5,
			'category_name'    => 'slider',
			'orderby'     => 'date',
			'order'       => 'DESC',
			'include'     => array(),
			'exclude'     => array(),
			'meta_key'    => '',
			'meta_value'  =>'',
			'post_type'   => 'post',
			'suppress_filters' => true,
		);
		echo '<section class="storefront-product-section storefront-slider">';
		$html = '<div class="flexslider"><ul class="slides">';
		$postsArray = get_posts( $args );
		foreach ($postsArray as $post) {
			$html .= '<li><img src="' . get_the_post_thumbnail_url($post->ID, 'post-thumbnail') . '" /></li>';
		}
		$html .= '</ul></div>';
		echo $html;
		echo '</section>';
	}
}

if ( ! function_exists( 'storefront_social_icons' ) ) {
	/**
	 * Display social icons
	 * If the subscribe and connect plugin is active, display the icons.
	 *
	 * @link http://wordpress.org/plugins/subscribe-and-connect/
	 * @since 1.0.0
	 */
	function storefront_social_icons() {
		if ( class_exists( 'Subscribe_And_Connect' ) ) {
			echo '<div class="subscribe-and-connect-connect">';
			subscribe_and_connect_connect();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'storefront_get_sidebar' ) ) {
	/**
	 * Display storefront sidebar
	 *
	 * @uses get_sidebar()
	 * @since 1.0.0
	 */
	function storefront_get_sidebar() {
		get_sidebar();
	}
}

if ( ! function_exists( 'storefront_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.5.0
	 */
	function storefront_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( $size );
		}
	}
}

if ( ! function_exists( 'storefront_primary_navigation_wrapper' ) ) {
	/**
	 * The primary navigation wrapper
	 */
	function storefront_primary_navigation_wrapper() {
		echo '<div class="storefront-primary-navigation">';
	}
}

if ( ! function_exists( 'storefront_primary_navigation_wrapper_close' ) ) {
	/**
	 * The primary navigation wrapper close
	 */
	function storefront_primary_navigation_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'storefront_init_structured_data' ) ) {
	/**
	 * Generates structured data.
	 *
	 * Hooked into the following action hooks:
	 *
	 * - `storefront_loop_post`
	 * - `storefront_single_post`
	 * - `storefront_page`
	 *
	 * Applies `storefront_structured_data` filter hook for structured data customization :)
	 */
	function storefront_init_structured_data() {

		// Post's structured data.
		if ( is_home() || is_category() || is_date() || is_search() || is_single() && ( storefront_is_woocommerce_activated() && ! is_woocommerce() ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
			$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

			$json['@type']            = 'BlogPosting';

			$json['mainEntityOfPage'] = array(
				'@type'                 => 'webpage',
				'@id'                   => get_the_permalink(),
			);

			$json['publisher']        = array(
				'@type'                 => 'organization',
				'name'                  => get_bloginfo( 'name' ),
				'logo'                  => array(
					'@type'               => 'ImageObject',
					'url'                 => $logo[0],
					'width'               => $logo[1],
					'height'              => $logo[2],
				),
			);

			$json['author']           = array(
				'@type'                 => 'person',
				'name'                  => get_the_author(),
			);

			if ( $image ) {
				$json['image']            = array(
					'@type'                 => 'ImageObject',
					'url'                   => $image[0],
					'width'                 => $image[1],
					'height'                => $image[2],
				);
			}

			$json['datePublished']    = get_post_time( 'c' );
			$json['dateModified']     = get_the_modified_date( 'c' );
			$json['name']             = get_the_title();
			$json['headline']         = $json['name'];
			$json['description']      = get_the_excerpt();

		// Page's structured data.
		} elseif ( is_page() ) {
			$json['@type']            = 'WebPage';
			$json['url']              = get_the_permalink();
			$json['name']             = get_the_title();
			$json['description']      = get_the_excerpt();
		}

		if ( isset( $json ) ) {
			Storefront::set_structured_data( apply_filters( 'storefront_structured_data', $json ) );
		}
	}
  
  //	Mihail add 04.10.2019 - custom search fild
  if ( ! function_exists( 'additional_site_search_top' ) ) {
	function additional_site_search_top() {
		
      	echo '<div class="kp-site-search">';
				the_widget( 'WC_Widget_Product_Search', 'title=' );
        echo '</div>';
	}
}
}
