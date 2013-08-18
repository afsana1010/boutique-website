<?php
	
function get_extension($filename) 
    {
	   $x = explode('.', $filename);
	   return '.'.end($x);
	}

if (!empty($_FILES)) 
	{
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$filetype = $_FILES['Filedata']['type'];
		$targetPath = '../uploads/advertisement_images/';
		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
		$extension = get_extension($_FILES['Filedata']['name']);
		
		$image_file = uniqid().$extension;
		$dest       = $targetPath.$image_file; 
		$file_size  = $_FILES['Filedata']['size'];
			
		move_uploaded_file($tempFile,$dest);
		
		echo $image_file;
	}
?>