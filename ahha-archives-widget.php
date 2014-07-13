<?php
/*
Plugin Name: Archives Widget
Plugin URI: http://www.ahhacreative.com/
Description: Customizes the way the archives are displayed within the sidebar
Author: Amy Dutton
Version: 1
Author URI: http://www.ahhacreative.com/
*/


class AhhaArchivesWidget extends WP_Widget
{
  function AhhaArchivesWidget()
  {
    $widget_ops = array('classname' => 'AhhaArchivesWidget', 'description' => 'Alternative way for displaying archives' );
    $this->WP_Widget('AhhaArchivesWidget', 'Ah Ha Archives', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title; 
 
 
    // WIDGET CODE GOES HERE ?>
    <ul>
      <?php global $wpdb;
      $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
      foreach($years as $year) : 
      ?>
        <li class="archive_year"><a href="<?php echo get_year_link($year); ?> "><?php echo $year; ?></a>

          <?php $months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");
            foreach($months as $month) :
            ?>
            <li class="archive_month"><a href="<?php echo get_month_link($year, $month); ?>"><?php echo date( 'F', mktime(0, 0, 0, $month) );?></a>
            </li>
            <?php endforeach;?>
        </li>
      <?php endforeach; ?>
    </ul>




 
    <?php echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("AhhaArchivesWidget");') );?>