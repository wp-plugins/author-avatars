<?php

/**
 * Show Avatar Shortcode: provides a shortcode for displaying avatars for any email address/userid
 */
 
class AuthorAvatarsImageSpriting {

	/**
	 * Constructor
	 */
	 
	 
	function AuthorAvatarsImageSpriting() {
		 $AA_avatarURLarry;
		// setup global object
		
			//global URL to X and Size object
			
		// check age of image delete if old
		
		// 
		
		//add filter for get_avatar
		// add_filter( $tag, $function_to_add, $priority, $accepted_args );
		// http://codex.wordpress.org/Function_Reference/add_filter
		
		 add_filter( "get_avatar", array(&$this, "AuthorAvatars_get_avatar"), 100 ,5 );
		
	}
	
	// return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
	
	function AuthorAvatars_get_avatar($avatar, $id_or_email, $size, $default, $alt){
		
		//get image URL from $avatar
		//lets check to see what the quotes are use to wrap URL
		$AA_avatarURLQuote = substr($avatar,strpos($avatar,'src=')+4,1);

		// find SRC= for start of URL		
		$AA_avatarURL =	substr($avatar,strpos($avatar,'src='.$AA_avatarURLQuote)+5);
		// find the first qoute for end of URL
		$AA_avatarURL =	substr($AA_avatarURL,0,strpos($AA_avatarURL,$AA_avatarURLQuote));

		// 	
		global $wpdb,$AA_avatarURLarry;
		$offset = 0;
		// look in global URL to X and Size object if not found 
		 $wpdb->show_errors();
		$table_name = $wpdb->prefix . "AuthorAvatars";
		// check to see if the db arry is loaded
	//	if (empty($A_avatarURLarry)){
	//		$AA_avatarURLarry = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name"));
	//		echo "loading DB";
	//	}
		$AA_avatarURLrow = $wpdb->get_row("SELECT * FROM $table_name where url = '$AA_avatarURL' and  size = $size LIMIT 0 , 1");

		if ( count($AA_avatarURLrow) ==1){
//			echo "found";
			$AA_avatarURL = $AA_avatarURLrow->url;
			$size = $AA_avatarURLrow->size;
			$offset = $AA_avatarURLrow->offset;
		}else{
//			echo "Not Found";
		//	echo $wpdb->get_var($wpdb->prepare("SELECT COUNT(*)FROM $table_name where (STRCMP(url,'".$AA_avatarURL."') = -1) and size = $size"));
		 $rows_affected = $wpdb->insert( $table_name, array( 'url'=>$AA_avatarURL ,'size' =>$size,'offset'=>$offset));
		}
		
		
		
				// add avatar to image
					// work in one axis left to right 
					//take the size check the the curent height is enough if not increase the height of image first
					// add avatar to the end (right) of the image save to server
					// add details to global URL to X and Size object AND save to DB at this point as we don't know if this is the last add
					
	//		    $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );

		
		
		
		
		//replace the img tag with div with image as background and the offset in the style and an blank image to hold the alt
		$AA_avaterHTML = "<div style='width:".$size."px; height:".$size."px; background:url($AA_avatarURL) no-repeat ".$offset."px 0;'>
							<img src='".get_bloginfo('wpurl')."/wp-includes/images/blank.gif' height='$size' width='$size' alt='$alt' />
						</div>";
	
		//Return $avatar;
		return $AA_avaterHTML;
		
		
	}
	
	
}

?>
