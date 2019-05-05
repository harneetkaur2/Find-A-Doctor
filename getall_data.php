<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//namespace Google\AdsApi\Examples\AdWords\v201806\BasicOperations;

include_once 'googleads/vendor/autoload.php';

use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\v201806\cm\CampaignService;

use Google\AdsApi\AdWords\v201806\cm\DataService;
use Google\AdsApi\AdWords\v201806\cm\OrderBy;
use Google\AdsApi\AdWords\v201806\cm\Paging;
use Google\AdsApi\AdWords\v201806\cm\Selector;
use Google\AdsApi\AdWords\v201806\cm\SortOrder;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\AdsApi\AdWords\v201806\cm\DateRange;

use Google\AdsApi\AdWords\v201806\cm\AdGroupService;

use Google\AdsApi\AdWords\v201806\cm\Predicate;
use Google\AdsApi\AdWords\v201806\cm\PredicateOperator;

use Google\AdsApi\AdWords\v201806\cm\AdGroupAdService;
use Google\AdsApi\AdWords\v201806\cm\AdGroupAdStatus;
use Google\AdsApi\AdWords\v201806\cm\AdType;

use Google\AdsApi\AdWords\Reporting\v201806\DownloadFormat;
use Google\AdsApi\AdWords\Reporting\v201806\ReportDefinition;
use Google\AdsApi\AdWords\Reporting\v201806\ReportDefinitionDateRangeType;
use Google\AdsApi\AdWords\Reporting\v201806\ReportDownloader;
use Google\AdsApi\AdWords\ReportSettingsBuilder;

use Google\AdsApi\AdWords\v201806\cm\ReportDefinitionReportType;

use Google\AdsApi\AdWords\v201806\cm\LocationCriterionService;



/****************  Get campaigns         ************************************/
function get_all_campaigns($limit){
	$oAuth2Credential = (new OAuth2TokenBuilder())
    ->fromFile()
    ->build();

$session = (new AdWordsSessionBuilder())
    ->fromFile()
    ->withOAuth2Credential($oAuth2Credential)
    ->build();

$adWordsServices = new AdWordsServices();
$campaignService = $adWordsServices->get($session, CampaignService::class);

// Create selector.
$selector = new Selector();
$selector->setFields(['Id', 'Name','StartDate','EndDate','Amount','Status','BudgetName','CampaignGroupId','FrequencyCapMaxImpressions','ServingStatus','AdServingOptimizationStatus','Settings','AdvertisingChannelType','AdvertisingChannelSubType','Labels','BiddingStrategyName','CampaignTrialType','BaseCampaignId','UrlCustomParameters','VanityPharmaText','SelectiveOptimization']);
$selector->setOrdering(array(new OrderBy('Name', 'ASCENDING')));

// Create paging controls.
$selector->setPaging(new Paging(0, $limit));

// Make the get request.
$page = $campaignService->get($selector);
$campaigndata =$page->getEntries() ;
 foreach ($campaigndata as $campaign) {
              $campaign->getId();
             // echo $campaign->getName();
			 // echo $campaign->getStartDate();
			 $campaigns[]= array('Id'=>$campaign->getId(), 'Name'=>$campaign->getName(),'StartDate'=>$campaign->getStartDate(),'EndDate'=>$campaign->getEndDate(),'Status'=>$campaign->getStatus(),'Budget'=>$campaign->getBudget(),'CampaignGroupId'=>$campaign->getCampaignGroupId(),'ServingStatus'=>$campaign->getServingStatus(),'AdServingOptimizationStatus'=>$campaign->getAdServingOptimizationStatus(),'Settings'=>$campaign->getSettings(),'AdvertisingChannelType'=>$campaign->getAdvertisingChannelType(),'AdvertisingChannelSubType'=>$campaign->getAdvertisingChannelSubType(),'Labels'=>$campaign->getLabels(),'CampaignTrialType'=>$campaign->getCampaignTrialType(),'BaseCampaignId'=>$campaign->getBaseCampaignId(),'UrlCustomParameters'=>$campaign->getUrlCustomParameters(),'SelectiveOptimization'=>$campaign->getSelectiveOptimization());
        }
		return $campaigns;
}

$campaigns=get_all_campaigns(100);
/* echo "<pre>";
print_r($campaigns);

echo "</pre>";   */  
/**************** End get campaigns         ************************************/


/****************  Get ad group         ************************************/
 function get_adgroups_by_campaign_id($campaign_id,$limit){
	  $oAuth2Credential = (new OAuth2TokenBuilder())
    ->fromFile()
    ->build();

$session = (new AdWordsSessionBuilder())
    ->fromFile()
    ->withOAuth2Credential($oAuth2Credential)
    ->build();

       $adWordsServices = new AdWordsServices();
	 $AdGroupService = $adWordsServices->get($session, AdGroupService::class);
// Create selector.
$selector1 = new Selector();
$selector1->setFields(['Id', 'Name','CampaignId','CampaignName','AdGroupType','Settings','Status']);
 $selector1->setOrdering([new OrderBy('Name', SortOrder::ASCENDING)]);
    $selector1->setPredicates(
        [new Predicate('CampaignId', PredicateOperator::IN, [$campaign_id])]);
  

// Create paging controls.
$selector1->setPaging(new Paging(0, $limit));

// Make the get request.
$page1 = $AdGroupService->get($selector1);
$adgroupdata =$page1->getEntries() ;
/*  echo "<pre>";
print_r($adgroupdata );

echo "</pre>";   */ 
 foreach ($adgroupdata as $adgroup) {
              $adgroup->getId();
             
 $adgroups[]= array('Id'=>$adgroup->getId(), 'Name'=>$adgroup->getName(),'CampaignId'=>$adgroup->getCampaignId(),'AdGroupType'=>$adgroup->getAdGroupType(),'Settings'=>$adgroup->getSettings(),'Status'=>$adgroup->getStatus());
        }
		return $adgroups;
 }
 
 //$adgroups = get_adgroups_by_campaign_id(895372454,100);
 /*  echo "<pre>";
print_r($adgroups );

echo "</pre>";    */
/****************  End get ad group         ************************************/

/****************  Get ads          ************************************/
  function getallads_by_group_id($adgroupid,$limit){
	  $oAuth2Credential = (new OAuth2TokenBuilder())
    ->fromFile()
    ->build();

$session = (new AdWordsSessionBuilder())
    ->fromFile()
    ->withOAuth2Credential($oAuth2Credential)
    ->build();

$adWordsServices = new AdWordsServices();
   $ads =$adWordsServices->get($session, AdGroupAdService::class);

    // Create a selector to select all ads for the specified ad group.
    $selector2 = new Selector();
    $selector2->setFields(
        ['Id', 'Status', 'HeadlinePart1', 'HeadlinePart2', 'Description','BaseCampaignId','BaseAdGroupId']);
    $selector2->setOrdering([new OrderBy('Id', SortOrder::ASCENDING)]);
    $selector2->setPredicates([
        new Predicate('AdGroupId', PredicateOperator::IN, [$adgroupid]),
        new Predicate('AdType', PredicateOperator::IN,
            [AdType::EXPANDED_TEXT_AD]),
        new Predicate('Status', PredicateOperator::IN,
            [AdGroupAdStatus::ENABLED, AdGroupAdStatus::PAUSED])
    ]);
  
// Create paging controls.
$selector2->setPaging(new Paging(0, $limit));

// Make the get request.
$page2 = $ads->get($selector2);
$adsdata = $page2->getEntries() ;
 $getads=array();
if($adsdata){
 foreach($adsdata as $adGroupAd) {
           
             
 $getads[] = array('Id'=>$adGroupAd->getAd()->getId(), 'HeadlinePart1'=>$adGroupAd->getAd()->getHeadlinePart1(),'headlinePart2'=>$adGroupAd->getAd()->getHeadlinePart2(),'description'=>$adGroupAd->getAd()->getDescription(),'BaseCampaignId'=>$adGroupAd->getBaseCampaignId(),'BaseAdGroupId'=>$adGroupAd->getBaseAdGroupId(),'Status'=>$adGroupAd->getStatus());
        }
}
if($getads){
		return $getads;
}else{
	return array();	
	
}
		
  }
  
 // $getads=getallads_by_group_id(45568134475,100);
/*   echo "<pre>";
print_r($getads);

echo "</pre>";     */

/****************  End get ads          ************************************/







function get_ad_performance_report($id){
  
$oAuth2Credential = (new OAuth2TokenBuilder())
    ->fromFile()
    ->build();

$session = (new AdWordsSessionBuilder())
    ->fromFile()
    ->withOAuth2Credential($oAuth2Credential)
    ->build();
   // Create selector.
    $selector = new Selector();
    $selector->setFields(['Id', 
         'Impressions', 'Clicks', 'Cost']);

    // Use a predicate to filter out paused criteria (this is optional).
    $selector->setPredicates([
        new Predicate('Id', PredicateOperator::IN,
            [$id])]);


    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'Performance report #' . uniqid());
  $reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::LAST_7_DAYS); 
    $reportDefinition->setReportType(
        ReportDefinitionReportType::AD_PERFORMANCE_REPORT);
		$reportDefinition->setDownloadFormat(DownloadFormat::XML);
  $reportDownloader = new ReportDownloader($session);
$reportDownloadResult = $reportDownloader->downloadReport($reportDefinition);

//Normal way of downloading to file
//$reportDownloadResult->saveToFile($filePath);
//printf("Report with name '%s' was downloaded to '%s'.\n",
//    $reportDefinition->getReportName(), $filePath);
//
//New way by calling getAsString();
 $reportAsString = $reportDownloadResult->getAsString();
 $xml= new SimpleXMLElement($reportAsString);
/* $data1=json_encode($reportAsString );
//echo json_decode(json_encode($reportAsString ));
$data = explode(')"',$reportAsString);
$data = explode(',',$data[1]);
 */
/* echo "<pre>";
print_r($xml->table);
echo "</pre>"; */
/* echo "<pre>";
print_r($xml->table->row);
echo "</pre>"; */

/* foreach($xml->table->row as $res){
echo 	$res['adID'];
	 
}*/
return $xml->table->row;
  }
  
  function adwordsstate_campaing_performance(){	
		$oAuth2Credential = (new OAuth2TokenBuilder())
    ->fromFile()
    ->build();

$session = (new AdWordsSessionBuilder())
    ->fromFile()
    ->withOAuth2Credential($oAuth2Credential)
    ->build();
	try{
   // Create selector.
    $selector = new Selector();
   $selector->setFields(['CampaignId', 'CampaignName', 'CampaignStatus' ,
         'Impressions', 'Clicks', 'Cost','ConversionRate','Conversions','ConversionValue','CostPerConversion','CostPerAllConversion','Ctr','AverageCpc','AverageCpe','AverageCost','AverageCpm','AverageCpv']);

    // Use a predicate to filter out paused criteria (this is optional).
     if($_REQUEST['platform']!="" and $_REQUEST['platform']!='all'){
			
			if($_REQUEST['platform']=='desktop'){
				$adplatform = 'DESKTOP';
			
			}
			if($_REQUEST['platform']=='mobile'){
				$adplatform = 'HIGH_END_MOBILE';
			
			}
			//HIGH_END_MOBILE
        $selector->setPredicates([ new Predicate('CampaignStatus', PredicateOperator::NOT_IN, ['PAUSED']),
       new Predicate('Device', PredicateOperator::EQUALS, [$adplatform]) ]);  
       
		
		}elseif($_REQUEST['platform']!="" and $_REQUEST['platform']!='all' and $_REQUEST['campaign']!="" and $_REQUEST['campaign']!='all'){
			
			if($_REQUEST['platform']=='desktop'){
				$adplatform = 'DESKTOP';
			
			}
			if($_REQUEST['platform']=='mobile'){
				$adplatform = 'HIGH_END_MOBILE';
			
			}
			
			$campaignid = $_REQUEST['campaign'];
			//HIGH_END_MOBILE
        $selector->setPredicates([ new Predicate('CampaignStatus', PredicateOperator::NOT_IN, ['PAUSED']),
       new Predicate('Device', PredicateOperator::EQUALS, [$adplatform]), new Predicate('CampaignId', PredicateOperator::EQUALS, [$campaignid]) ]);  
       
		
		}elseif($_REQUEST['campaign']!="" and $_REQUEST['campaign']!='all'){
			$campaignid = $_REQUEST['campaign'];
			$selector->setPredicates([
        new Predicate('CampaignId', PredicateOperator::EQUALS, [$campaignid])]);
		$selector->setPredicates([
        new Predicate('CampaignStatus', PredicateOperator::IN, ['PAUSED'])]);
		}else{
 //$selector->setPredicates([ new Predicate('CampaignStatus', PredicateOperator::NOT_IN, ['PAUSED'])]);
			/* $selector->setPredicates([
        new Predicate('CampaignStatus', PredicateOperator::IN, ['PAUSED'])],[
        new Predicate('CampaignStatus', PredicateOperator::IN, ['ENABLED'])]); */
		}


     if($_REQUEST['daterange']!=""){
		$daterange =json_decode($_REQUEST['daterange']);
		//echo $daterange->start;
		$daterangetime1 = strtotime($daterange->start);
		$daterangetime2 = strtotime($daterange->end);
		$daterange1 = date("Ymd",$daterangetime1);
		$daterange2 = date("Ymd",$daterangetime2);
		
		
	  $selector->setDateRange(new DateRange($daterange1, $daterange2));
	 }
	
    //$selector->setDateRange(new DateRange(date("Ymd", strtotime("2017-01-01")), date("Ymd",strtotime("2018-07-31"))));
		
    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'Performance report #' . uniqid());
  if($_REQUEST['daterange']!=""){
  $reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::CUSTOM_DATE); 
		}else{
			$reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::ALL_TIME); 
		}
		
    $reportDefinition->setReportType(
        ReportDefinitionReportType::CAMPAIGN_PERFORMANCE_REPORT);
	$reportDefinition->setDownloadFormat(DownloadFormat::XML);
    $reportDownloader = new ReportDownloader($session);
    $reportDownloadResult = $reportDownloader->downloadReport($reportDefinition);


	//New way by calling getAsString();
	 $reportAsString = $reportDownloadResult->getAsString();
	 $xml= new SimpleXMLElement($reportAsString);
		//$data = array();	
	$adreport = $xml->table->row;
	  echo "<pre>";
	print_r($xml);
	echo "</pre>";  

	/* $impressions =$adreport['impressions'];
	$clicks = $adreport['clicks'];
	$spend = $adreport['cost'];
	$conversions = $adreport['conversions'];
	$totalConvValue = $adreport['totalConvValue'];
	$convRate = $adreport['convRate'];
	$avgCPC = $adreport['avgCPC']; */
	
	foreach($adreport as $ad_report){
	
		$adimpressions = $adimpressions+$ad_report['impressions'];
		
		$adclicks = $adclicks+$ad_report['clicks'];
		if($ad_report['cost']>0){
		$adspend = $adspend+$ad_report['cost']/1000000;
		}
		$adconversions = $adconversions+$ad_report['conversions'];
		$adtotalConvValue = $adtotalConvValue+$ad_report['totalConvValue'];
		$adconvRate = $adconvRate+$ad_report['convRate'];
		if($ad_report['avgCPC']>0){
		$adavgCPC = $adavgCPC+$ad_report['avgCPC']/1000000;;
        }
	}
	//setlocale(LC_MONETARY, 'en_IN', NumberFormatter::CURRENCY);
	if($adspend  >0){

	 $adspend = money_format('%!i', $adspend);
	}else{
		$adspend = money_format('%!i',0);
	}
	
	$cost_per_lead=$adavgCPC;
	if($cost_per_lead  >0){
	$cost_per_lead = money_format('%!i', $cost_per_lead);
	}
	   $totalstats = array("impressions"=>$adimpressions,"spend"=>$adspend,"clicks"=>$adclicks,"conversions"=>$adconversions,"convRate"=>$adconvRate,"totalConvValue"=>$adtotalConvValue,'cost_per_lead'=>$cost_per_lead);
	 }catch (Exception $e) {
		 $aderror = array($e->getMessage());
		 $totalstats = array("impressions"=>0,"spend"=>0,"clicks"=>0,"conversions"=>0,"convRate"=>0,"totalConvValue"=>0,'cost_per_lead'=>0,"Error"=>$e->getMessage(),"aderror"=>$aderror);
					  
					 

					}
	 
	 
	
		return $totalstats;
	}
	$adwordsstate_campaing_performance = adwordsstate_campaing_performance();
	
	 echo "<pre>";
	print_r($adwordsstate_campaing_performance); 
  
   function adwordsstate()
	{	
		$oAuth2Credential = (new OAuth2TokenBuilder())
    ->fromFile()
    ->build();

$session = (new AdWordsSessionBuilder())
    ->fromFile()
    ->withOAuth2Credential($oAuth2Credential)
    ->build();
	try{
   // Create selector.
    $selector = new Selector();
   $selector->setFields(['CampaignId', 'AdGroupId', 'Id', 'Criteria',
        'CriteriaType', 'Criteria','Impressions', 'Clicks', 'Cost','ConversionRate','Conversions','ConversionValue','CostPerConversion','CostPerAllConversion','Ctr','CpcBid','AverageCpc','AverageCpe','AverageCost','AverageCpm','AverageCpv']);

    // Use a predicate to filter out paused criteria (this is optional).
     if($_REQUEST['platform']!="" and $_REQUEST['platform']!='all'){
			
			if($_REQUEST['platform']=='desktop'){
				$adplatform = 'DESKTOP';
			
			}
			if($_REQUEST['platform']=='mobile'){
				$adplatform = 'HIGH_END_MOBILE';
			
			}
			//HIGH_END_MOBILE
        $selector->setPredicates([ new Predicate('Status', PredicateOperator::NOT_IN, ['PAUSED']),
       new Predicate('Device', PredicateOperator::EQUALS, [$adplatform]) ]);  
       
		
		}elseif($_REQUEST['platform']!="" and $_REQUEST['platform']!='all' and $_REQUEST['campaign']!="" and $_REQUEST['campaign']!='all'){
			
			if($_REQUEST['platform']=='desktop'){
				$adplatform = 'DESKTOP';
			
			}
			if($_REQUEST['platform']=='mobile'){
				$adplatform = 'HIGH_END_MOBILE';
			
			}
			
			$campaignid = $_REQUEST['campaign'];
			//HIGH_END_MOBILE
        $selector->setPredicates([ new Predicate('Status', PredicateOperator::NOT_IN, ['PAUSED']),
       new Predicate('Device', PredicateOperator::EQUALS, [$adplatform]), new Predicate('CampaignId', PredicateOperator::EQUALS, [$campaignid]) ]);  
       
		
		}elseif($_REQUEST['campaign']!="" and $_REQUEST['campaign']!='all'){
			$campaignid = $_REQUEST['campaign'];
			$selector->setPredicates([
        new Predicate('CampaignId', PredicateOperator::EQUALS, [$campaignid])]);
		
		}else{
$selector->setPredicates([ new Predicate('Status', PredicateOperator::NOT_IN, ['PAUSED'])]);
			/* $selector->setPredicates([
        new Predicate('Status', PredicateOperator::IN, ['PAUSED'])],[
        new Predicate('Status', PredicateOperator::IN, ['ENABLED'])]);  */
		}


     if($_REQUEST['daterange']!=""){
		$daterange =json_decode($_REQUEST['daterange']);
		//echo $daterange->start;
		$daterangetime1 = strtotime($daterange->start);
		$daterangetime2 = strtotime($daterange->end);
		$daterange1 = date("Ymd",$daterangetime1);
		$daterange2 = date("Ymd",$daterangetime2);
		
		
	  $selector->setDateRange(new DateRange($daterange1, $daterange2));
	 }
	
    //$selector->setDateRange(new DateRange(date("Ymd", strtotime("2017-01-01")), date("Ymd",strtotime("2018-07-31"))));
		
    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'Performance report #' . uniqid());
  if($_REQUEST['daterange']!=""){
  $reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::CUSTOM_DATE); 
		}else{
			$reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::ALL_TIME); 
		}
		
    $reportDefinition->setReportType(
        ReportDefinitionReportType::CRITERIA_PERFORMANCE_REPORT);
	$reportDefinition->setDownloadFormat(DownloadFormat::XML);
    $reportDownloader = new ReportDownloader($session);
    $reportDownloadResult = $reportDownloader->downloadReport($reportDefinition);


	//New way by calling getAsString();
	 $reportAsString = $reportDownloadResult->getAsString();
	 $xml= new SimpleXMLElement($reportAsString);
		//$data = array();	
	$adreport = $xml->table->row;
	 /* echo "<pre>";
	print_r($xml);
	echo "</pre>";  */

	/* $impressions =$adreport['impressions'];
	$clicks = $adreport['clicks'];
	$spend = $adreport['cost'];
	$conversions = $adreport['conversions'];
	$totalConvValue = $adreport['totalConvValue'];
	$convRate = $adreport['convRate'];
	$avgCPC = $adreport['avgCPC']; */
	
	foreach($adreport as $ad_report){
	
		$adimpressions = $adimpressions+$ad_report['impressions'];
		
		$adclicks = $adclicks+$ad_report['clicks'];
		if($ad_report['cost']>0){
		$adspend = $adspend+$ad_report['cost']/1000000;
		}
		$adconversions = $adconversions+$ad_report['conversions'];
		$adtotalConvValue = $adtotalConvValue+$ad_report['totalConvValue'];
		$adconvRate = $adconvRate+$ad_report['convRate'];
		if($ad_report['avgCPC']>0){
		$adavgCPC = $adavgCPC+$ad_report['avgCPC']/1000000;;
        }
	}
	//setlocale(LC_MONETARY, 'en_IN', NumberFormatter::CURRENCY);
	if($adspend  >0){

	 $adspend = money_format('%!i', $adspend);
	}else{
		$adspend = money_format('%!i',0);
	}
	
	$cost_per_lead=$adavgCPC;
	if($cost_per_lead  >0){
	$cost_per_lead = money_format('%!i', $cost_per_lead);
	}
	   $totalstats = array("impressions"=>$adimpressions,"spend"=>$adspend,"clicks"=>$adclicks,"conversions"=>$adconversions,"convRate"=>$adconvRate,"totalConvValue"=>$adtotalConvValue,'cost_per_lead'=>$cost_per_lead);
	 }catch (Exception $e) {
		 $aderror = array($e->getMessage());
		 $totalstats = array("impressions"=>0,"spend"=>0,"clicks"=>0,"conversions"=>0,"convRate"=>0,"totalConvValue"=>0,'cost_per_lead'=>0,"Error"=>$e->getMessage(),"aderror"=>$aderror);
					  
					 

					}
	 
	 
	
		return $totalstats;
	}
	


	$adwordsstate = adwordsstate();
	
	 echo "<pre>";
	print_r($adwordsstate); 
	

  die;
?>


<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Campaign</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

 
  <style>
  /* Temp styles */
.header, .sidebar, .content, .footer { border: 5px solid black; }
.content, .sidebar, .footer { border-top: none; }
.sidebar.right { border-right: none; }
.sidebar.left { border-left: none; }
/* Core styles */
.header {
    position: relative; /* needed for stacking */
    height: 100px;
    width: 100%;
}
.content {
    position: relative; /* needed for stacking */
    width: 100%;
    height: 500px;
}
.sidebar {
    position: relative; /* needed for stacking */
    width: 20%;
    height: 100%;
    border-top: none;
}
.sidebar.left { float: left; }
.sidebar.left:after,
.sidebar.right:after {
    clear: both;
    content: "\0020";
    display: block;
    overflow: hidden;
}
.sidebar.right { float: right; }
.footer {
    position: relative; /* needed for stacking */
    width: 100%;
    height: 100px;
}
  </style>
</head>

<body>
 
 
<div class="header">
    <div class="header-inner"><h4 align="center">Campaign Buddy (Get data from Google adwords Test account) <h4></div>       
</div>
<div class="content">
    
    <div class="content-inner"> 
	
<table border="1" bordercolor="#6699CC" style="width:100%" >
<tr>
<th bgcolor="#336699" style="color:#FFF">Campaign_id</th>
<th bgcolor="#336699" style="color:#FFF">Campaign Name</th>

<th bgcolor="#336699" style="color:#FFF">Ad gruop Name</th>

<th bgcolor="#336699" style="color:#FFF">Status</th>
<!--th bgcolor="#336699" style="color:#FFF">Impressions</th>
<th bgcolor="#336699" style="color:#FFF">Clicks</th>
<th bgcolor="#336699" style="color:#FFF">Spent</th-->

</tr>

<?PHP
foreach ($campaigns as $campaign) {
//---------------------------------

 $adgroups = get_adgroups_by_campaign_id($campaign['Id'],100);
?>
<tr>

<td><?php echo $campaign['Id']; ?></td>
<td><?php echo $campaign['Name']; ?></td>
<td>
<table border="1" bordercolor="#6699CC" style="width:100%" >

<?php 
 if( $adgroups){
foreach ($adgroups as $res) { 
$getads = getallads_by_group_id($res['Id'],100);
  ?>
<tr><td><?php echo $res['Name']; ?>
<?php  if( $getads){ ?><td>
<table border="1" bordercolor="#6699CC" style="width:100%" >
<tr>
<th bgcolor="#336699" style="color:#FFF">Ad Name</th>
<th bgcolor="#336699" style="color:#FFF">Ad id</th>
<th bgcolor="#336699" style="color:#FFF">Impressions</th>
<th bgcolor="#336699" style="color:#FFF">Clicks</th>
<th bgcolor="#336699" style="color:#FFF">Cost</th>

</tr>
<?php
  
  
  $adreport = array();
foreach ($getads as $res1) {  

$adreport = get_ad_performance_report($res1['Id']);
 ?>
<tr><td><?php echo $res1['HeadlinePart1']; ?></td>
<td><?php echo $adreport['adID']; ?></td>
<td><?php echo $adreport['impressions']; ?></td>
<td><?php echo $adreport['clicks']; ?></td>
<td><?php echo $adreport['cost']; ?></td>
</tr>
<?php }  ?>
</table></td>
<?php }  ?>
</td></tr>
<?php 
 } } ?></table></td>




<td><?php echo $campaign['Status']; ?></td>

</tr>

<?php } ?>

	</table>


	
	</div>
   
</div>

</body>
</html>