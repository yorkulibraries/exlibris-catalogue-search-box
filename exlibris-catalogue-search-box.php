<?php
/*
Plugin Name: ExLibris Catalogue Search Box
Plugin URI: http://wordpress.org/extend/plugins/#
Description: ExLibris Catalogue Brief Search Box Widget Plugin for Primo / Discovery
Author: Ali Sadaqain, York University Libraries
Version: 1.0
Author URI: https://www.library.yorku.ca

*/

// register My_Widget
add_action( 'widgets_init', function(){
	register_widget( 'elbsb_Catalogue_Search_Box_Widget' );
});


// Plugin js and styles
add_action('wp_enqueue_scripts', 'frontend_scripts');
function frontend_scripts() {
  
  wp_register_script('exlibris_catalogue_search_box_js', plugins_url('exlibris-catalogue-search-box/js/exlibris-csb.js'), array(), '1.0' );
	wp_enqueue_script( 'exlibris_catalogue_search_box_js' );	
	
	wp_register_style('exlibris_catalogue_search_box_css', plugins_url( 'exlibris-catalogue-search-box/css/exlibris-csb.css', array(), '1.0' ));
	wp_enqueue_style( 'exlibris_catalogue_search_box_css' );	
  
}
add_action('admin_enqueue_scripts', 'backend_scripts');
function backend_scripts() {
	wp_register_style('exlibris_catalogue_search_box_admin_css', plugins_url( 'exlibris-catalogue-search-box/css/exlibris-csb-admin.css', array(), '1.0' ));
	wp_enqueue_style( 'exlibris_catalogue_search_box_admin_css' );	
  
}



// Widget Meat

class elbsb_Catalogue_Search_Box_Widget extends WP_Widget {
	// class constructor
  public function __construct() {
    $widget_options = array( 
      'classname' => 'exlibris_catalogue_search_box',
      'description' => 'ExLibris Catalogue Brief Search Box Widget Plugin for Primo / Discovery',
    );
    parent::__construct( 'exlibris_catalogue_brief_search_box', 'ExLibris Catalogue Brief Search Box', $widget_options );
  }
	
	// output the widget content on the front-end
  public function widget( $args, $instance ) {
    
    $title          = apply_filters( 'widget_title', $instance[ 'title' ] );
    $discovery_url  = $instance['discovery_url'];
    $institution_id = $instance['institution_id'];
    $tab_code       = $instance['tab_code'];
    $search_scope   = $instance['search_scope'];
    // $mode           = "basic";
    
    $unique_primo_query = $instance['unique_primo_query'];    
    $placehoder_text    = $instance['placehoder_text'];
    $custom_css_class   = $instance['custom_css_class'];
    
    
    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>

  <!-- echo with user defined css class -->
  <div class="<?php echo $custom_css_class ?>"> 
    <div class="elbsb-search-container">
        <img src="<?php echo plugins_url('images/Omni-Single-RGB.svg', __FILE__) ?>" width="150px;" class="omni-logo"/>
        <!-- url: https://ocul-yor.primo.exlibrisgroup.com/discovery/search -->
        <form id="simple" name="searchForm" method="get" target="_self" class="elbsb-search-form" action="<?php echo $discovery_url ?>" enctype="application/x-www-form-urlencoded; charset=utf-8" onsubmit="searchPrimo('<?php echo $unique_primo_query ?>')" >
          <!-- Customizable Parameters -->
<!-- '<?php echo $primo_query_id ?>', '<?php echo $primo_query_box_id ?>' -->
          <!-- ALMA ID: OCUL_YOR -->
          <input type="hidden" name="vid" value="<?php echo $institution_id ?>">

          <!-- OCULDiscoveryNetwork alternative for just YUL + Network -->
          <input type="hidden" name="tab" value="<?php echo $tab_code ?>">

          <!-- 
            - Everything = MyInst_and_CI 
            - OCULDiscoveryNetwork = OCULDiscoveryNetwork
          -->
          <input type="hidden" name="search_scope" value="<?php echo $search_scope ?>">
          <input type="hidden" name="mode" value="basic">

          <!-- Fixed parameters -->
          <input type="hidden" name="displayMode" value="full">
          <input type="hidden" name="bulkSize" value="10">
          <input type="hidden" name="highlight" value="true">
          <input type="hidden" name="dum" value="true">
          <input type="hidden" name="query" id="primoQuery-<?php echo $unique_primo_query ?>">
          <input type="hidden" name="displayField" value="all">
          <!-- Enable this if "Expand My Results" is enabled by default in Views Wizard -->
          <input type="hidden" name="pcAvailabiltyMode" value="true">
          <div class="elbsb-search-field elbsb-query-box">
            <input type="text" id="primoQueryTemp-<?php echo $unique_primo_query ?>" value="" size="35" placeholder="<?php echo $placehoder_text ?>">
          </div>
          <div class="elbsb-search-field elbsb-search-button-box">
            <!-- Search Button -->
            <input id="go" title="Search" onclick="searchPrimo('<?php echo $unique_primo_query ?>')" type="button" value="Search" alt="Search">
          </div>
        </form>
        <div class="omni-links">
          <?php if($omni_faq != "") { ?>
            <a href="<?php echo $omni_faq ?>">Omni FAQ</a>
          <?php } ?>
          <?php if($omni_guide != "") { ?>
             | <a href="<?php echo $omni_guide ?>">Omni Guide</a>
          <?php } ?>
          <?php if($research_guides != "") { ?>
             | <a href="<?php echo $research_guides ?>">Research Guides</a>
          <?php } ?>
          <a href="https://www.library.yorku.ca/web/omni-faq/">Omni FAQ</a>
           | <a href="https://researchguides.library.yorku.ca/omni">Omni Guide</a>
           | <a href="https://researchguides.library.yorku.ca">Research Guides</a>
           
        </div>
    </div>
  </div>
    
    <?php echo $args['after_widget'];
  }

	// output the option form field in admin Widgets screen
  public function form( $instance ) {
    $widget_id = $this->id;
    $title              = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $discovery_url      = ! empty( $instance['discovery_url'] ) ? $instance['discovery_url'] : 'https://<your-institute>.exlibrisgroup.com/discovery/search'; 
    $institution_id     = ! empty( $instance['institution_id'] ) ? $instance['institution_id'] : ''; 
    $tab_code           = ! empty( $instance['tab_code'] ) ? $instance['tab_code'] : 'Everything'; 
    $search_scope       = ! empty( $instance['search_scope'] ) ? $instance['search_scope'] : 'MyInst_and_CI'; 
    $unique_primo_query = ! empty( $instance['unique_primo_query'] ) ? $instance['unique_primo_query'] : $widget_id; 
    $placehoder_text    = ! empty( $instance['placehoder_text'] ) ? $instance['placehoder_text'] : '';
    $omni_faq           = ! empty( $instance['omni_faq'] ) ? $instance['omni_faq'] : '';
    $omni_guide         = ! empty( $instance['omni_guide'] ) ? $instance['omni_guide'] : '';
    $research_guides    = ! empty( $instance['research_guides'] ) ? $instance['research_guides'] : ''; 
    
    ?>
    <div class="elbsb-search-admin-area">
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'discovery_url' ); ?>">Discovery URL:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'discovery_url' ); ?>" name="<?php echo $this->get_field_name( 'discovery_url' ); ?>" value="<?php echo esc_attr( $discovery_url ); ?>" />
      </p>

      <p>
        <label for="<?php echo $this->get_field_id( 'institution_id' ); ?>">Institution ID:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'institution_id' ); ?>" name="<?php echo $this->get_field_name( 'institution_id' ); ?>" value="<?php echo esc_attr( $institution_id ); ?>" />
      </p>

      <p>
        <label for="<?php echo $this->get_field_id( 'tab_code' ); ?>">Tab Code:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'tab_code' ); ?>" name="<?php echo $this->get_field_name( 'tab_code' ); ?>" value="<?php echo esc_attr( $tab_code ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'search_scope' ); ?>">Search Scope:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'search_scope' ); ?>" name="<?php echo $this->get_field_name( 'search_scope' ); ?>" value="<?php echo esc_attr( $search_scope ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'unique_primo_query' ); ?>">Unique Primo Query Value:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'unique_primo_query' ); ?>" name="<?php echo $this->get_field_name( 'unique_primo_query' ); ?>" value="<?php echo esc_attr( $unique_primo_query ); ?>" />
      </p>    
      <p>
        <label for="<?php echo $this->get_field_id( 'placehoder_text' ); ?>">Search Box Placeholder:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'placehoder_text' ); ?>" name="<?php echo $this->get_field_name( 'placehoder_text' ); ?>" value="<?php echo esc_attr( $placehoder_text ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'omni_faq' ); ?>">Omni FAQ:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'omni_faq' ); ?>" name="<?php echo $this->get_field_name( 'omni_faq' ); ?>" value="<?php echo esc_attr( $omni_faq ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'omni_guide' ); ?>">Omni Guide:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'omni_guide' ); ?>" name="<?php echo $this->get_field_name( 'omni_guide' ); ?>" value="<?php echo esc_attr( $omni_guide ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'research_guides' ); ?>">Research Guides:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'research_guides' ); ?>" name="<?php echo $this->get_field_name( 'research_guides' ); ?>" value="<?php echo esc_attr( $research_guides ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'custom_css_class' ); ?>">Custom CSS Class:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'custom_css_class' ); ?>" name="<?php echo $this->get_field_name( 'custom_css_class' ); ?>" value="<?php echo esc_attr( $custom_css_class ); ?>" />
      </p>
  </div>    
    
    
    <?php 
  }

	// save options
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ]              = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'discovery_url' ]      = strip_tags( $new_instance[ 'discovery_url' ] );
    $instance[ 'institution_id' ]     = strip_tags( $new_instance[ 'institution_id' ] );
    $instance[ 'tab_code' ]           = strip_tags( $new_instance[ 'tab_code' ] );
    $instance[ 'search_scope' ]       = strip_tags( $new_instance[ 'search_scope' ] );
    $instance[ 'unique_primo_query' ] = strip_tags( $new_instance[ 'unique_primo_query' ] );
    $instance[ 'placehoder_text' ]    = strip_tags( $new_instance[ 'placehoder_text' ] );
    $instance[ 'omni_faq' ]           = strip_tags( $new_instance[ 'omni_faq' ] );
    $instance[ 'omni_guide' ]         = strip_tags( $new_instance[ 'omni_guide' ] );
    $instance[ 'research_guides' ]    = strip_tags( $new_instance[ 'research_guides' ] );    
    $instance[ 'custom_css_class' ]   = strip_tags( $new_instance[ 'custom_css_class' ] );
    return $instance;
  }
}
