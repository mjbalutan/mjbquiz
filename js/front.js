jQuery(document).ready(function(){
	jQuery("#submitQuiz").click(function(){
		var score = 0;
		jQuery('#quiz input[type="text"], #quiz input[type="radio"]:checked, #quiz textarea').each(
			function(index){  
				var input = jQuery(this);
					
					if(input.prop("tagName").toLowerCase() == "textarea" || input.attr("type") == "text"){
						var keywords = input.data("keywords");
						if(keywords == input.val()){
							score = score + input.data("score");
						}else{
							score = score + 0;
						}
					}else{
						score = score + input.data("score");
					}
					
					
			}
		);
		alert(score);
	});
	
});