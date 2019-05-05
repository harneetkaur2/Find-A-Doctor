<?php require_once("super_admin_header.php"); 

$info = array();

$db_functions = new SuperAdmin_functions();
$update="";
if(isset($_POST['submit'])){
	echo $data=$_POST;
 $update= $db_functions->setting_data($data);
 
 ?>
 
<!------ Include the above in your HEAD tag ---------->

<!--Model SUCESS Popup starts-->
<div class="container">
    <div class="row">
        
        <div class="modal" id="ignismyModal" style="display:block;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="" onclick="hide_modal();"><span>×</span></button>
                     </div>
					
                    <div class="modal-body">
                       
						<div class="thank-you-pop">
							<img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
							<h1>Thank You!</h1><p>Your Settings data saved.</p>
							
							
 						</div>
                         
                    </div>
					
                </div>
            </div>
        </div>
    </div>
</div>

<!--Model SUCESS Popup END-->
 
 <?php
}
$info=$db_functions->get_setting_data();
if($info){
$info=$info[0];
}

?>
<form action="" method="post">
  <section class="content">
				<div class="row">
		  		   <div class="custom_new">
					<div class="col-sm-12">
		  				<div class="box box-primary">
				            <div class="box-header with-border">
				              <h3 class="box-title">FB  SETTINGS</h3>
				            </div>
		                  	<div class="box-body">
				<div class="col-md-4">
				<div class="form-group">
					<label for="exampleInputEmail1">FB APPID *</label>
					<input type="text" class="form-control" id="FB_APPID" name="fb_appid" value="<?php if(!empty($info['fb_app_id'])){echo $info['fb_app_id'];} ?>" placeholder="FB APPID" required>
					
				</div>
		           				</div>
		           				<div class="col-md-4">
				<div class="form-group">
				<label for="exampleInputEmail1">FB APSECRET *</label>
				<input type="text" class="form-control" id="FB_AP_SECRET" name="fb_app_secret" value="<?php if(!empty($info['fb_app_secret'])){echo $info['fb_app_secret'];} ?>" placeholder="FB APSECRET" required>
									
				</div>
										
					                
		           				</div>
			
		                    </div>
		                   
		                </div>
		            </div>
				
                    
				</div></div>

		  	 </section>
		   	<section class="content">
			    <div class="row">
                <div class="custom_new">		        
		        	<div class="col-md-12">
		          		<div class="box box-primary">
		            		<div class="box-header with-border">
		              			<h3 class="box-title">ADWORDS SETTINGS</h3>
		            		</div>		                          
		        <div class="box-body">
					<div class="col-md-4">
					<div class="form-group">
					<label for="company_name">Adwords Appid *</label>
					<input type="text"  class="form-control" name="adwords_app" id="apd" value="<?php if(!empty($info['adword_app_id'])){echo $info['adword_app_id'];} ?>" placeholder="Adwords Appid" required>
						
						  
						</div>
					</div>
								
				<div class="col-md-4">
				 <div class="form-group">									
						<label for="exampleInputstatus">Adwords Appsecret*</label>
						<input type="text" value="<?php if(!empty($info['adword_app_secret'])){echo $info['adword_app_secret'];} ?>" class="form-control" id="asecret" name="addword_secret" placeholder="Adwords Appsecret" required>
						
					 
					 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">									
				<label for="exampleInputstatus">Adwords Developer Token *</label>
				<input type="text" value="<?php if(!empty($info['adword_developer_token'])){echo $info['adword_developer_token'];} ?>" class="form-control" id="dtoken" name="adword_developer_token" placeholder="Adwords Developer Token" required>
							
					
				</div>
				</div>
							
								
		                    </div>
							
		            	</div>
		   			</div>
		   		</div></div>
			</section>
			
				<section class="content">
			    <div class="row">
                <div class="custom_new">		        
		        	<div class="col-md-12">
		          		<div class="box box-primary">
		            		<div class="box-header with-border">
		              			<h3 class="box-title">BING SETTINGS</h3>
		            		</div>		                          
		        <div class="box-body">
					<div class="col-md-4">
					<div class="form-group">
					<label for="company_name">BING Appid *</label>
					<input type="text"  class="form-control" name="bing_app" id="apd" value="<?php if(!empty($info['bing_app_id'])){echo $info['bing_app_id'];} ?>" placeholder="BING Appid" required>
						
						  
						</div>
					</div>
								
				<div class="col-md-4">
				 <div class="form-group">									
						<label for="exampleInputstatus">BING App secret*</label>
						<input type="text" value="<?php if(!empty($info['bing_app_secret'])){echo $info['bing_app_secret'];} ?>" class="form-control" id="asecret" name="bing_secret" placeholder="BING Appsecret" required>
						
					 
					 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">									
				<label for="exampleInputstatus">Bing Developer Token *</label>
				<input type="text" value="<?php if(!empty($info['bing_developer_token'])){echo $info['bing_developer_token'];} ?>" class="form-control" id="dtoken" name="bing_developer_token" placeholder="Bing Developer Token" required>
							
					
				</div>
				</div>
								
		                    </div>
							
		            	</div>
		   			</div>
		   		</div></div>
			</section>
				<section class="content">
			    <div class="row">	
           <div class="custom_new">				
		        	<div class="col-md-12">
		          		<div class="box box-primary">
			<input type="submit" name="submit" class="btn bg-orange margin pull-right" value="Save all settings">
			</div>
		   			</div>
		   		</div></div>
			</section>
</form>
<style>

/*--thank you pop starts here--*/
.thank-you-pop{
	width:100%;
 	padding:20px;
	text-align:center;
}
.thank-you-pop img{
	width:76px;
	height:auto;
	margin:0 auto;
	display:block;
	margin-bottom:25px;
}

.thank-you-pop h1{
	font-size: 42px;
    margin-bottom: 25px;
	color:#5C5C5C;
}
.thank-you-pop p{
	font-size: 20px;
    margin-bottom: 27px;
 	color:#5C5C5C;
}

.thank-you-pop h3.cupon-pop span{
	color:#03A9F4;
}
.thank-you-pop a{
	display: inline-block;
    margin: 0 auto;
    padding: 9px 20px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    background-color: #8BC34A;
    border-radius: 17px;
}
.thank-you-pop a i{
	margin-right:5px;
	color:#fff;
}
#ignismyModal .modal-header{
    border:0px;
}
/*--thank you pop ends here--*/

</style>
<script src="<?php echo $file_url; ?>/assets/js/vendor/jquery-2.1.4.min.js"></script> 
<script>
function hide_modal(){
	$("#ignismyModal").hide();
}
</script>
<script src="<?php echo $file_url; ?>/assets/js/plugins.js"></script>
 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
</body>
</html>