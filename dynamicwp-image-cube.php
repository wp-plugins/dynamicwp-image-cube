<?php
/*
Plugin Name: DynamicWP Image Cube
Plugin URI: http://www.dynamicwp.net/plugins/free-plugin-dynamicwp-image-cube/
Description: The Plugin will build your image gallery as cube face. The Cube rotates automatically to show your images. The plugin is based on: <a href="http://keith-wood.name/imageCube.html">keith-wood.name</a>
Author: Reza Erauansyah
Version: 1.0
Author URI: http://www.dynamicwp.net
*/

// =============================== Cube Widget ======================================

Class Image_Cube_Widget extends WP_Widget{

	function Image_Cube_Widget(){
		$control_ops = array( 'width' => 400, 'height' => 350, 'id_base' => 'image-cube-widget' );
		$this->WP_Widget( 'image-cube-widget', 'DynamicWP Image Cube', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		$myid = $args['widget_id'];
		$linkss = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 
		echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$linkss."jquery.imagecube.js\"></script>";
		echo "<script type=\"text/javascript\" charset=\"utf-8\">
		/* <![CDATA[ */
			var cuber = jQuery.noConflict();
			cuber(function () {
				cuber('#basicCube-".$myid."').imagecube();
			});
		/* ]]> */
		</script>";
 
		extract( $args );
		$height = ($instance['height']) ? $instance['height'] : 100 ;
		$width = ($instance['width']) ? $instance['width'] : 200;
		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;
		if($title) echo $before_title . $title . $after_title;
		  echo "<div id='basicCube-".$myid."' style='width:".$width."px; height:".$height."px;'>";
			 $option = $instance['image_link'];
			 if($option) {
				 $values = explode(",", $option);
				 if(is_array($values)) {
					foreach ($values as $item) {
						if(!empty($item)) {
							echo "<img src=\"$item\" alt=\"img\" title=\"\" /> \n";
						}
					 }
				 }
			 }
		  echo "</div><br /><div style='clear: both;'></div><span style='float: right; font-size: 9px;'>widget by <a href='http://www.dynamicwp.net' target='_blank'>DynamicWP</a></span><div style='clear:both;'></div>";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['image_link'] = strip_tags( $new_instance['image_link'] );
		return $instance;
	}

	function form($instance){?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo $instance['title']; ?>"
				class="widefat"
			/>
			<label for="<?php echo $this->get_field_id('width'); ?>">Image Width</label>
			<input id="<?php echo $this->get_field_id('width'); ?>"
				name="<?php echo $this->get_field_name('width'); ?>"
				value="<?php echo $instance['width']; ?>"
				class="widefat"
			/>
			<label for="<?php echo $this->get_field_id('height'); ?>">Image Height</label>
			<input id="<?php echo $this->get_field_id('height'); ?>"
				name="<?php echo $this->get_field_name('height'); ?>"
				value="<?php echo $instance['height']; ?>"
				class="widefat"
			/>
			<label for="<?php echo $this->get_field_id('image_link'); ?>">Image Link : (enter your full image links here. Separate the images with comma ',') </label>
			<textarea id="<?php echo $this->get_field_id('image_link'); ?>"
				name="<?php echo $this->get_field_name('image_link'); ?>" class="widefat" rows="10"><?php echo $instance['image_link']; ?></textarea>

		</p>	
	<?php }
	


}

function mypunccube(){
	if( !is_admin()){
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '');
	   wp_enqueue_script('jquery');
	}
}

if(!is_admin()){
   add_action('wp_head', 'mypunccube', 1);
}

// get WP to load our widget
function init_image_cube(){
	register_widget('Image_Cube_Widget');
}
add_action("widgets_init", "init_image_cube");
?>
