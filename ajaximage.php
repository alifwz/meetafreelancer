<?php
include "connection.php";
session_start();
$loginid =  end($_SESSION[SESS_MEMBER_ID]);
$path = "uploads/images/";

$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$loginid'");
$about_res = mysql_fetch_array($query);
$usercountry = $about_res[country];

if($_SESSION[countryid]==""){
	$countryid = $usercountry;
} else {
	$countryid = $_SESSION[countryid];
}

	$valid_formats = array("jpg", "png", "gif");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(2*1024*1024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							$blocation = "uploads/images/" . $actual_image_name;
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{									
									$imgquery = mysql_query("INSERT INTO freelancer_mmv_userimages (id, userid, image, type, countryid) VALUES ('', '".$loginid."','".$blocation."','1','$countryid')");
									
									echo "success";
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 2 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>