<?php
	//Quiz Content Meta Box
	$value = get_post_meta( $post->ID, 'mjb_quiz_content_'.$post->ID, true );
	$value = json_decode(base64_decode($value), true);
?>
<div class="container">
	<div class="elements">
		<ul>
			<li>
				<input type="radio" id="mjbQuizIdentify" name="element" value="ide" />
				<label for="mjbQuizIdentify">Identification</label>
			</li>
			<li>
				<input type="radio" id="mjbQuizMulti" name="element" value="multi" />
				<label for="mjbQuizMulti">Multiple Choice</label>
			</li>
			<li>
				<input type="radio" id="mjbQuizEssay" name="element" value="es" />
				<label for="mjbQuizEssay">Essay</label>
			</li>
			<li>
				<input type="radio" id="mjbQuizSBreak" name="element" value="sb" />
				<label for="mjbQuizSBreak">Section Break</label>
			</li>
		</ul>
		<div class="clr"></div>
	</div>
	<div class="containerContent">
		<?php if($value != ""){
			echo '<pre>';
			print_r($value);
			echo '</pre>';
		}else{
		}
			?>
	</div>
	<div class="btnContainer">
		<a href="#add" id="mjbAdd" class="mjbQuizbtn">Add</a><a href="#delete" id="mjbDel" class="mjbQuizbtn">Delete</a>
	</div>
</div>
			
