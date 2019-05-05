<?php 
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

use Google\AdsApi\AdWords\v201806\cm\AdGroupService;

use Google\AdsApi\AdWords\v201806\cm\Predicate;

use Google\AdsApi\AdWords\v201806\cm\PredicateOperator;

use Google\AdsApi\AdWords\v201806\cm\AdGroupAdService;

use Google\AdsApi\AdWords\v201806\cm\AdGroupAdStatus;

use Google\AdsApi\AdWords\v201806\cm\AdType;

use Google\AdsApi\AdWords\v201806\cm\DateRange;

use Google\AdsApi\AdWords\Reporting\v201806\DownloadFormat;

use Google\AdsApi\AdWords\Reporting\v201806\ReportDefinition;

use Google\AdsApi\AdWords\Reporting\v201806\ReportDefinitionDateRangeType;

use Google\AdsApi\AdWords\Reporting\v201806\ReportDownloader;

use Google\AdsApi\AdWords\ReportSettingsBuilder;

use Google\AdsApi\AdWords\v201806\cm\ReportDefinitionReportType;

use Google\Auth\CredentialsLoader;

use Google\Auth\OAuth2;

use Google\AdsApi\AdWords\v201806\cm\AdServingOptimizationStatus;

use Google\AdsApi\AdWords\v201806\cm\AdvertisingChannelType;

use Google\AdsApi\AdWords\v201806\cm\BiddingStrategyConfiguration;

use Google\AdsApi\AdWords\v201806\cm\BiddingStrategyType;

use Google\AdsApi\AdWords\v201806\cm\Budget;

use Google\AdsApi\AdWords\v201806\cm\BudgetBudgetDeliveryMethod;

use Google\AdsApi\AdWords\v201806\cm\BudgetOperation;

use Google\AdsApi\AdWords\v201806\cm\BudgetService;

use Google\AdsApi\AdWords\v201806\cm\Campaign;

use Google\AdsApi\AdWords\v201806\cm\CampaignOperation;

use Google\AdsApi\AdWords\v201806\cm\CampaignStatus;

use Google\AdsApi\AdWords\v201806\cm\FrequencyCap;

use Google\AdsApi\AdWords\v201806\cm\GeoTargetTypeSetting;

use Google\AdsApi\AdWords\v201806\cm\GeoTargetTypeSettingNegativeGeoTargetType;

use Google\AdsApi\AdWords\v201806\cm\GeoTargetTypeSettingPositiveGeoTargetType;

use Google\AdsApi\AdWords\v201806\cm\Level;

use Google\AdsApi\AdWords\v201806\cm\ManualCpcBiddingScheme;

use Google\AdsApi\AdWords\v201806\cm\Money;

use Google\AdsApi\AdWords\v201806\cm\NetworkSetting;

use Google\AdsApi\AdWords\v201806\cm\Operator;

use Google\AdsApi\AdWords\v201806\cm\TimeUnit;

use Google\AdsApi\AdWords\v201806\cm\AdGroup;

use Google\AdsApi\AdWords\v201806\cm\AdGroupOperation;

use Google\AdsApi\AdWords\v201806\cm\AdGroupStatus;

use Google\AdsApi\AdWords\v201806\cm\CpcBid;

use Google\AdsApi\AdWords\v201806\cm\CriterionTypeGroup;
use Google\AdsApi\AdWords\v201806\cm\TargetingSetting;
use Google\AdsApi\AdWords\v201806\cm\TargetingSettingDetail;
use Google\AdsApi\AdWords\v201806\cm\AdGroupAd;
use Google\AdsApi\AdWords\v201806\cm\AdGroupAdOperation;
use Google\AdsApi\AdWords\v201806\cm\ExpandedTextAd;	
use Google\AdsApi\AdWords\v201806\cm\Ad;
use Google\AdsApi\AdWords\v201806\cm\AdOperation;
use Google\AdsApi\AdWords\v201806\cm\AdService;
use Google\AdsApi\AdWords\v201806\cm\CampaignCriterion;
use Google\AdsApi\AdWords\v201806\cm\NegativeCampaignCriterion;

use Google\AdsApi\AdWords\v201806\cm\CampaignCriterionOperation;

use Google\AdsApi\AdWords\v201806\cm\CampaignCriterionService;

 use Google\AdsApi\AdWords\v201806\cm\Location;
 use Google\AdsApi\AdWords\v201806\cm\TargetSpendBiddingScheme;
 use Google\AdsApi\AdWords\v201806\cm\TargetCpaBiddingScheme;
 use Google\AdsApi\AdWords\v201806\cm\TargetRoasBiddingScheme;
 use Google\AdsApi\AdWords\v201806\cm\MaximizeConversionsBiddingScheme;
 //use Google\AdsApi\AdWords\v201806\cm\EnhancedCpcBiddingScheme;
 use Google\AdsApi\AdWords\v201806\cm\AdGroupCriterionOperation;
use Google\AdsApi\AdWords\v201806\cm\AdGroupCriterionService;
use Google\AdsApi\AdWords\v201806\cm\BiddableAdGroupCriterion;
use Google\AdsApi\AdWords\v201806\cm\Keyword;
use Google\AdsApi\AdWords\v201806\cm\KeywordMatchType;
use Google\AdsApi\AdWords\v201806\cm\NegativeAdGroupCriterion;

use Google\AdsApi\AdWords\v201806\cm\UrlList;

use Google\AdsApi\AdWords\v201806\cm\UserStatus;

function Get_campaigns_list(){	
		$all_listing =array();
	/*********Google adword detail**********/
		$clientId ='53143249862-9ts01onee6dldhpsruu46gd3gllb4va7.apps.googleusercontent.com';
		$clientSecret = 'a00zAPYTKosH5A-27RMgEzNv';
		$developerToken = 'fDkJjMMorm43ySkc_RY0fA';
		$refreshToken = '1/Tg8lluLU8a7pwNCtYjhZGFbVqhYmvg3y1jPuSqI93Hk';
		$clientCustomerId= '619-379-6090';
	/*********end Google adword detail**********/
	try{
    $oAuth2Credential = (new OAuth2TokenBuilder())
		->withClientId($clientId)
		->withClientSecret($clientSecret)
		->withRefreshToken($refreshToken)
		->build();
    $session = (new AdWordsSessionBuilder())->withDeveloperToken($developerToken)->withClientCustomerId($clientCustomerId)->withOAuth2Credential($oAuth2Credential)->build();
	$adWordsServices = new AdWordsServices();
	$campaignService = $adWordsServices->get($session, CampaignService::class);

	// Create selector.
	
	$selector = new Selector();
	$selector->setFields(['Id', 'Name','StartDate','EndDate','Amount','Status','BudgetName','CampaignGroupId','FrequencyCapMaxImpressions','ServingStatus','AdServingOptimizationStatus','Settings','AdvertisingChannelType','AdvertisingChannelSubType','Labels','BiddingStrategyName','CampaignTrialType','BaseCampaignId','UrlCustomParameters','VanityPharmaText','SelectiveOptimization']);

	$selector->setOrdering(array(new OrderBy('Name', 'ASCENDING')));
    $selector->setPredicates([new Predicate('Status', PredicateOperator::IN, ['ENABLED'])]);
	// Create paging controls.
	$selector->setPaging(new Paging(0, 100));
	// Make the get request.
    $page = $campaignService->get($selector);
	$campaigndata =$page->getEntries() ;
	$adwordscampaigns = array();
	foreach ($campaigndata as $campaign) {
             $StartDate = date("F,d Y", strtotime($campaign->getStartDate()));
			 $adwordscampaigns[]= array('Id'=>$campaign->getId(), 'Name'=>$campaign->getName(),'StartDate'=>$StartDate ,'EndDate'=>$campaign->getEndDate(),'Status'=>$campaign->getStatus(),"Edit_time"=>$StartDate,"type"=>"Adwords","created_time"=>$StartDate);
        }
	} catch (Exception $e) {
		$adwordscampaigns=array();
	}
		return $adwordscampaigns;
	}
	$campaigns = Get_campaigns_list();
	//print_r($campaigns);
	


	/* Search filter of adwords stats report data by api.  */
	
function adwordsstate_filter(){	
    $clientId ='53143249862-9ts01onee6dldhpsruu46gd3gllb4va7.apps.googleusercontent.com';
	$clientSecret = 'a00zAPYTKosH5A-27RMgEzNv';
	$developerToken = 'fDkJjMMorm43ySkc_RY0fA';
    $refreshToken = '1/Tg8lluLU8a7pwNCtYjhZGFbVqhYmvg3y1jPuSqI93Hk';
    $clientCustomerId= '619-379-6090';
    $adimpressions =0;
	$adclicks=0;
	$adspend=0 ;
	$adconversions=0;
	$adtotalConvValue=0;
	$adconvRate=0;
	$adavgCPC=0;	

/********* Google adword detail        **********/

	$adw_account_id = '619-379-6090';
	$clientCustomerId = $adw_account_id ;
	
	/*********  end Google adword detail **********/
	
    $oAuth2Credential = (new OAuth2TokenBuilder())->withClientId($clientId)->withClientSecret($clientSecret)->withRefreshToken($refreshToken)->build();
	
	
	try{
    $session = (new AdWordsSessionBuilder())->withDeveloperToken($developerToken)->withClientCustomerId($clientCustomerId)->withOAuth2Credential($oAuth2Credential)->build();
   // Create selector.
   $selector = new Selector();
   $selector->setFields(['CampaignId', 'AdGroupId', 'Id', 'Criteria',
        'CriteriaType', 'Criteria','Impressions', 'Clicks', 'Cost','ConversionRate','Conversions','ConversionValue','CostPerConversion','CostPerAllConversion','Ctr','CpcBid','AverageCpc','AverageCpe','AverageCost','AverageCpm','AverageCpv']);
	$CampaignId= "1495830197";

    // Use a predicate to filter out paused criteria (this is optional).

     $selector->setPredicates([new Predicate('CampaignId', PredicateOperator::IN, [$CampaignId])]);
    if(@$_REQUEST['daterange']!=""){
		$daterange =json_decode($_REQUEST['daterange']);
		//echo $daterange->start;
		$daterangetime1 = strtotime($daterange->start);
		$daterangetime2 = strtotime($daterange->end);
		$daterange1 = date("Ymd",$daterangetime1);
		$daterange2 = date("Ymd",$daterangetime2);
	    $selector->setDateRange(new DateRange($daterange1, $daterange2));
	}
    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'Performance report #' . uniqid());
    if(@$_REQUEST['daterange']!=""){
    $reportDefinition->setDateRangeType(
    ReportDefinitionDateRangeType::CUSTOM_DATE); 
	}else{
		$reportDefinition->setDateRangeType(ReportDefinitionDateRangeType::ALL_TIME); 
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
	$adspend=0;
	$adavgCPC =0;
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
	//$adwordsstate_filter = adwordsstate_filter();
	//print_r($adwordsstate_filter);
	
	?>