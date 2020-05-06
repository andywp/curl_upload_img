<?php
function req_api($url,$data){

	

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
     curl_setopt($ch, CURLOPT_POST, 1);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /*  curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
     curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); */
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	//execute post
	$result = curl_exec($ch);
	$err = curl_error($ch);
	//close connection
	curl_close($ch);
	
	// $result=json_decode($result);
	 if ($err) {
          die( "cURL Error #:" . $err );
		}
	 
	return $result;
}


	if(isset($_POST['submit'])){
		$name=date("Ymdhis");
		$fileName        = $_FILES['file']['name'];
		$extension         = $ext ='.'.pathinfo($fileName, PATHINFO_EXTENSION);
		
		/** save image tmp*/
		move_uploaded_file($_FILES['file']['tmp_name'], 'file/'.$name.$extension);
	 	$full = realpath('file/'.$name.$extension);
		$data = array(
						'category' => $_POST['category'],
						/* 'image' => '@'.$full.';type="'.$_FILES['type'].'"' */
						'image'   =>new CURLFILE($full)
					);
		
		$data=req_api('https://api.qwords.com/upload/images',$data);
		/** delete tmp*/
		unlink($full);
	}



?>



<!DOCTYPE html>
<html>
<body>

<form  method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="fileToUpload">
    <input type="text" name="category" >
    <input type="submit" value="UploadImage" name="submit">
</form>

</body>
</html>