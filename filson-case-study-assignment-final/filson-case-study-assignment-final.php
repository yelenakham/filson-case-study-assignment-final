<?php
/*
Plugin Name: Filson Case Study Assignment Final
Description: Creates Banner from Filson.com post using AJAX/WP Rest API Technology. Add [filson_case_study_assignment_final] shortcode anywhere on the page, post or code.
Version: 1.0
Author: Yelena Khamidullina
Author URI: https://devotedprogrammer.com/
*/

function filson_case_study_assignment_final_scripts_enqueue() {
		global $post;
    if ( has_shortcode( $post->post_content , 'filson_case_study_assignment_final' ) ) {
		wp_enqueue_script( 'jquery3-5-0' , 'https://code.jquery.com/jquery-3.5.0.js' );
		wp_enqueue_script( 'jquery-ui' , 'https://code.jquery.com/ui/1.13.0/jquery-ui.js' );
		wp_enqueue_script( 'jquery-migrate' , 'https://code.jquery.com/jquery-migrate-3.0.0.min.js' );
		wp_enqueue_style( 'bootstrap' , 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css' );
		wp_enqueue_script( 'popper' , 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js' );
		wp_enqueue_script( 'bootstrap-bundle-min' , 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js' );
	}
}
add_action( 'wp_enqueue_scripts' , 'filson_case_study_assignment_final_scripts_enqueue' );

function filson_case_study_assignment_final( $atts )
{
	?>
		<script>
			jQuery.ajax({
						 url: 'https://www.filson.com/blog/wp-json/wp/v2/posts?_embed&per_page=1',
					   method: 'GET',
					   success: function( data, txtStatus, xhr ) {
								var cards = Object.keys( data ).length;
								if( cards > 0) {
									var html;
									var url = data[0]['link'];
									var img_url = data[0]['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url'];
									var title = data[0]['title']['rendered'];
									html =  '<a href="' + url + '" target="_blank" class="text-decoration-none">';
									html +=  '<div class="card text-center" style="width: 300px;">';
								  html +=   '<img class="card-img-top" src="'+ img_url+'" alt="Card image cap">';
								  html +=   '<div class="card-body mb-5">';
								  html +=    '<h6 class="card-title">'+ title +'</h6>';
								  html +=    '<button class="btn btn-primary btn-lg">Read More</a>';
								  html +=   '</div>';
									html +=  '</div>';
									html += '</a>';
								}
								$( '#response' ).append( html );
					  	}
						});

		</script>

		<?php
		$html = '<div id="response"></div>';
		return $html;
}

add_shortcode( 'filson_case_study_assignment_final' , 'filson_case_study_assignment_final' );
