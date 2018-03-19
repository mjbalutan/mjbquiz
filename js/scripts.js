jQuery(document).ready(function(){
	jQuery(".multiplechoice").hide();
	jQuery(".essay").hide();
	jQuery(".identification").hide();
	
	jQuery('#mjbAdd').click(function(){
		var item = jQuery('.elements input[name="element"]:checked').val();
		var i = 1;
		
		if(item == "ide"){
			html = "<div class='mjbItemIde" + i + "'>";
			html = "<div class='col-8'>";
			html += "<label for='mjbItemIde_question-"+ i +"'>Question</label>";
			html += "<input type='text' id='mjbItemIde_question-" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemIde_question-a"+ i +"'>Answer</label>";
			html += "<input type='text' id='mjbItemIde_question-a" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemIde_question-s" + i + "'>Score</label>";
			html += "<input type='text' id='mjbItemIde_question-s" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='clr'></div>";
			html += "</div>";
			jQuery(html).appendTo(".containerContent");
		}else if(item == "multi"){
			html = "<div class='mjbItem" + i + "'>";
			html = "<div class='col-8'>";
			html += "<label for='mjbItemMul_question-"+ i +"'>Question</label>";
			html += "<input type='text' id='mjbItemMul_question-" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemMul_question-a"+ i +"'>Answer</label>";
			html += "<input type='text' id='mjbItemMul_question-a" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemMul_question-s" + i + "'>Score</label>";
			html += "<input type='text' id='mjbItemMul_question-s" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='clr'></div>";
			html += "</div>";
			jQuery(html).appendTo(".containerContent");
		}else if(item == "es"){
			html = "<div class='mjbItem" + i + "'>";
			html = "<div class='col-8'>";
			html += "<label for='mjbItemEs_question-"+ i +"'>Question</label>";
			html += "<input type='text' id='mjbItemEs_question-" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemEs_question-a"+ i +"'>Keywords</label>";
			html += "<input type='text' id='mjbItemEs_question-a" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemEs_question-s" + i + "'>Score</label>";
			html += "<input type='text' id='mjbItemEs_question-s" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='clr'></div>";
			html += "</div>";
			jQuery(html).appendTo(".containerContent");
		}else if(item == "sb"){
			html = "<div class='mjbItem" + i + "'>";
			html = "<div class='col-8'>";
			html += "<label for='mjbItemSb_question-"+ i +"'>No. of Points to Continue</label>";
			html += "<input type='text' id='mjbItemSb_question-" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<label for='mjbItemSb_question-a"+ i +"'>Button Text</label>";
			html += "<input type='text' id='mjbItemSb_question-a" + i + "' value=''/>";
			html += "</div>";
			html += "<div class='clr'></div>";
			html += "</div>";
			jQuery(html).appendTo(".containerContent");
		}
	});
});
