<?php
namespace Flux;

class Shortcode {
	public function __construct() {
		add_shortcode( 'form_search_bds', array( $this, 'render_form' ) );
		add_filter( 'pre_get_posts', [ $this, 'process_search' ] );
	}

	public function render_form() {
		?>
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form" role="search">
			<div class="loai-nhadat">
				<label class="nhadat_type">
					<input type="radio" checked="checked" name="nha_dat" value="nha-dat-mua-ban">
					<span class="name">Nhà đất bán</span>
				</label>
				<label class="nhadat_type">
					<input type="radio" name="nha_dat" value="nha-dat-cho-thue">
					<span class="name">Nhà đất cho thuê</span>
				</label>
			</div>
			<div class="text-search">
				<input type="text" name="s" placeholder="<?php esc_attr_e( 'Nhập từ khóa tìm kiếm...', 'bat-dong-san' ) ?>">
				<button type="submit" class="btn-search">Tìm kiếm</button>
			</div>
			<div class="box-select">
				<select name="loai_nha_dat" id="" class="tax-danh-muc">
					<?php
					echo '<option value="">Chọn loại nhà đất</option>';
					$terms = get_terms( [ 
						'taxonomy'   => 'danh-muc-nha-dat',
						'hide_empty' => false,
						'parent'     => 0,
					] );
					foreach ( $terms as $term ) {
						echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
					}
					?>
				</select>
				<select name="city" id="city" class="city">
					<?php
					echo '<option value="">Chọn Tỉnh/Thành</option>';
					$cities = get_terms( [ 
						'taxonomy'   => 'dia-diem',
						'hide_empty' => false,
						'parent'     => 0,
					] );
					foreach ( $cities as $city ) {
						echo '<option data-ip="' . $city->term_id . '" value="' . $city->slug . '">' . $city->name . '</option>';
					}
					?>
				</select>
				<select name="districts" id="districts" class="districts">
					<option value="">Chọn Quận/Huyện</option>
				</select>
				<select name="dien_tich" id="" class="dien-tich">
					<?php
					echo '<option value="">Chọn diện tích</option>';
					$dien_tich = get_terms( [ 
						'taxonomy'   => 'dien-tich',
						'hide_empty' => false,
						'parent'     => 0,
					] );
					foreach ( $dien_tich as $dientich ) {
						echo '<option value="' . $dientich->slug . '">' . $dientich->name . '</option>';
					}
					?>
				</select>
				<select name="gia" id="" class="gia">
					<?php
					echo '<option value="">Mức giá</option>';
					$prices = get_terms( [ 
						'taxonomy'   => 'gia',
						'hide_empty' => false,
						'parent'     => 0,
					] );
					foreach ( $prices as $price ) {
						echo '<option value="' . $price->slug . '">' . $price->name . '</option>';
					}
					?>
				</select>
			</div>
		</form>
		<?php
	}

	public function process_search( $query ) {
		if ( $query->is_search && ! is_admin() ) {
			if ( isset( $_GET[ 's' ] ) ) {
				$query->set( 'post_type', [ $_GET[ 'nha_dat' ] ] );
			}
			if ( $query->is_main_query() ) {
				$args[] = array( 'relation' => 'AND' );
				if ( isset( $_GET[ 'loai_nha_dat' ] ) && $_GET[ 'loai_nha_dat' ] != 'all' ) {
					$args[] = [ 
						'taxonomy' => 'danh-muc-nha-dat',
						'field'    => 'slug',
						'terms'    => $_GET[ 'loai_nha_dat' ],
					];
				}
				if ( isset( $_GET[ 'city' ] ) && $_GET[ 'city' ] != 'all' && $_GET[ 'districts' ] == 'all' ) {
					$args[] = [ 
						'taxonomy' => 'dia-diem',
						'field'    => 'slug',
						'terms'    => $_GET[ 'city' ],
					];
				}
				if ( isset( $_GET[ 'districts' ] ) && $_GET[ 'districts' ] != 'all' ) {
					$args[] = [ 
						'taxonomy' => 'dia-diem',
						'field'    => 'slug',
						'terms'    => $_GET[ 'districts' ],
					];
				}
				if ( isset( $_GET[ 'dien_tich' ] ) && $_GET[ 'dien_tich' ] != 'all' ) {
					$args[] = [ 
						'taxonomy' => 'dien-tich',
						'field'    => 'slug',
						'terms'    => $_GET[ 'dien_tich' ],
					];
				}
				if ( isset( $_GET[ 'gia' ] ) && $_GET[ 'gia' ] != 'all' ) {
					$args[] = [ 
						'taxonomy' => 'gia',
						'field'    => 'slug',
						'terms'    => $_GET[ 'gia' ],
					];
				}
				$query->set( 'tax_query', $args );
				$query->set( 'post_type', [ $_GET[ 'nha_dat' ] ] );
			}
		}
		return $query;
	}
}