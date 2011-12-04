<?php

/**
 * Show Avatar Shortcode: provides a shortcode for displaying avatars for any email address/userid
 */
 
class AuthorAvatarsImageSpriting {

	/**
	 * Constructor
	 */
	 
	 
	function AuthorAvatarsImageSpriting() {
		global $wpdb;
		 $AA_avatarURLarry;
		// setup global objects
		$this->SliceImageFilename = "/AuthorAvatarsImageSlice.jpg";
		$this->SliceImageFileLocation = dirname(dirname(__FILE__)).$this->SliceImageFilename;
		$this->SliceImageURL =  WP_PLUGIN_URL . '/'.basename(dirname(dirname(__FILE__))).$this->SliceImageFilename;
		$this->table_name = $wpdb->prefix . "AuthorAvatars";		
		
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
		global $wpdb,$AA_avatarURLarry,$SliceImagelocation,$table_name;
		$offset = 0;
		// look in global URL to X and Size object if not found 
		 $wpdb->show_errors();
		// check to see if the db arry is loaded
	//	if (empty($A_avatarURLarry)){
	//		$AA_avatarURLarry = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name"));
	//		echo "loading DB";
	//	}

		$AA_avatarURLrow = $wpdb->get_row("SELECT * FROM $this->table_name where url = '$AA_avatarURL' and  size = $size LIMIT 0 , 1");

		if ( count($AA_avatarURLrow) == 1){
//			echo "found";
			// do we have an image check
			

			if (file_exists($this->SliceImageFileLocation)){
				$offset = $AA_avatarURLrow->offset;
			}else{
				// create one use the add function as it check for file set the file missing to true to save an second file check				 
				$offset = $this->AddAvatarToSlice($AA_avatarURLrow->url,$AA_avatarURLrow->size,true,$AA_avatarURLrow->offset);		
			}
			
			$AA_avatarURL = $AA_avatarURLrow->url;
			$size = $AA_avatarURLrow->size;
		
		}else{
//			echo "Not Found";
			$offset = $this->AddAvatarToSlice($AA_avatarURL,$size)	;

		}
		
		
		
				// add avatar to image
					// work in one axis left to right 
					//take the size check the the curent height is enough if not increase the height of image first
					// add avatar to the end (right) of the image save to server
					// add details to global URL to X and Size object AND save to DB at this point as we don't know if this is the last add
					
	//		    $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );

		
		
		
		
		//replace the img tag with div with image as background and the offset in the style and an blank image to hold the alt
		$AA_avaterHTML = "<div style='width:".$size."px; height:".$size."px; background:url($this->SliceImageURL) no-repeat ".$offset."px 0;'>
							<img src='".get_bloginfo('wpurl')."/wp-includes/images/blank.gif' height='$size' width='$size' alt='$alt' />
						</div>";
	
		//Return $avatar;
		return $AA_avaterHTML;
		
		
	}
	function AddAvatarToSlice($AA_avatarURL,$AA_size,$fileMissing = false,$AA_avatarURLrowOffset = 0){
	global $wpdb;	
	echo("geting image ");
	
	
			//	echo $wpdb->get_var($wpdb->prepare("SELECT COUNT(*)FROM $table_name where (STRCMP(url,'".$AA_avatarURL."') = -1) and size = $size"));
		
		//Do we have an Cached image
	

			
			list($width, $height, $type) = getimagesize($AA_avatarURL); 
			
			switch ($type) { 
				case "image/gif": 
					$img = imagecreatefromgif($AA_avatarURL); 
					break; 
				case "image/jpeg": 
					$img = imagecreatefromjpeg($AA_avatarURL);
					break; 
				case "image/png": 
					$img = imagecreatefrompng($AA_avatarURL);
					break; 
				case "image/bmp": 
					$img = imagecreatefromwbmp($AA_avatarURL);
					break; 
			} 
		
			$imageResized = imagecreatetruecolor($AA_size,$AA_size); 
			imagecopyresampled($imageResized, $img, 0, 0, 0, 0, $AA_size,$AA_size, $width, $height);


		if ($fileMissing || file_exists ($this->SliceImageFileLocation)){
			
			echo(" file missing ");
			// Save the image 
			imagejpeg($imageResized, $this->SliceImageFileLocation);
			echo("new file Made ");
		}else{
			echo "Add to Image";
			 // add to Image
			 list($CurrentWidth, $CurrentHeight) = getimagesize( $this->SliceImageFileLocation); 
			 $CurrentImg = imagecreatefromjpeg($this->SliceImageFileLocation);
			 
			 if ($CurrentHeight < $AA_size ){
				$newCurrentHeight =  $AA_size;
			 }else{
				 $newCurrentHeight =  $CurrentHeight;
			 }
		 	$newCurrentWidth = $CurrentWidth + $AA_size;
			 //reset height of current image
			$NewSlice = imagecreatetruecolor($newCurrentWidth,$newCurrentHeight); 
			imagecopyresampled($NewSlice, $CurrentImg, 0, 0, 0, 0, $newCurrentWidth,$newCurrentHeight, $width, $height);
			
			imagecopymerge($NewSlice,$imageResized,$CurrentWidth,0,0,0,$AA_size,$AA_size,100);
			imagejpeg($NewSlice, $this->SliceImageFileLocation);
			
			imagedestroy($NewSlice);
		}
		imagedestroy($imageResized);
		 
				
		// Free up memory
		imagedestroy($img);
		// how old is it
	
	
	// update DB with offsett for image
	
		if ($AA_avatarURLrow == 1 ){
		// update record with new Offset
		$offset = 0 ;// inage width;
			$rows_affected = $wpdb->update( $this->table_name, array( 'url'=>$AA_avatarURL ,'size' =>$AA_size,'offset'=>$offset));	
		}else{
			$offset = 0 ; // new image therefor the image at 0
		//insert new record	
		 $rows_affected = $wpdb->insert( $this->table_name, array( 'url'=>$AA_avatarURL ,'size' =>$AA_size,'offset'=>$offset));	
		 
		
		}
	
	return $offset;
	}
	
	function AA_resizeImage($originalImage,$toWidth,$toHeight) 
	{ 
	var_dump($originalImage);
		list($width, $height) = getimagesize($originalImage); 
		$xscale=$width/$toWidth; 
		$yscale=$height/$toHeight; 
	
		if ($yscale>$xscale){ 
			$new_width = round($width * (1/$yscale)); 
			$new_height = round($height * (1/$yscale)); 
		} 
		else { 
			$new_width = round($width * (1/$xscale)); 
			$new_height = round($height * (1/$xscale)); 
		} 
		
		
		$imageResized = imagecreatetruecolor($new_width, $new_height); 
		$imageTmp     = imagecreatefromjpeg ($originalImage); 
		imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
	
		return $imageResized; 
		
	
	}
}

?>
