jQuery(document).ready(function(){
	jQuery(".multiplechoice").hide();
	jQuery(".essay").hide();
	jQuery(".identification").hide();
	jQuery(document).on('change', '.mjbQuizQuestionType', function() {
		//alert();
		if(jQuery(this).val() == "identification"){
			jQuery(this).parents(".mjbQuizContent").children(".identification").show();
			jQuery(this).parents(".mjbQuizContent").children(".essay").hide();
			jQuery(this).parents(".mjbQuizContent").children(".multiplechoice").hide();
		}else if(jQuery(this).val() == "essay"){
			jQuery(this).parents(".mjbQuizContent").children(".essay").show();
			jQuery(this).parents(".mjbQuizContent").children(".identification").hide();
			jQuery(this).parents(".mjbQuizContent").children(".multiplechoice").hide();
		}else if(jQuery(this).val() == "multiplechoice"){
			jQuery(this).parents(".mjbQuizContent").children(".multiplechoice").show();
			jQuery(this).parents(".mjbQuizContent").children(".essay").hide();
			jQuery(this).parents(".mjbQuizContent").children(".identification").hide();
		}
	});
});
