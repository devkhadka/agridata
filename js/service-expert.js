$(document).ready(function(){

	$('#students').hide();
	$("#farmer").hide();
	$("#research").hide();
	$("#btnSubmit").attr('disabled',"true");
	
	$("#selectprofession").change(function(){		
		if(this.value == 'student')	{			
			$("#students").show();
			$("#farmer").hide();
			$("#research").hide();	
			$("#btnSubmit").removeAttr('disabled');			
		}		
		else if(this.value == 'farmer') {
			$('#students').hide();
			$("#farmer").show();
			$("#research").hide();
			$("#btnSubmit").removeAttr('disabled');
		}
		else if(this.value == 'research'){
			$('#students').hide();
			$("#farmer").hide();
			$("#research").show();
			$("#btnSubmit").removeAttr('disabled');
		}			
		else{
			$('#students').hide();
			$("#farmer").hide();
			$("#research").hide();
			$("#btnSubmit").attr('disabled',"true");
		}
	});
});	
