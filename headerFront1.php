<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Anthem | Find a Clinic</title>
<meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
<meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
<link rel="stylesheet" type="text/css" href="front/assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="front/assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="front/assets/css/imagehover.min.css">
<link rel="stylesheet" type="text/css" href="front/assets/css/anthemstyle.css">
<link href="https://fonts.googleapis.com/css?family=Text+Me+One" rel="stylesheet">
<style>
    
@media screen and (max-width: 600px) {
  .mobole_device {
    visibility: hidden;
    clear: both;
    float: left;
    margin: 10px auto 5px 20px;
    width: 28%;
    display: none!important;
  }
}
</style>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128381969-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128381969-3');
</script>

</head>

<body>

<!--Navigation bar-->
 <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><img src="front/assets/img/Logo.jpg" width="280" height="95"></a>
      </div>
      
      <div class="collapse navbar-collapse" id="myNavbar">
      <!--<div class="sig_div pull-right text-right"> <a href="#" data-target="#login" data-toggle="modal">Sign in</a> </div>-->
        <ul class="nav navbar-nav navbar-right">
          <li><a href="https://www.artforheartfailure.com/about-heart-failure">  About Heart Failure</a></li>
          <li><a href="https://www.artforheartfailure.com/treatment-options">  Treatment Options </a></li>
          <li><a href="https://www.artforheartfailure.com/am-i-eligible"> Am I Eligible?</a></li>
          <li class="btn-trial"><a href="https://findadoctor.artforheartfailure.com"> <i class="fa fa-home"></i> FIND A CLINIC</a></li>
        </ul>
      </div>
    </div>
  </nav>
<!--/ Navigation bar--> 
<!--Modal box-->
  <div class="modal fade" id="login" role="dialog">
<div class="modal-dialog modal-sm">

<!-- Modal content no 1-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title text-center form-title">Login</h4>
</div>
<div class="modal-body padtrbl">
<div class="login-box-body">
<p class="login-box-msg">Sign in to start your session</p>
<div class="form-group">
<form name="" id="loginForm">
<div class="form-group has-feedback">

<input class="form-control" placeholder="Username" id="loginid" type="text" autocomplete="off" />
<span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span> 
<!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                 
                  <input class="form-control" placeholder="Password" id="loginpsw" type="password" autocomplete="off" />
                  <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="checkbox icheck">
                      <label>
                                <input type="checkbox" id="loginrem" > Remember Me
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button type="button" class="btn btn-green btn-block btn-flat" onClick="userlogin()">Sign In</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div> 
