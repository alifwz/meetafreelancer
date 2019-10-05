<?php 
include "connection.php";

$categoryId = $_POST['categoryId'];
echo "<option>Select SubCategory</option>";
$res= mysql_query("SELECT * from freelancer_mmv_filter where parent_id='$categoryId' AND status='1'"); 
while($datas = mysql_fetch_array($res))
{
	echo '<option value='.$datas[filter_id].'>'.$datas[title].'</option>';
}
?>