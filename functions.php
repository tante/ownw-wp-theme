<?php
/* show people for hashtag 
 * usage [ownw_taggedpeople tag="Datenschutz"]
 * usage with multiple tags [ownw_taggedpeople tag="Datenschutz,Dezentralisierung"]
 */
function ownw_people4tag( $attrs ) {
	// parse tag value
	$data = shortcode_atts( array("tag" => ''), $attrs);
	
	if (!isset($data['tag'])){
	 	echo 'Kein Tag übergeben';
	}
		
	$args = array( 
		'post_type' => 'page',
		'category_name' => 'Profile',
		'tag' => $data['tag']
	);
	$query = new WP_Query( $args );
	$output = ''; // '<div>';	
	
	if ( $query->have_posts() ){
		while ( $query->have_posts() ) {
			// Select current object
			$query->the_post();
			$output = $output ."<a href=\"". get_the_permalink() ."\">" . get_the_title() .'</a>, ';
		}	
	}
	
	// strip whitespace	
	$output = rtrim($output);
	// cut the last comma
	$output = rtrim($output, ",");
		
	// add closing tag
	// $output = $output . "</div>";	
	return $output;
}

add_shortcode( 'ownw_taggedpeople', 'ownw_people4tag');

/* show Topics for Person
 * only works on a personal profile page 
 * usage [ownw_topics]
 */
function ownw_topics( $attrs ) {
	$output = "<ul>";

	$page = get_post();

	$tags = get_the_tags(get_the_ID());
	foreach($tags as $tag){
		$output = $output ."<li>". $tag->name . "</li>";
	}

	$output = $output . "</ul>";
	return $output;
}

add_shortcode( 'ownw_topics', 'ownw_topics');
?>
