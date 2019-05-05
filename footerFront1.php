<!--Footer-->
  <footer id="footer" class="footer">
    <div class="container">

      <div class="row">
      <div class="col-md-3">
      <div class="logo-set">
     <img src="front/assets/img/footer-logo.png">
      </div>
      </div>
      
      <div class="col-md-9">
      
      <div class="sshdg">
      <div class="col-md-3">
LivaNova USA, Inc.<br> 
100 Cyberonics Boulevard <br>
Houston, TX 77058 <br>
763.220.4410
      </div>
      
      <div class="col-md-3">
      <div class="spacw">
info@artforheartfailure.com <br>
www.livanova.com  <br>
www.artforheartfailure.com
      </div> </div>
      
      <div class="col-md-6 ">

      </div>
      
      <div class="col-md-12">
      <div class="hdhhwddd">
      <h3> important safety information </h3>
  <p>Contraindication, warning and precautions
The Vitaria System cannot be used on patients with a history of AV block. Do not use shortwave diathermy, mikcrowave daithermy, or therapeutic ultrasound diathermy or patients implanted with a VITARIA System. 
Diagnostic ultrasound is  not included in the contraindication. Magnetic Resonance Imaging(MRI)- The VITARIA Sysstem is MR Unsafe. Patients with the VITARIA System should not have MRI procedures performed. Surgery may be required to remove the VITARIA SYSTEm if an MRI is neded
Patients with existing ulcers (gastric, duodenal or other) may have their condition aggraveted by ART. Patients with ulcers should have veluated prior to implantyation and monitored floowoing irritation of stimulation. Potential surgetry-related adverse events include dyspepsis (indigestion), dysphagia (difficulty swallowing);, dyspnea(difficulty breathing, shortness o breath), increased coughing, laryngismus (throat, larynx spasms), painm, paresthesia (prickling of skin), phyaryngitis (inflammation of the pharynx, tgh
 </p>
      </div> </div>
      
      
      </div>
      
      
      </div>
 
      
      
      
      
      </div>

      <div class="credits">
        LivaNova PLC- Registered in England and Wales Registered No. 09451374- 20 Eastbourne Terrace, London, W2 6LG, United Kingdom
      </div>
      
    </div>
  </footer>
  <!--/ Footer-->
<script>
function openCity(evt, cityName) {
    //alert(cityName);
    
    if(cityName=='Map')
    {
    var element = document.getElementById("Map");
    element.classList.remove("mobole_device");
     var element = document.getElementById("List");
    element.classList.add("mobole_device");
    }else{
        
    var element = document.getElementById("List");
    element.classList.remove("mobole_device");
     var element = document.getElementById("Map");
    element.classList.add("mobole_device");
        
    }
    
  
}
</script>



  <!-- <script src="front/assets/js/jquery.min.js"></script> -->
  <script src="front/assets/js/jquery.easing.min.js"></script>
  <script src="front/assets/js/bootstrap.min.js"></script>
  <script src="front/assets/js/custom.js"></script>
  <!--script src="front/contactform/contactform.js"></script-->
  <script>
    $(document).ready(function(){
     
	$("#search-box").keyup(function(){
		// alert($(this).val().length);

		if($(this).val().length>=3){
	   	$.ajax({
		type: "POST",
		url: "autosearch.php",
		
		data:'keyword='+$(this).val(),
		
		beforeSend: function(){
		
		},
		success: function(data)
		{
		$("#resultdata").show();
		$("#resultdata").html(data);
		
		}
		});
		}
	});
});
//To select country name
function selectVal(val) {
$("#search-box").val(val);
 
  $("#clinic_search").trigger( "click" );
$("#resultdata").hide();
}
    
</script> 

</body>
</html>