<?php 
/*
	Copyright (C) 2012 Vernon Systems Limited

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
if ($css_class == "") {
	echo '<div class="ehive-object-detail">';
} else {
	echo '<div class="ehive-object-detail '.$css_class.'">';
}
	if (!isset($eHiveApiErrorMessage)) {
		$galleryInlineStyleEnabled = false;
		$imageInlineStyleEnabled = false;
		$galleryInlineStyle = '';
		$imageInlineStyle = '';
		
		if (isset($options['gallery_background_colour_enabled']) && $options['gallery_background_colour_enabled'] == 'on') {
			$galleryInlineStyle .= "background-color:{$options['gallery_background_colour']}; ";
			$galleryInlineStyleEnabled = true;
		}
		if (isset($options['gallery_border_colour_enabled']) && $options['gallery_border_colour_enabled'] == 'on' && $options['gallery_border_width'] > 0) {
			$galleryInlineStyle .= "border-style:solid; border-color:{$options['gallery_border_colour']}; ";
			$galleryInlineStyle .= "border-width:{$options['gallery_border_width']}px; *margin:-{$options['gallery_border_width']}px; ";
			$galleryInlineStyleEnabled = true;
		}
		if (isset($options['image_background_colour_enabled']) && $options['image_background_colour_enabled'] == 'on') {
			$imageInlineStyle .= "background:{$options['image_background_colour']}; ";
			$imageInlineStyleEnabled = true;
		}
		if (isset($options['image_padding_enabled']) && $options['image_padding_enabled'] == 'on') {
			$imageInlineStyle .= "padding:{$options['image_padding']}px; ";
			$imageInlineStyleEnabled = true;
		}
		if (isset($options['image_border_colour_enabled']) && $options['image_border_colour_enabled'] == 'on' && $options['image_border_width'] > 0) {
			$imageInlineStyle .= "border-style:solid; border-color:{$options['image_border_colour']}; ";
			$imageInlineStyle .= "border-width:{$options['image_border_width']}px; ";
			$imageInlineStyleEnabled = true;
		}
		
		if($galleryInlineStyleEnabled) {
			$galleryInlineStyle = " style='$galleryInlineStyle'";
		}
		if($imageInlineStyleEnabled) {
			$imageInlineStyle = " style='$imageInlineStyle'";
		}
	
		echo '<div class="ehive-item">';
		
		$imageMediaSet = $object->getMediaSetByIdentifier('image');	
		
		if (isset($imageMediaSet)){
			echo '<div class="ehive-item-image-wrap">';
			$numberOfImages = count($imageMediaSet->mediaRows);		
	
			if ( $numberOfImages == 1) {
			
				$mediaRow = $imageMediaSet->mediaRows[0];
				
				$largeImageMedia = $mediaRow->getMediaByIdentifier('image_l');
				$mediumImageMedia = $mediaRow->getMediaByIdentifier('image_m');
				
				echo ("<div class='ehive-object-single-image' $galleryInlineStyle>");
					echo '<div class="large-image-container">';
						echo ('<a rel="prettyPhoto" href="'.$largeImageMedia->getMediaAttribute('url').'" title="'.$largeImageMedia->getMediaAttribute('title').'" target="_blank"><img src="'.$mediumImageMedia->getMediaAttribute('url').'" alt="'.$mediumImageMedia->getMediaAttribute('title').'" title="'.$mediumImageMedia->getMediaAttribute('title').'" '.$imageInlineStyle.'/></a>');
					echo '</div>';
					echo ('<a rel="prettyPhoto" class="ehive-magnifying-glass" href="'.$largeImageMedia->getMediaAttribute('url').'" title="'.$largeImageMedia->getMediaAttribute('title').'"></a>');
				echo ('</div>');			
			}
			
			if ($numberOfImages > 1 & $numberOfImages <= 4) {
			
				$mediaRow = $imageMediaSet->mediaRows[0];
				
				$largeImageMedia = $mediaRow->getMediaByIdentifier('image_l');
				$mediumImageMedia = $mediaRow->getMediaByIdentifier('image_m');							
				
				echo "<div class='ehive-object-multiple-images' $galleryInlineStyle>";
				echo '<div class="large-image-container">';
					echo '<a class="large-image" href="'.$largeImageMedia->getMediaAttribute('url').'" rel="prettyPhoto" title="'.$largeImageMedia->getMediaAttribute('title').'"><img class="large-image" src="'.$mediumImageMedia->getMediaAttribute('url').'" alt="" '.$imageInlineStyle.'/></a>';
				echo '</div>';
				
				echo '<div class="ehive-images-tiny-square">';
				foreach ($imageMediaSet->mediaRows as $mediaRow) {			
					$tsImageMedia = $mediaRow->getMediaByIdentifier('image_ts');
					echo '<div class="ehive-images-tiny-square-image-wrap" >';
						echo '<img src="'.$tsImageMedia->getMediaAttribute('url').'" alt="'.$tsImageMedia->getMediaAttribute('title').'" title="'.$tsImageMedia->getMediaAttribute('title').'" width="'.$tsImageMedia->getMediaAttribute('width').'" height="'.$tsImageMedia->getMediaAttribute('height').'" '.$imageInlineStyle.'/>';
					echo '</div>';
				}
				
				echo '</div>';
				echo '<a class ="ehive-magnifying-glass png-fix" href="'.$largeImageMedia->getMediaAttribute('url').'" rel="prettyPhoto" title="'.$largeImageMedia->getMediaAttribute('title').'"></a>';
				echo '</div>';			
			}
			
			if ($numberOfImages > 4) {
			    
				$mediaRow = $imageMediaSet->mediaRows[0];
					
				$largeImageMedia = $mediaRow->getMediaByIdentifier('image_l');
				$mediumImageMedia = $mediaRow->getMediaByIdentifier('image_m');
								
				echo "<div class='ehive-object-carousel-images' $galleryInlineStyle>";
			
				echo '<div class="large-image-container">';
				echo '<a class="large-image" href="'.$largeImageMedia->getMediaAttribute('url').'" rel="prettyPhoto" title="'.$largeImageMedia->getMediaAttribute('title').'"><img class="large-image" src="'.$mediumImageMedia->getMediaAttribute('url').'" alt="" '.$imageInlineStyle.'/></a>';
				echo '</div>';
					
				echo '<a class ="ehive-magnifying-glass png-fix" href="'.$largeImageMedia->getMediaAttribute('url').'" rel="prettyPhoto" title="'.$largeImageMedia->getMediaAttribute('title').'"></a>';
			
				echo '<div class="widget">';
					echo '<div class="widget_style">';
					
						echo '<ul>';
						foreach ($imageMediaSet->mediaRows as $mediaRow) {			
							$tsImageMedia = $mediaRow->getMediaByIdentifier('image_ts');			
							echo '<li>
									<img class="ehive-object-detail-image" src="'.$tsImageMedia->getMediaAttribute('url').'" alt="'.$tsImageMedia->getMediaAttribute('title').'" title="'.$tsImageMedia->getMediaAttribute('title').'" width="'.$tsImageMedia->getMediaAttribute('width').'" height="'.$tsImageMedia->getMediaAttribute('height').'" '.$imageInlineStyle.'/>
								  </li>';
						}
						
						echo'</ul>';
					echo'</div>';
				echo'</div>';
				
					echo '<div class="ehive-carousel-navigation">';
					echo '<a href="#" class="previous png-fix"></a>';
					echo '<a href="#" class="next png-fix"></a>';
					echo '</div>';
				
				echo'</div>';	
			}	
			echo'</div>';
		}
		?>
	                 
	<div class="ehive-item-metadata-wrap">
	
		<?php if ( $public_profile_name_enabled == 'on' ) {?>
		 <p class="ehive-field ehive-identifier-public_profile_name">
		   	<span class="ehive-field-label">From:</span>                 
		   	<a href="<?php echo $eHiveAccess->getAccountDetailsPageLink( $object->accountId )?>"><?php echo $account->publicProfileName ?></a>
		</p>
		<?php } ?>
			
		<?php  
		foreach( $object->fieldSets as $fieldSet ) {
			foreach( $fieldSet->fieldRows as $fieldRow ) {			
				foreach( $fieldRow->fields as $field ) {
		
					$identifier = $field->identifier;
					$label = $field->getFieldAttribute("label");
					$value = nl2br( $field->getFieldAttribute("value") );
					
					if ($label) { 
						echo ('<p class="ehive-field ehive-identifier-'.$identifier.'">');					
							echo ('<span class="ehive-field-label">'.$label.'</span>');
							echo $value;
						echo ('</p>');
					} 				
				}			
			}
		} 		
		?>
		</div>
	</div>
	</div>
	<?php } else { ?>	
		<p class='ehive-error-message ehive-objects-details-error'><?php echo $eHiveApiErrorMessage; ?></p>	
	<?php }?>
</div>