<?php
namespace Flux;

class Ajax {
	public function __construct() {
		add_action( 'wp_ajax_display_district', [ $this, 'display_district' ] );
		add_action( 'wp_ajax_nopriv_display_district', [ $this, 'display_district' ] );
	}

	public function display_district() {
		if ( empty( $_POST[ 'city' ] ) ) {
			wp_send_json_error();
		}
		$city_id   = $_POST[ 'city' ];
		$districts = get_terms( [ 
			'taxonomy'   => 'dia-diem',
			'hide_empty' => false,
			'parent'     => $city_id,
		] );
		$lists     = [];
		foreach ( $districts as $district ) {
			$lists[ $district->slug ] = $district->name;
		}
		wp_send_json_success( $lists );
	}
}