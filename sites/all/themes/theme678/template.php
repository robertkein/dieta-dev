<?php
/**
 * @file
 * Contains theme override functions and process & preprocess functions for theme678
 */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('theme678_clear_registry')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

/**
 * Implements template_html_head_alter();
 *
 * Changes the default meta content-type tag to the shorter HTML5 version
 */
function theme678_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Implements template_proprocess_search_block_form().
 *
 * Changes the search form to use the HTML5 "search" input attribute
 */
function theme678_preprocess_search_block_form(&$vars) {
  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
}

/**
 * Implements template_preprocess().
 */
function theme678_preprocess(&$vars, $hook) {
  $vars['theme678_path'] = base_path() . path_to_theme();
}

/**
 * Implements template_preprocess_html().
 */
function theme678_preprocess_html(&$vars) {
  
  $vars['doctype'] = _theme678_doctype();
  $vars['rdf'] = _theme678_rdf($vars);

  // Since menu is rendered in preprocess_page we need to detect it here to add body classes
  $has_main_menu = theme_get_setting('toggle_main_menu');
  $has_secondary_menu = theme_get_setting('toggle_secondary_menu');

  /* Add extra classes to body for more flexible theming */

  if ($has_main_menu or $has_secondary_menu) {
    $vars['classes_array'][] = 'with-navigation';
  }

  if ($has_secondary_menu) {
    $vars['classes_array'][] = 'with-subnav';
  }

  if (!empty($vars['page']['featured'])) {
    $vars['classes_array'][] = 'featured';
  }

  if (!empty($vars['page']['triptych_first'])
    || !empty($vars['page']['triptych_middle'])
    || !empty($vars['page']['triptych_last'])) {
    $vars['classes_array'][] = 'triptych';
  }

  if (!empty($vars['page']['footer_firstcolumn'])
    || !empty($vars['page']['footer_secondcolumn'])
    || !empty($vars['page']['footer_thirdcolumn'])
    || !empty($vars['page']['footer_fourthcolumn'])) {
    $vars['classes_array'][] = 'footer-columns';
  }

  if ($vars['is_admin']) {
    $vars['classes_array'][] = 'admin';
  }

  if (!$vars['is_front']) {
    // Add unique classes for each page and website section
    $path = drupal_get_path_alias($_GET['q']);
    $temp = explode('/', $path, 2);
    $section = array_shift($temp);
    $page_name = array_shift($temp);

    if (isset($page_name)) {
      $vars['classes_array'][] = theme678_id_safe('page-' . $page_name);
    }

    $vars['classes_array'][] = theme678_id_safe('section-' . $section);

    // add template suggestions
    $vars['theme_hook_suggestions'][] = "page__section__" . $section;
//    $vars['theme_hook_suggestions'][] = "page__" . $page_name;

    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        if ($section == 'node') {
          array_pop($vars['classes_array']); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-add'; // Add 'section-node-add'
      } elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        if ($section == 'node') {
          array_pop($vars['classes_array']); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-' . arg(2); // Add 'section-node-edit' or 'section-node-delete'
      }
    }
  }
}

/**
 * Implements template_preprocess_page().
*/ 
function phptemplate_preprocess_page(&$vars) {
	// dsm($vars);
	 $breadcrumb = array();
         $breadcrumb[] = l('Home', '<front>'); 
         $breadcrumb[] = l('Home1', '<front>'); 
         $breadcrumb[] = l('Home', '<front>'); 

         drupal_set_breadcrumb($breadcrumb);
}

function theme678_add_products_template(&$vars){
   if(arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))) {
   	 $term = taxonomy_term_load(arg(2));	 
 	 $vars['theme_hook_suggestions'][] =  'page-vocabulary-'. $term->vid;
  }
//  dsm($vars);
}


function theme678_preprocess_page(&$vars) {
	// включаем шаблоны для страниц каждого типа материала
 if (isset($vars['node']->type)) {
    $nodetype = $vars['node']->type;
    $vars['theme_hook_suggestions'][] = 'page__node__' . $nodetype;    
 }
 
 // для страниц редактирования нод убираем левый сайдбар
 if ('node' == arg(0)) {
   if ('add' == arg(1) || 'edit' == arg(2)) {
     $vars['page']['sidebar_first'] = array();
   }
 }
 
 // добавляем препроцесс для страницы отображения рецепта
 if (isset($vars['node']->type)) {
    $nodetype = $vars['node']->type;
		if ('dieta_recipe' == $nodetype) {
			$arg = arg(2);
			if ('node' == arg(0) && empty($arg2)) {
				theme678_preprocess_DIETA_RECIPE_page($vars);
			}
		}
 }

   
 // theme678_add_products_template($vars);
  if (isset($vars['node_title'])) {
    $vars['title'] = $vars['node_title'];
  }

  // Adding classes wether #navigation is here or not
  if (!empty($vars['main_menu']) or !empty($vars['sub_menu'])) {
    $vars['classes_array'][] = 'with-navigation';
  }

  if (!empty($vars['secondary_menu'])) {
    $vars['classes_array'][] = 'with-subnav';
  }

  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($vars['title_suffix']['add_or_remove_shortcut']) && $vars['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $vars['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $vars['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $vars['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }
}

/**
 * Preprocess function for page of dieta_recipe content type
 */
function theme678_preprocess_DIETA_RECIPE_page(&$vars) {
	$node = $vars['node'];
	$field_recipe_ingestion_values = field_get_items('node', $node, 'field_recipe_ingestion');
	if (!empty($field_recipe_ingestion_values)) {
		$ingestions = array();
		$values = array();
		$field_recipe_ingestion_instance = field_info_instance('node', 'field_recipe_ingestion', 'dieta_recipe');
		$ingestions['#title'] = $field_recipe_ingestion_instance['label'] .':';
		foreach ($field_recipe_ingestion_values as $i => $arr) {
			$term = taxonomy_term_load($arr['tid']);
			$values[] = $term->name;
		}
		$ingestions['values'] = implode(', ', $values);
		$vars['page']['ingestions'] = $ingestions;
	}
	// preferences
	$field_recipe_preferences_values = field_get_items('node', $node, 'field_recipe_preferences');
	if (!empty($field_recipe_preferences_values)) {
		$preferences = array();
		$values = array();
		$field_recipe_preferences_instance = field_info_instance('node', 'field_recipe_preferences', 'dieta_recipe');
		$preferences['#title'] = $field_recipe_preferences_instance['label'] .':';
		foreach ($field_recipe_preferences_values as $i => $arr) {
			$term = taxonomy_term_load($arr['tid']);
			$values[] = $term->name;
		}
		$preferences['values'] = implode(', ', $values);
		$vars['page']['preferences'] = $preferences;
	}
}

/**
 * Implements template_preprocess_maintenance_page().
 */
function theme678_preprocess_maintenance_page(&$vars) {
  // Manually include these as they're not available outside template_preprocess_page().
  $vars['rdf_namespaces'] = drupal_get_rdf_namespaces();
  $vars['grddl_profile'] = 'http://www.w3.org/1999/xhtml/vocab';

  $vars['doctype'] = _theme678_doctype();
  $vars['rdf'] = _theme678_rdf($vars);

  if (!$vars['db_is_active']) {
    unset($vars['site_name']);
  }

  drupal_add_css(drupal_get_path('theme', 'theme678') . '/css/maintenance-page.css');
}

/**
 * Implements template_preprocess_node().
 *
 * Adds extra classes to node container for advanced theming
 */

function theme678_add_nutrion_in_recipe(&$vars){
     $node = $vars['content'];
     $nutional_value = "<ul>";
		 $nutional_value .= "<li class='field-proteins'>";
     $nutional_value .=		"<span class='title'>";
     $nutional_value .=		$vars['content']['field_proteins']['#title'];
     $nutional_value .=		": </span>";
     $nutional_value .=		"<span class='value'>" .  $vars['content']['field_proteins']['0']['#markup'] . "</span>";
     $nutional_value .= "</li>";
		 $nutional_value .= "<li class='field-fats'>";
     $nutional_value .=		"<span class='title'>";
     $nutional_value .=		$vars['content']['field_fats']['#title'];
     $nutional_value .=		": </span>";
     $nutional_value .=		"<span class='value'>" .  $vars['content']['field_fats']['0']['#markup'] . "</span>";
     $nutional_value .= "</li>";
		 $nutional_value .= "<li class='field-carbohydrates'>";
     $nutional_value .=		"<span class='title'>";
     $nutional_value .=		$vars['content']['field_carbohydrates']['#title'];
     $nutional_value .=		": </span>";
     $nutional_value .=		"<span class='value'>" . $vars['content']['field_carbohydrates']['0']['#markup'] . "</span>";
     $nutional_value .= "</li>";
     $nutional_value .= "<li class='field-caloric-effect'>";
     $nutional_value .=		"<span class='title'>";
     $nutional_value .=		$vars['content']['field_caloric_effect']['#title'];
     $nutional_value .=		": </span>";
     $nutional_value .=		"<span class='value'>" . $vars['content']['field_caloric_effect']['0']['#markup'] . "</span>";
     $nutional_value .= "</li>";
     $nutional_value .= "</ul>";
     $vars['content']['nutional_value'] = $nutional_value;
}

function theme678_add_comments_in_recipe(&$vars){
  $node = $vars['node']; 
  $path = "/node/".$node->nid."/comments";
  $comments  = "<div class='comments_block'><div class='prigot'>Комментарии</div>";
  $comments .=    "<div class='content'><div class='all_comments'><a href='$path' class='ajax tab-comments'>Читать все ".$node->comment_count."  комментария ></a></div>";
//  $comments .=    "<div class='button_comments'><a href='$path' class='ajax tab-comments'>Оставить комментарий</a></div>";
  $comments .= "</div></div>";     
  $vars['content']['comments_recipe'] = $comments . render($vars['content']['comments']['comment_form']);
}

function theme678_add_instuction_in_recipe(&$vars){
  $node = $vars['node']; 
	$gallery = "<div class='carousel_block'>".theme678_add_gallery_in_step_instruction($node)."</div></div>";
  $instuction_markup = "<div class='prigot'>Приготовление</div><ol class='instructions' itemprop='recipeInstructions'>";  
  if (!empty($node->field_recipe_steps['und'])) {
    foreach($node->field_recipe_steps['und'] as $index=>$collection_themes){ 
        $instuction_markup .= "<li class='instruction step_".$index."'>";
        $field_collection = field_collection_item_load($collection_themes['value']);
        $description = $field_collection->field_recipe_step_desc['und']['0']['value'];
        $instuction_markup .= $description;      
        $instuction_markup .= "<div class='tooltip_carousel'><img src='/sites/all/themes/theme678/images/photo_step.png' width='16' height='16'>";      
        $instuction_markup .= $gallery;
        $instuction_markup .= "</li>";     
    }
  }
 
  $instuction_markup .= "</ol>";
  $vars['content']['instuction'] = $instuction_markup; 
}


function theme678_add_gallery_in_step_instruction($node){
  $gallery_markup = "<ul class='recipe_carousel jcarousel-skin-default'>";
  foreach($node->field_recipe_steps['und'] as $index=>$collection_themes){      
     $field_collection = field_collection_item_load($collection_themes['value']);
     $field_recipe_step_image = field_get_items('field_collection_item', $field_collection, 'field_recipe_step_image');
     $uri_source = $field_recipe_step_image['0']['uri'];
     $url_source = image_style_url('720x550',$uri_source);   
     
     $uri_preview = $field_recipe_step_image['0']['uri']; 
     $url_preview = image_style_url('260x178',$uri_preview);
     
     $field_recipe_step_desc = field_get_items('field_collection_item', $field_collection, 'field_recipe_step_desc');
     $description = $field_recipe_step_desc['0']['value'];
     $gallery_markup .=  "<li><a title='$description' href='$url_source' rel='lightbox[plants]'>
      <img src='$url_preview' alt='Фотография' /></a></li>";   
  }
  $gallery_markup .= "</ul>";
  return  $gallery_markup;
}


function theme678_add_ingredient_in_recipe(&$vars){
  $node = $vars['node'];
  $instuction = array();

  $table_ing = "<div class='title'><h2>Ингредиенты</h2></div><table>";
  $odd = true;
  foreach($node->dieta_recipe_ingredients['ing'] as $index=>$collection_themes){
    if($odd){
	    $class="odd";       
    }
    else{
           $class="";       
    }   
	//Получаем список абревиатур типов измерения ингредиентов
     $unit_list = dieta_recipe_get_units();    
     $abbreviation = " ".$unit_list[$collection_themes['unit_key']]->abbreviation; 
     //Составляем таблицу типа ингредиентов 
		 $table_ing.="<tr class='$class ingredient' itemprop='ingredients' id='ingredient".$collection_themes['ri_id']."'>";
		 if (!empty($collection_themes['note'])) {
        $tooltip = '<em><i></i>'.$collection_themes['note'].'</em>';
		 }
		 else {
			 $tooltip = '';
		 }
		 $table_ing.="<td style='text-align:left;'><div class='tooltip'><span class='name'>".$collection_themes['name']."</span>$tooltip</div></td>";     
     $table_ing.="<td style='text-align:right;'><span class='quantity amount'>".$collection_themes['quantity']."</span> <span class='type units'>".$abbreviation."</span></td>";
     $table_ing.="</tr>";
     $odd = !$odd;
  }
  $table_ing .= "</table>";
  $vars['content']['ingredients']  =  $table_ing;
}

function theme678_add_like_widjet_in_recipe(&$vars)
{
 $like_widjet = 
     '<div class="vk-wrapper"><div id="vk_like"></div>
					<script type="text/javascript">
					 VK.Widgets.Like("vk_like", {type: "mini", height: 20});
					</script>
			</div>
			<div class="ok-wrapper">
					<div id="ok_shareWidget"></div>
					<script>
					!function (d, id, did, st) {
					 var js = d.createElement("script");
					 js.src = "http://connect.ok.ru/connect.js";
					 js.onload = js.onreadystatechange = function () {
					 if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
						if (!this.executed) {
							this.executed = true;
							setTimeout(function () {
								OK.CONNECT.insertShareWidget(id,did,st);
							}, 0);
						}
					 }};
					 d.documentElement.appendChild(js);
					}(document,"ok_shareWidget","http://dieta-abc.ru","{width:170,height:30,st:\'rounded\',sz:20,ck:3}");
					</script>
			</div>

			<div class="fb-wrapper">
					<div class="fb-like" data-href="http://dieta-abc.ru/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
			</div>';
	$vars['content']['like_widjet'] = $like_widjet;
}

function theme678_preprocess_node(&$vars) {
 $type_node = $vars['node']->type;
 if ($type_node == "dieta_recipe"){
	 theme678_add_instuction_in_recipe($vars);
   theme678_add_ingredient_in_recipe($vars);
   theme678_add_comments_in_recipe($vars);
   theme678_add_nutrion_in_recipe($vars);
   theme678_add_like_widjet_in_recipe($vars);
	 
	 drupal_add_js(libraries_get_path('jquery_ui') . '/jquery-ui.js');
	 drupal_add_css(libraries_get_path('jquery_ui') . '/jquery-ui.css');
	 $theme_path = drupal_get_path('theme', 'theme678');
	 drupal_add_js($theme_path . '/js/recipe_slider.js');
	 drupal_add_js($theme_path . '/js/recipe_similar_recipes.js');
	 
 }
  // Striping class
  $vars['classes_array'][] = 'node-' . $vars['zebra'];

  // Node is published
 // $vars['classes_array'][] = ($vars['status']) ? 'published' : 'unpublished';

  // Node has comments?
  $vars['classes_array'][] = ($vars['comment']) ? 'with-comments' : 'no-comments';

  if ($vars['sticky']) {
    $vars['classes_array'][] = 'sticky'; // Node is sticky
  }

  if ($vars['promote']) {
    $vars['classes_array'][] = 'promote'; // Node is promoted to front page
  }

  if ($vars['teaser']) {
    $vars['classes_array'][] = 'node-teaser'; // Node is displayed as teaser.
  }

  if ($vars['uid'] && $vars['uid'] === $GLOBALS['user']->uid) {
    $classes[] = 'node-mine'; // Node is authored by current user.
  }
  
  $vars['submitted'] = t('!username', array('!username' => $vars['name']));
  $vars['submitted_date'] = t('!datetime', array('!datetime' => $vars['date']));
  $vars['submitted_pubdate'] = format_date($vars['created'], 'custom', 'Y-m-d\TH:i:s');
  
  if ($vars['view_mode'] == 'full' && node_is_page($vars['node'])) {
    $vars['classes_array'][] = 'node-full';
  }
}

/**
 * Implements template_preprocess_block().
 */
function theme678_preprocess_block(&$vars, $hook) {
  // Add a striping class.
  $vars['classes_array'][] = 'block-' . $vars['zebra'];

  // In the header region visually hide block titles.
 /*if ($vars['block']->region == 'header') {
    $vars['title_attributes_array']['class'][] = 'element-invisible';
  }*/
}

/**
 * Implements theme_menu_tree().
 */
function theme678_menu_tree($vars) {
  return '<ul class="menu clearfix">' . $vars['tree'] . '</ul>';
}

/**
 * Implements theme_field__field_type().
 */
function theme678_field__taxonomy_term_reference($vars) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$vars['label_hidden']) {
    $output .= '<h3 class="field-label">' . $vars['label'] . ': </h3>';
  }

  // Render the items.
  $output .= ( $vars['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
  foreach ($vars['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $vars['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }
  $output .= '</ul>';

  // Render the top-level DIV.
  $output = '<div class="' . $vars['classes'] . (!in_array('clearfix', $vars['classes_array']) ? ' clearfix' : '') . '">' . $output . '</div>';

  return $output;
}

/**
 *  Return a themed breadcrumb trail
 */
function theme678_breadcrumb($vars) {
  
  $breadcrumb = isset($vars['breadcrumb']) ? $vars['breadcrumb'] : array();

// Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('theme678_breadcrumb_display');
  if ($show_breadcrumb == 'yes') {
  
	  if (theme_get_setting('theme678_breadcrumb_hideonlyfront')) {
		$condition = count($breadcrumb) > 1;
	  } else {
		$condition = !empty($breadcrumb);
	  }
	  
	  if(theme_get_setting('theme678_breadcrumb_showtitle')) {
		$title = drupal_get_title();
		if(!empty($title)) {
		  $condition = true;
		  $breadcrumb[] = $title;
		}
	  }
	  
	  $separator = theme_get_setting('theme678_breadcrumb_separator');
	
	  if (!$separator) {
		$separator = '»';
	  }
	  
	  if ($condition) {
		return implode(" {$separator} ", $breadcrumb);
	  }
  }
}


/**
 * Determine whether to show floating tabs
 *
 * @return bool
 */
function theme678_tabs_float() {
  $float = (bool) theme_get_setting('theme678_tabs_float');
  $float_node = (bool) theme_get_setting('theme678_tabs_node');
  $is_node = (arg(0) === 'node' && is_numeric(arg(1)));

  if ($float) {
    return ($float_node) ? $is_node : TRUE;
  }

  return FALSE;
}

/*
 * 	Converts a string to a suitable html ID attribute.
 *  Taken from "basic"
 *
 * 	 http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 * 	 valid ID attribute in HTML. This function:
 *
 * 	- Ensure an ID starts with an alpha character by optionally adding an 'n'.
 * 	- Replaces any character except A-Z, numbers, and underscores with dashes.
 * 	- Converts entire string to lowercase.
 *
 * 	@param $string
 * 	  The string
 * 	@return
 * 	  The converted string
 */

function theme678_id_safe($string) {
 /* // Strip accents
  $accents = '/&([A-Za-z]{1,2})(tilde|grave|acute|circ|cedil|uml|lig);/';
  $string = preg_replace($accents, '$1', htmlentities(utf8_decode($string)));
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  // If the first character is not a-z, add 'n' in front.
 // Don't use ctype_alpha since its locale aware.
  if (!ctype_lower($string{0})) {
    $string = 'id' . $string;
  }*/
  return $string;
}

/**
 * Generate doctype for templates
 */
function _theme678_doctype() {
  return (module_exists('rdf')) ? '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML+RDFa 1.1//EN"' . "\n" . '"http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">' : '<!DOCTYPE html>' . "\n";
}

/**
 * Generate RDF object for templates
 *
 * Uses RDFa attributes if the RDF module is enabled
 * Lifted from Adaptivetheme for D7, full credit to Jeff Burnz
 * ref: http://drupal.org/node/887600
 *
 * @param array $vars
 */
function _theme678_rdf($vars) {
  $rdf = new stdClass();

  if (module_exists('rdf')) {
    $rdf->version = 'version="HTML+RDFa 1.1"';
    $rdf->namespaces = $vars['rdf_namespaces'];
    $rdf->profile = ' profile="' . $vars['grddl_profile'] . '"';
  } else {
    $rdf->version = '';
    $rdf->namespaces = '';
    $rdf->profile = '';
  }

  return $rdf;
}

/**
 * Generate the HTML output for a menu link and submenu.
 *
 * @param $vars
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return
 *   A themed HTML string.
 *
 * @ingroup themeable
 */
function theme678_menu_link(array $vars) {
  $element = $vars['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  // Adding a class depending on the TITLE of the link (not constant)
  $element['#attributes']['class'][] = theme678_id_safe($element['#title']);
  // Adding a class depending on the ID of the link (constant)
  $element['#attributes']['class'][] = 'mid-' . $element['#original_link']['mlid'];
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Override or insert variables into theme_menu_local_task().
 */
function theme678_preprocess_menu_local_task(&$vars) {
  $link = & $vars['element']['#link'];

  // If the link does not contain HTML already, check_plain() it now.
  // After we set 'html'=TRUE the link will not be sanitized by l().
  if (empty($link['localized_options']['html'])) {
    $link['title'] = check_plain($link['title']);
  }

  $link['localized_options']['html'] = TRUE;
  $link['title'] = '<span class="tab">' . $link['title'] . '</span>';
}

/**
 *  Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function theme678_menu_local_tasks(&$vars) {
  $output = '';

  if (!empty($vars['primary'])) {
    $vars['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $vars['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $vars['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($vars['primary']);
  }

  if (!empty($vars['secondary'])) {
    $vars['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $vars['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $vars['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($vars['secondary']);
  }

  return $output;
}

/*
 * Implements hook_theme().
 */
function theme678_theme() {
  return array(
    'dieta_recipe_node_form' => array(
      'render element' => 'form',
      'template' => 'dieta_recipe-node-form',
      'path' => drupal_get_path('theme', 'theme678') . '/templates',
    ),
  );
}

/*
 * Implements hook_preprocess_HOOK().
 */
function theme678_preprocess_dieta_recipe_node_form(&$vars) {
 // dsm($vars);
  $theme_path = drupal_get_path('theme', 'theme678');
  drupal_add_css($theme_path . '/css/dieta_recipe_node_form.css');
//  drupal_add_js($theme_path . '/js/hint_inside_form_elements.js');
  
  // подключим библиотеку для темизации селекта
  $lab_path = libraries_get_path('chosen-master');
  drupal_add_js($lab_path . '/public/chosen.jquery.js');
  drupal_add_css($lab_path . '/public/chosen.css');
  drupal_add_js($theme_path . '/js/recipe_form_stuff.js');
  drupal_add_css($theme_path . '/css/recipe_form_chosen.css');

	if (isset($vars['form']['#node']->nid) && !empty($vars['form']['#node']->nid)) {
		drupal_set_title('Добавьте ваш рецепт');
	}
	else {
		drupal_set_title('Редактирование рецепта "'.$vars['form']['#node']->title.'"');
	}
}



