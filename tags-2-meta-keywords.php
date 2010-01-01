<?php
/*
Plugin Name: Tags 2 Meta Keywords
Version: 1.0
Plugin URI: http://www.monkey-business.biz/131/wordpress-plugin-tags-2-meta-keywords/
Description: ENGLISH: Generates meta keywords automatically from your post tags. A single post or page get up to 10 tags as meta keywords. In categorie and archive view you get the 10 most used tags in categorie or archive as meta keywords. On the main page you get the 10 most used tags as meta keywords. This plugin doesn't need any configuration. It just works. ;) | DEUTSCH: Generiert die Meta Keywords automatisch aus deinen Artikel Schlagworten. Ein einzelner Artikel oder eine Seite hat bis zu 10 Schlagworte als Meta Keywords. In der Kategorie und Archiv Ansicht werden bis zu 10 der meistengenutzten Schlagworte in der Kategorie oder dem Archiv als Meta Keywords eingesetzt. Auf der Hauptseite werden die 10 meistgenutzten Schlagworte als Meta Keywords verwendet. Dieses Plugin benötigt keinerlei Konfiguration. Es funktioniert einfach. ;) 
Author: Tobias Jäck, "Loaden", loaden@einmalmitprofis.com
Author URI: http://www.monkey-business.biz/
*/

	function tags2meta_keywords() {

		$metatags = array();
		$tags = array();	
	
		if ((is_single()) || (is_category()) || (is_archive()) || (is_page())) {
			
			if (have_posts()) {
			
				while (have_posts()) {
				 
					the_post();
					$posttags = get_the_tags();
					
					if (is_array($posttags)) {

						foreach ($posttags as $tag) {
						
							if (!isset($tags[$tag->name])) {

								$tags[strtolower(str_replace('"', "'", html_entity_decode($tag->name)))] = $tag->count;
							}
						}
					}	
				}
			}			
			arsort($tags);
			$metatags = array_keys(array_slice($tags, 0, 10));
					
		} else {

			$tags = get_tags(array('orderby' => 'count',  'order' => 'DESC', 'number' => 10));
			
			if (is_array($tags)) {
				
				foreach ($tags as $tag) {
				
					$metatags[$tag->term_id] = strtolower(str_replace('"', "'", html_entity_decode($tag->name)));
				}
			}
		}
		
		if (is_array($metatags)) {
		
			echo "\n".'<meta name="keywords" content="'.implode(', ', $metatags).'" />';	
		}				
	}
	add_action('wp_head', 'tags2meta_keywords');
	
?>