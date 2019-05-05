
<?php
require_once ("front/config/class.connect.php");
$bdd = new db();

    if(!empty($_POST["keyword"]))
    {
       
       if(is_numeric($_POST["keyword"]))
       {
        $query ="SELECT * FROM wp_zyga_clinic WHERE clinic_zip like '" . $_POST["keyword"] . "%'";
       }else{
        $query ="SELECT * FROM wp_zyga_clinic WHERE clinic_city like '" . $_POST["keyword"] . "%' OR clinic_state like '" . $_POST["keyword"] . "%' OR clinic_zip like '" . $_POST["keyword"] . "%' OR state_name like '" . $_POST["keyword"] . "%'";
       }
       
       
      $result = $bdd->search($query);
     if(!empty($result))
     {
    ?>
<style>
    #country-list {
    padding: 10px 15px 10px 15px;
    text-align: justify;
    background: #fff;
    border-bottom: NONE!IMPORTANT;
    border-top: NONE!IMPORTANT;
    border-radius: 4px;
    width: 45.8%;
    margin-left: 10px;
    position: absolute!IMPORTANT;
}
#country-list li {
    text-align: left!important;
    padding: 5px 0px 5px 10px;
    border-bottom: 1px solid #eaeaea;
}
</style>
    <ul id="country-list">
    <?php foreach($result as $data){ 
	 if($data["clinic_state"]){?>
    <li id="res" style="cursor: pointer;" onClick="selectVal('<?php echo $data["clinic_zip"];?>');"><?php echo $data["state_name"].",".$data["clinic_city"].",".$data["clinic_zip"];?></li>
   <?php }elseif($data["clinic_city"]){ ?>
    <li id="res" style="cursor: pointer;" onClick="selectVal('<?php echo $data["clinic_city"];?>');"><?php echo $data["clinic_city"].",".$data["state_name"].",".$data["clinic_zip"];?></li>
	<?php } elseif($data["clinic_zip"]){ ?>
    <li id="res" style="cursor: pointer;" onClick="selectVal('<?php echo $data["clinic_zip"];?>');"><?php echo $data["clinic_zip"].",".$data["clinic_city"].",".$data["state_name"];?></li>
	
	
	 <?php }} ?>
   </ul>
    <?php } }
	else{ 
	echo "No records founds..!";
    }
    

?>