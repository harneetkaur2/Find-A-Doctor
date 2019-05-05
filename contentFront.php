<?php require_once ("front/config/class.connect.php");
$bdd = new db();

function distance($lat1, $lon1, $lat2, $lon2, $unit,$decimals='2') {

  $theta = $lon1 - $lon2;
  $dist = sin(@deg2rad($lat1)) * sin(@deg2rad($lat2)) +  cos(@deg2rad($lat1)) * cos(@deg2rad($lat2)) * cos(@deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
    if($unit == "K"){
     return ($miles * 1.609344);
     }else if ($unit == "N") {
     return ($miles * 0.8684);
     }else{
     return $miles;
    }
}

if(isset($_POST['submit'])){
$searchdata    = trim($_POST['search']);
$explodedata   =  explode(",",$searchdata);
//print_r($explodedata);
 $text ="";
 $text2 ="";
 $text3 ="";
$explodedata1   = trim($explodedata[0]);
$explodedata2   = trim($explodedata[1]);
$explodedata3   = trim($explodedata[2]);
if($explodedata1){
 $text = str_replace(' ', '+', $explodedata1);
}
 if($explodedata2){
 $text2 = str_replace(' ', '+', $explodedata2);
 }
  if($explodedata3){
 $text3 = str_replace(' ', '+', $explodedata3);
  }
$today = @date("Y-m-d");

/*get lat long by google api */
$myquery = "select * from wp_zyga_usa_lat_long WHERE city_zip='$explodedata1' OR state_name='$explodedata1' OR state_code='$explodedata1' OR city_state_code='$searchdata' OR  city_state_fullname='$searchdata'";
	$check_get_data = $bdd->getOne($myquery);
	$getstae = $check_get_data["state_name"];
	$getstaess =  str_replace(' ', '+', $getstae);
	 
	 
	  /*echo "<pre>";
	print_r($check_get_data);
	echo "</pre>";  */
/* clinic not in database close */
if($check_get_data){
 if(strlen($explodedata1)==2){
	$fullurl = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyD1cGNhJz2BiG4oODjDAkfOH__dxXC_N10&address=".$getstaess."+us&sensor=true";
	}else{
	$fullurl = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyD1cGNhJz2BiG4oODjDAkfOH__dxXC_N10&address=".$text."+".$text2."+".$text3."+us&sensor=true";
	}

$string ="";
$json_a ="";
$string = @file_get_contents($fullurl); // get json content
$json_a = json_decode($string, true); //json decoder

  $latitude1  = $json_a['results'][0]['geometry']['location']['lat'];
  $longitude1 = $json_a['results'][0]['geometry']['location']['lng'];
  ?>
<script type="text/javascript">
	 jQuery( document ).ready(function() {
        	var search_data = jQuery('#search-box').val();
        	//console.log(search_data);
        	if(typeof search_data!== "undefined"){
        		jQuery('.section-fourth').css('display','block');
        	}
        });
</script>
<?php
}else{?> 

<div class="modal" id="ignismyalertModal" style="display:block;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="" onclick="hide_alertmodal();"><span>x</span></button>
                     </div>
					<div class="modal-body">
                    <div class="thank-pop">

					<p class="text-center" style="color:#8B0000;"><b> Please enter a valid zip code or state.</b></p>


 						</div>

                    </div>

                </div>
            </div>
        </div>
		<script>
			function hide_alertmodal(){
				$("#ignismyalertModal").hide();
			}
        </script>
		
		
<?php }
/* close get lat long by google api */
if(is_numeric($explodedata1)){
	$finalResult = $bdd->search("select * from wp_zyga_clinic WHERE  clinic_zip LIKE '%$explodedata1%'");
	$clinicstate =  $finalResult[0]['clinic_state'];
/* insert locater search */
if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_zip,clinic_state,loc_date,count)VALUES('$explodedata1','$clinicstate','$today','1')";
     $result = $bdd->execute($query);
}

}
elseif(strlen($explodedata1)==2){
	$finalResult = $bdd->search("select * from wp_zyga_clinic WHERE  clinic_state LIKE '%$explodedata1%'");
/* insert locater search */
if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_state,loc_date,count)VALUES('$explodedata1','$today','1')";
     $result = $bdd->execute($query);
}
}
elseif(is_numeric($explodedata1) && strlen($explodedata2)==2){
	$finalResult = $bdd->search("select * from wp_zyga_clinic WHERE  clinic_zip LIKE '%$explodedata1%' OR clinic_state LIKE '%$explodedata2%'");
/* insert locater search */
if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_zip,clinic_state,loc_date,count)VALUES('$explodedata1','$explodedata2','$today','1')";
     $result = $bdd->execute($query);
}
}
elseif(is_numeric($explodedata1) && strlen($explodedata2)!=2){
	$finalResult = $bdd->search("select * from wp_zyga_clinic WHERE  clinic_zip LIKE '%$explodedata1%' && state_name LIKE '%$explodedata2%' OR clinic_city LIKE '%$explodedata2%'");
	  $clinicstate =  $finalResult[0]['clinic_state'];
	  $clinicstatename =  $finalResult[0]['state_name'];
	  $cliniccity =  $finalResult[0]['clinic_city'];
	if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_zip,clinic_state,state_name,clinic_city,loc_date,count)VALUES('$explodedata1','$clinicstate','$clinicstatename','$cliniccity','$today','1')";
     $result = $bdd->execute($query);
}
}
elseif(!is_numeric($explodedata1) && strlen($explodedata2)==2){
	$finalResult = $bdd->search("select * from wp_zyga_clinic WHERE  clinic_city LIKE '%$explodedata1%' || clinic_state LIKE '%$explodedata2%'");
	  $clinicstate =  $finalResult[0]['clinic_state'];
	 if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_city,clinic_state,loc_date,count)VALUES('$explodedata1','$clinicstate','$today','1')";
     $result = $bdd->execute($query);
}
}
elseif(!empty($explodedata1) || !empty($explodedata2) || !is_numeric($explodedata1) || strlen($explodedata2)!=2){
	$inarray = $bdd->search("select * from wp_zyga_clinic");
     foreach($inarray as $inarr){
	 $myinarr_city[]=$inarr['clinic_city'];
	 $myinarr_state[]=$inarr['state_name'];
    }
	if(in_array($explodedata1, $myinarr_city) && in_array($explodedata2, $myinarr_state) ){
       $finalResult = $bdd->search("select * from wp_zyga_clinic WHERE  clinic_city LIKE '%$explodedata1%' OR state_name LIKE '%$explodedata2%' ");
	   $clinicstate =  $finalResult[0]['clinic_state'];
	   /* insert locater search */
	if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_city,clinic_state,state_name,loc_date,count)VALUES('$explodedata1','$clinicstate','$explodedata2','$today','1')";
     $result = $bdd->execute($query);
    }
    }
	else{
		$finalResult = $bdd->search("select * from wp_zyga_clinic WHERE clinic_city ='$explodedata1' OR state_name ='$explodedata1' ");
		$clinicstate =  $finalResult[0]['clinic_state'];
		$cliniccity =  $finalResult[0]['clinic_city'];
		$clinicstatename =  $finalResult[0]['state_name'];
	   /* insert locater search */
	 if($finalResult){
	$query = "INSERT INTO wp_zyga_locater_search (clinic_city,clinic_state,state_name,loc_date,count)VALUES('$cliniccity','$clinicstate','$clinicstatename','$today','1')";
     $result = $bdd->execute($query);
	}
	}
}

/* clinic not in database */
if(empty($finalResult)){
	if(is_numeric($searchdata) || strlen($searchdata)==2 || !is_numeric($explodedata1) || !strlen($explodedata1)==2){	    $query = "select latitude,longitude,state_code from wp_zyga_usa_lat_long WHERE city_zip='$searchdata' OR state_code='$searchdata' OR state_name='$explodedata1' OR city_name ='$explodedata1'";
	$get_data = $bdd->getOne($query);

	   $us_state_code =  $get_data['state_code'];
	    $query = "INSERT INTO wp_zyga_locater_search (clinic_state,loc_date,count)VALUES('$us_state_code','$today','1')";
		$result = $bdd->execute($query);
	    $search_latitude =  $get_data['latitude'];
		$search_longitude = $get_data['longitude'];
		$clinic = $bdd->search("select * from wp_zyga_clinic");

		$latitude="";

	    $longitude ="";

		foreach($clinic as $res){

	    $latitude = $res['clinic_latitude'];

	    $longitude = $res['clinic_longitude'];



	$find_dis="";

	$find_dis = distance($latitude, $longitude, $latitude1, $longitude1,"M");

	$res['distance']= $find_dis;

	$final_Results[]=$res;

		if($find_dis<=500){

    		$finalResult[]=$res;
		}
	}
	}   /* close if   */
elseif(is_numeric($explodedata1) || $explodedata2!=""){	
$query = "select latitude,longitude from wp_zyga_usa_lat_long WHERE city_zip='$explodedata1' OR state_code='$explodedata2' OR state_name='$explodedata2'";	$get_data = $bdd->getOne($query);		       $us_state_code =  $get_data['state_code'];	    $query = "INSERT INTO wp_zyga_locater_search (clinic_state,loc_date,count)VALUES('$us_state_code','$today','1')";        $result = $bdd->execute($query);
	$search_latitude =  $get_data['latitude'];
	$search_longitude = $get_data['longitude'];
	
	$clinic = $bdd->search("select * from wp_zyga_clinic");
	$latitude="";
	$longitude ="";
	foreach($clinic as $res){	
    $latitude = $res['clinic_latitude'];
	$longitude = $res['clinic_longitude'];       
	$find_dis="";
	$find_dis = distance($latitude, $longitude, $latitude1, $longitude1,"M");	
	$res['distance']= $find_dis;
	$final_Results[]=$res;	
	if($find_dis<=500){
	$finalResult[]=$res;
	}
	}
	}
}
if(count($finalResult)< 20){
    $finalResult ="";
	$clinic = $bdd->search("select * from wp_zyga_clinic");

	$latitude="";
    $longitude ="";
	foreach($clinic as $res){
    $latitude = $res['clinic_latitude'];
    $longitude = $res['clinic_longitude'];
	$find_dis="";
	$find_dis = distance($latitude, $longitude, $latitude1, $longitude1,"M");
	$res['distance']= $find_dis;
	$final_Results[]=$res;
		if($find_dis<=500){
    		$finalResult[]=$res;
		}
	}

	}


	}     /* close ifisset  */
/* insert impressions search */


if($finalResult!=""){
		foreach ($finalResult as $impr) {
    	$imp_clinic_id   = $impr['clinic_id'];
	    $imp_clinic_name = $impr['clinic_name'];
	    $bdd->execute("INSERT INTO wp_zyga_locator_impressions (clinic_id,clinic_name,imp_date,count)VALUES('$imp_clinic_id','$imp_clinic_name','$today','1')");
	  }
	}
?>

<style>
    .hide{display:none;}
</style>
<!--Secound Sectiom start-->
   <section class="section-secound">

    <div class="container">

   <div class="header-section_top">

    <div class="" style="width:100%;">

      <div class="row">

        <div class="text-center">

      <p>Seeking a doctor with expertise in heart failure? Search below and we can help find the best care at a convenient location for you.</p>


        </div>

  </div></div> </div>  </div></section>

   <!--Secound Sectiom End-->



    <!--SEARCH Sectiom START-->

<section class="section-third" >

    <div class="container">

        <div class="row">

            <div class="col-md-12">
              <!--div class="text-center" style="margin:20px 0px 0px 0px"> <a href="front/assets/img/60248-LM-Rev-A-Physician-Visit-Form.pdf" class="btn btn-primary" role="button"  target="_blank">DOWNLOAD PHYSICIAN VISIT FORM</a> </div-->
                <div class="search-btn-zip text-center">

               	 <h2 class="search_tittle">Search by</h2>

               	  <form id="clinic_form" action="" method="POST">

                    <input name="search" id="search-box" type="text" class="form-control seart-btn " value="<?php echo @$_POST['search']; ?>" placeholder="State or Zip Code"  required>

                    <input name="submit" type="submit" value="Search" id="clinic_search" class="serch-bt" data-toggle="modal" >

                 </form>

                    <div id="resultdata"></div>

                	</div>

                </div>

            </div>

     </div>

</section>

<!--SEARCH Sectiom START-->
<?php
if(isset($_POST['inquiry_submit'])){
	 $user_name     = $_POST['user_name'];
	 $user_mail    = $_POST['user_mail'];
	 $user_city    = $_POST['user_city'];
	 $user_state    = $_POST['user_state'];
	 $user_zip    = $_POST['user_zip'];
	
	    $to = "matt@aktioninteractive.com";
		$subject = "Zyga | Find a Clinic";

		$txt  = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>XorSolutions.Com/</title></head><body>';
		$txt .= '<div class="gmail_quote"><div style="margin:0px auto;width:620px;border-radius:10px 10px 10px 10px">';
		$txt .= '<div style="padding-left:20px;background:#fff;padding-top:20px;"><div style="background:no-repeat;width:100%;PADDING-BOTTOM:15px;">';
		$txt .= '<img src="https://newzyga.aktion-dev.com/wp-content/uploads/2018/03/cropped-SImmetry_RGB-new-final.png" height="60px"></div></div><div style="padding:30px;background:#fcfcfc;border-radius:0 0 10px 10px">';
		$txt .= '<div style="margin-bottom:40px;padding-bottom:20px;color:#35363f;border-bottom:#dddddd 1px solid"> ';
		$txt .= '<div style="clear:right;margin-top:15px;min-height:26px">';
		$txt .= '<strong style="color:#7DBA29;">User Name</strong> '.$user_name.'<br><br>';
		$txt .= '<strong style="color:#7DBA29;">Email ID</strong> : '.$user_mail.'<br><br>';
		 $txt .= '<strong style="color:#7DBA29;">City</strong> : '.$user_city.'<br><br>';  
		$txt .= '<strong style="color:#7DBA29;">State</strong> : '.$user_state.'<br><br>';
		$txt .= '<strong style="color:#7DBA29;">Zip Code</strong> : '.$user_zip.'<br><br>';
		$txt .= '</div></div></div></div></body></html>';
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <zyga@aktion-dev.com>' . "\r\n";

		mail($to,$subject,$txt,$headers);		?>
		
		<div class="modal" id="ignismyModals" style="display:block;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="" onclick="hide_modals();"><span>×</span></button>
                     </div>
					
                    <div class="modal-body">
                       
						<div class="thank-you-pop text-center">
							<img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
							<h1 class="text-center">Thank You!</h1><p class="text-center">Successfully Sending.</p>
							
							
 						</div>
                         
                    </div>
					
                </div>
            </div>
        </div>
		<script>
function hide_modals(){
	$("#ignismyModals").hide();
}
</script>
	
<?php }
if(isset($_POST['submit'])){
$myquery = "select * from wp_zyga_usa_lat_long WHERE city_zip='$explodedata1' OR state_code='$explodedata1' OR state_name='$explodedata1' OR city_name='$explodedata1' ";
$check_get_data = $bdd->getOne($myquery);
	 
if($check_get_data){
	 	if(empty($finalResult)){ ?>
		<style>
.inquiry_form{ margin-top:20px;}
.inquiry_form p{ font-size:15px; color:#999;}
.inquiry_form label{ font-size:12px; font-weight:normal!important;}
.submit_button{ background-color:#f57f25; width:120px; border:none; border-radius:3px; padding:6px 0px 6px 0px; text-align:center; color:#fff; font-weight:700;}


</style>
		<div class="container inquiry_form">
<div class="row"><div class="col-md-3"> </div>
<div class="col-md-6 ">
<P>Thank you for your inquiry. Unfortunately, there are no SImmetry surgeons in your area at this time.</P>
<br/>
<P>We are working hard to keep pace with the need for SI joint relief and are adding new surgeons every week. Please fill out the form below, and we'll provide you a free information guide on SI joint dysfunction and treatment. We'll continue to update you regarding new surgeons or other SI joint fusion news in the future, or you can unsubscribe at any time.</P> <br/>
</div> 
<div class="col-md-3"> </div>
</div>
<div class="row">
<div class="col-md-3"> </div>
<form method="post" action="">
<div class="col-md-4">

<label>Name</label>
<div class="form-group"><input name="user_name" type="text" class="form-control" required></div>
<label>Email Address</label>
<div class="form-group"><input name="user_mail" type="email" class="form-control" required></div>
<label>City </label>
<div class="form-group"><input name="user_city" type="text" class="form-control" required></div>
<label>State </label>
<div class="form-group"><input name="user_state" type="text" class="form-control" required></div>
<label>Zip Code </label>
<div class="form-group"><input name="user_zip" type="text" class="form-control" required></div>
<div class="form-group"><input name="inquiry_submit" type="submit" type="button"  class="submit_button" value="SUBMIT">

</div>
</div>
</form>
<div class="col-md-5"> </div>


</div>

</div>
<?php }
}  	
}

?>

 <section class="section-fourth">

<div class="container">

<div class="row">

<div class="right_listing">

   <div class="sdhjwqd">

    <div class="row">

        <div class="col-md-10">

            <div class="start-list">

                <ul>

                <li> <!--Showing results for:--> </li>

                <li> <!--<i class="fa fa-times" aria-hidden="true"></i> <span class="capiotal"> minneapolis </span>--></li>

                </ul>

        </div>

	</div>

	<div class="col-md-2">

    <div class="setloc navecation">

        <ul class="setloc" id="navi">



           <li class="tablinks active"><a class="active" href="#" onclick="openCity(event, 'List')"> <i class="fa fa-bars" aria-hidden="true"></i> </a> </li>

           <li > <a class="" href="#" class="tablinks" onclick="openCity(event, 'Map')"> <i class="fa fa-map-marker" aria-hidden="true"></i> </a></li>

        </ul>

  		  </div>

   	 </div>

</div>

	</div>



<div class="two-way-listing tabcontent" id="List">

<ul id="searcResult" style="background: #fff;">

<!--<div id="searcResult"></div>-->

<?php
//echo "sssss".print_r($finalResult);

if(!empty($finalResult)){
        foreach($finalResult as $result){
        $clinic_zipaddress = $result['clinic_zip'];
	    $clinic_cityaddress= $result['clinic_city'];
	    $state_nameaddress = $result['state_name'];
        $query = "select clinic_latitude,clinic_longitude from wp_zyga_clinic WHERE clinic_zip='$clinic_zipaddress' AND clinic_city='$clinic_cityaddress' AND state_name='$state_nameaddress'";
	    $results = $bdd->getOne($query);
		//$addressData = $result['clinic_zip']." ".$result['clinic_city'].",".$result['state_name']." US";
		$latitude2 = $results['clinic_latitude'];
	    $longitude2 = $results ['clinic_longitude'];
	    $dis = distance($latitude1, $longitude1, $latitude2, $longitude2, "M");
	    $rounddistance['distance'] = @round($dis,$decimals);
	$arraysort[] = array(

	'clinic_address'        =>$result['clinic_address'],

	'clinic_name'           =>$result['clinic_name'],

	'clinic_doc_first_name' =>$result['clinic_doc_first_name'],

	'clinic_doc_last_name'  =>$result['clinic_doc_last_name'],

	'distance'              =>$rounddistance['distance'],

	'clinic_phone'          =>$result['clinic_phone'],

	'c_script_url'          =>$result['c_script_url'],

	'clinic_address2'       =>$result['clinic_address2'],

	'clinic_city'           =>$result['clinic_city'],

	'clinic_state'           =>$result['clinic_state'],

	'clinic_zip'           =>$result['clinic_zip'],

	'clinic_lat'           =>$result['clinic_latitude'],

	'clinic_long'           =>$result['clinic_longitude'],

	);

}

$i= 0;

  $distance = array();

foreach($arraysort as $sortresults){

	$distance[] = $sortresults['distance'];

@array_multisort($distance, SORT_ASC, $arraysort);}



  foreach($arraysort as $sortresults){



$addressData = '<html> <body><head><script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.1.min.js"></script></head><div class="location-info">
    <div class="location-name">'.$sortresults["clinic_doc_first_name"]." ".$sortresults["clinic_doc_last_name"].'</div>
    <div>'.$sortresults["clinic_name"].' </div>
   	<div >'.$sortresults["clinic_address"].'</div>
    <div >'.$sortresults["clinic_address2"].'</div>
    <div>'.$sortresults["clinic_city"].", ".$sortresults["clinic_state"]." ".$sortresults["clinic_zip"].' </div><!--span>Phone No:'.$sortresults['clinic_phone'].'</span><div ><script src="https:'.$sortresults["c_script_url"].'"></script></div--></div></body></html>';





  $items[] = [$addressData,$sortresults['clinic_lat'],$sortresults['clinic_long'],$sortresults['distance']];







	  ?>

 <li id="<?php echo $i++; ?>">

 <div class="first_row">

	<div class="main-list">

	 <span class="list-des">

     <div class="location-info">

       <div class="location-name"><?php echo $sortresults['clinic_doc_first_name']." ".$sortresults['clinic_doc_last_name']; ?></div>

	   <div><?php echo $sortresults['clinic_name']; ?></div>

    	 <div ><?php echo $sortresults['clinic_address']; ?></div>

    	 <div ><?php echo $sortresults['clinic_address2']; ?></div>

     	<div><?php echo $sortresults['clinic_city'].", ".$sortresults['clinic_state']." ".$sortresults['clinic_zip']; ?></div>

   </br>

	</div>
</span>


  </div>
<div class="main-list miles">
<span class="list-des list-bod">
	<?php 	echo $sortresults['distance'];?> Miles</span>
</div>
</div>
<div class="third-list text-center">
<i class="fa fa-phone-square" aria-hidden="true"></i><span class="list-des"> Make appointment <br />

<span class="list-color"><?php echo $sortresults['clinic_phone']; ?></span>
<script src="https:<?php echo $sortresults['c_script_url']; ?>"></script>
</span>
</div>
</li>

<hr>

<?php  } ?>

</ul>

</div>

</div>

    <div class="map-listing  tabcontent mobole_device" id="Map">

        <div class="left-map hide" id="testmap">

            <div class="mapouter">

                <div class="gmap_canvas">

                  <div id="map" style="width:379px;"></div>

                </div>

           </div>

        </div>

	</div>

	<?php }?>

 </div>

</div>

</div>

</section>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1cGNhJz2BiG4oODjDAkfOH__dxXC_N10&libraries=places"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.1.min.js"></script>

  <script type="text/javascript">

  //debugger

   var gicons=[];

function getMarkerImage(iconColor) {

    if ((typeof(iconColor)=="undefined") || (iconColor==null)) {

      iconColor = "red";

    }

    if (!gicons[iconColor]) {

      gicons[iconColor] = new google.maps.MarkerImage("http://www.geocodezip.com/mapIcons/marker_"+ iconColor +".png",

      // This marker is 40 pixels wide by 44 pixels tall.

      new google.maps.Size(30, 40),

      // The origin for this image is 0,0.

      new google.maps.Point(0,0),

      // The anchor for this image is at 6,20.

      new google.maps.Point(9, 34));

    }

    return gicons[iconColor];



}

    var locations = <?php echo json_encode($items); ?>;

       	var h = document.getElementById("searcResult").offsetHeight;

		 //alert(h);
var mapdata = document.getElementById("map");
// console.log(mapdata);
	

        var element = document.getElementById("testmap");
if(element!=null){
        element.classList.remove("hide");
}
if(mapdata!=null){
		document.getElementById("map").style.height = h + "px";

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 50,
	  
      center: new google.maps.LatLng(51.530616, -0.123125),
      //mapTypeId: google.maps.MapTypeId.ROADMAP
      mapTypeControl: true,
          mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
              position: google.maps.ControlPosition.TOP_CENTER
          },
          zoomControl: true,
          zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER
          },
          scaleControl: true,
          streetViewControl: true,
          streetViewControlOptions: {
              position: google.maps.ControlPosition.LEFT_TOP
          },
          fullscreenControl: true
    });
}
    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    var markers = new Array();
if(locations!=null){
    for (i = 0; i < locations.length; i++) {

      marker = new google.maps.Marker({

        position: new google.maps.LatLng(locations[i][1], locations[i][2]),

        map: map

      });
     google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
     map.setZoom(4);
    });
        markers.push(marker);

    google.maps.event.addListener(marker, 'click', (function(marker, i) {

        return function() {

          infowindow.setContent(locations[i][0]);

          infowindow.open(map, marker);

        }

      })(marker, i));

	}


    $("#searcResult li").on('mouseenter', function(){

    var id=$(this).attr('id');

    markers[id].setIcon("https://newzyga.aktion-dev.com/find-doctor/front/assets/img/spotlight-poi3.png");

    }).on('mouseleave', function(){

    var id=$(this).attr('id');

    markers[id].setIcon("https://newzyga.aktion-dev.com/find-doctor/front/assets/img/spotlight-poi2.png");

});



    function AutoCenter() {

      //  Create a new viewpoint bound

      var bounds = new google.maps.LatLngBounds();

      //  Go through each...

      $.each(markers, function (index, marker) {

      bounds.extend(marker.position);

      });

      //  Fit these bounds to the map

      map.fitBounds(bounds);

    }

    AutoCenter();
}

     /* locate();



    function locate(){

		if ("geolocation" in navigator){

			navigator.geolocation.getCurrentPosition(function(position){

				var currentLatitude = position.coords.latitude;

				var currentLongitude = position.coords.longitude;



				var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;

				var infoWindow = new google.maps.InfoWindow({map: map, content: infoWindowHTML});

				var currentLocation = { lat: currentLatitude, lng: currentLongitude };

				infoWindow.setPosition(currentLocation);



			});

		}

	}  */

  </script>


<script>

$(document).ready(function(){
  $('ul li').click(function(){
    $('li ').removeClass("active");
    $(this).addClass("active");
});
});

</script>