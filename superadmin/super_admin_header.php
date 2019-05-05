<?php 
require_once("class.db_connect.php");

include('class.functions.php');
$file_url="https://findadoctor.artforheartfailure.com/admin";

$site_url="https://findadoctor.artforheartfailure.com/superadmin/";
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title> Super Admin </title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-icon.png">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="<?php echo $file_url; ?>/assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $file_url; ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $file_url; ?>/assets/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $file_url; ?>/assets/css/themify-icons.css">
<link rel="stylesheet" href="<?php echo $file_url; ?>/assets/css/flag-icon.min.css">
<link rel="stylesheet" href="<?php echo $file_url; ?>/assets/scss/style.css">


<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>
<body>
  

<div id="right-panel" class="right-panel"> 
  
  <!-- Header-->
  <header id="header" class="header">
  <div class="header-menu">
    <div class="col-md-5">
      <div class="header-left"> <a class="navbar-brand" href="<?php echo $site_url; ?>"><img src="<?php echo $file_url; ?>/images/cropped-SImmetry_RGB-new-final.png" alt="Logo" height="100px"></a> </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="user-area dropdown float-right"> <span style="padding-top:5px; display:inline-block;"> Welcome, <strong>Super admin</strong></span> <a href="logout.php" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:10px;"> Logout </a>
     
    </div>
      
  </div>
</div>
</header>
<!-- /header --> 

