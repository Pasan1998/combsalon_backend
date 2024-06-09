<?php 
include '../header.php';
include '../sidebar/management.php';


echo $catId =$_POST['catId'];

echo $sql= "SELECT * FROM herotwo WHERE heroTwoID = $catId ";
$db = dbConn();
$results = $db->query($sql);
$row = $results->fetch_assoc();

$productStatus = $row['heroTwoStatus'];

if ($productStatus == '1'){
    
    $productStatus = "2";
}else{
     $productStatus = "1";
}


echo $sqlupdate = "UPDATE herotwo  SET heroTwoStatus ='$productStatus' where heroTwoID='$catId'";

$result = $db->query($sqlupdate);

?>