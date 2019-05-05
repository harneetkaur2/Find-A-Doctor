<?php 

class SuperAdmin_functions {  
     public $db;   
  
     public function __construct()    
     {    
          $this->db = new db();  
     }   
      
public function get_setting_data(){ 
        
	$row =  $this->db->getAll("SELECT * FROM wp_zyga_superadmin_settings");
 //print_r($affect_row);
//$db_connection->disconnect(); 

	return $row;
}
public function setting_data($data){ 
        $fb_app_id= $data['fb_appid'];
		$fb_app_secret= $data['fb_app_secret'];
		$adword_app_id= $data['adwords_app'];
		$adword_app_secret= $data['addword_secret'];
		$adword_developer_token= $data['adword_developer_token'];
		
		$bing_app_id= $data['bing_app'];
		$bing_app_secret= $data['bing_secret'];
		$bing_developer_token= $data['bing_developer_token'];
		
	$affect_row =  $this->db->execute("UPDATE wp_zyga_superadmin_settings SET fb_app_id='$fb_app_id',fb_app_secret='$fb_app_secret',adword_app_id='$adword_app_id',adword_app_secret='$adword_app_secret',adword_developer_token='$adword_developer_token',bing_app_id='$bing_app_id',bing_app_secret='$bing_app_secret',bing_developer_token='$bing_developer_token'");
 //print_r($affect_row);
//$db_connection->disconnect(); 

	return $affect_row;
}





}  
	








?>