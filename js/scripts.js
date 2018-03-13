jQuery(document).ready(function(){
	jQuery(".multiplechoice").hide();
	jQuery(".essay").hide();
	jQuery(".identification").hide();
	
	jQuery(".mjbQuizQuestionType").change(function(){
		//alert();
		if(jQuery(this).val() == "multiplechoice"){
			jQuery(this).closest('.multiplechoice').show();
		}else if(jQuery(this).val() == "identification"){
			jQuery(this).closest('.identification').show();
		}else if(jQuery(this).val() == "essay"){
			jQuery(this).closest('.essay').show();
		}
		
	});
});