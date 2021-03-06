<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
//dsm($title);
//	dsm($content);	

?>

<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>    
  <?php if ($user_picture || !$page || $display_submitted): ?>
    <header>     
      <?php print render($title_prefix); ?>
      <?php if (!$page): ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php  print $title; ?></a></h2>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
    </header>
  <?php endif; ?>

  <div class="content_recipe"<?php print $content_attributes; ?>>
    <?php
               
	
      // We hide the comments, tags and links now so that we can render them later.
//      hide($content['comments']);
      hide($content['links']);
      hide($content['field_tags']);
      hide($content['dieta_recipe_summary_box']);
    //  print render($content);
    ?>    
	<?php 
		$uri = $node->field_image['und']['0']['uri']; 
		$path_image = image_style_url("200x150",$uri);
	?>
  <div class="first_block">
    <div class="content_dieta_recipe">
      <div class="general_recipe">
        <div  class="image_dieta_recipe">
            <span class="photo">
              <img itemprop="resultPhoto" class="photo" src="<?php print $path_image; ?>" >	
	      </span>
        </div>
        <div class="information_dieta_recipe">
          <div class="container">
            <div class="left-container">
              <div>Количество порций:</div>
							<div id="sl"><div class="element-hidden yield value"><?php print $node->dieta_recipe_yield; ?></div></div>
            </div>
            <div class="right-container">
              <div class="time_cook">                  
                <div>Время:</div>
                <div class="passive_time_cook tooltip"><?php print $node->dieta_recipe_preptime; ?><em><i></i>Общее время приготовления</em></div>
              </div>
            </div>
          </div>
              
            <?php  print render($node->dieta_recipe_description); ?>
        </div>
       </div> 
        <div class="ingredients_dieta_recipe">
	   <?php   print $content['ingredients']; ?>
        </div>
    </div>
    
    <div class="right_sidebar_recipe">
        <div class="right_block">
          <div class="nutritional_value_receipe">
            <div class="sidebar_title">
                <h2>Пищевая ценность 1 порции</h2>
            </div>
           <div>
		 <?php print $content['nutional_value'];?>
            </div>
           </div>
       </div>
       <div class="right_block">
          <div class="price_value_receipe">
            <div class="sidebar_title">
                <h2>Стоимость <span class="value"><?php print $node->dieta_recipe_yield; ?></span> порций</h2>     
            </div>
            <div class="price_value">
              <?php print $content['field_product_price']['0']['#markup']; ?>
            </div>
          </div>	   
       </div>
         <div class="right_block">
          <div class="recommedation_receipe">
            <div class="sidebar_title">
                <h2>Рецепт рекомендуют</h2>
            </div>
          </div>
          <div class="content">
						<?php print views_embed_view('recommended', 'block'); ?>
          </div>
       </div>
         <div class="right_block">
					<?php if ($content['similar_recipes']): ?>
						<div class="similar recipes">
							<div class="sidebar_title">
									<h2>Похожие рецепты</h2>
							</div>
							<div class="content">
								<?php  print $content['similar_recipes']; ?>
							</div>
						</div>
				  <?php endif; ?>
       </div>
    </div>
  </div>
      
      
  <div class='instruction_block'>
    <?php print $content['instuction']; ?>
		<div class="social-buttons-wrapper">
			<div class="social-buttons">
				<?php print $content['like_widjet']; ?>
				<?php print render($content['plus1_widget']); ?>
			</div>
		</div>
  </div>      
   
  <?php
   //Превращаем загруженные картинки к шагам рецептов в карусель
    jcarousel_add('recipe_carousel', array('horizontal' => TRUE));
  ?>


    <?php print $content['comments_recipe']; ?>       
   
    <?php // print flag_create_link('user_recipe_book', $node->nid); ?>
  </div><!-- /.content -->

  <?php if (!empty($content['field_tags']) || !empty($content['links'])): ?>
    <footer>
      <?php print render($content['field_tags']); ?>
      <?php print render($content['links']); ?>
    </footer>
  <?php endif; ?>

  <?php // print render($content['comments']); ?>
 <div class="book_recipe">
	<div class="header_book_recipe">
		<p>Моя книга рецептов</p>
	</div>
	<ul class="content_book_recipe">		
		<li class="add_current_recipe">
			 <?php print flag_create_link('user_recipe_book', $node->nid); ?>	
	       </li>
		<li class="add_news_recipe">
			<a href="/node/add/dieta-recipe">Добавить свой рецепт</a>
	       </li>
	</div>
 </div>
</article><!-- /.node -->