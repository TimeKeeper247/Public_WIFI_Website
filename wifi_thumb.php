<?php
echo '
	<div class="col-4">
		<div class="thumbnail">
		  <div class="thumbnailImage">
			<img id="' . $results['itemID'] . '" src="img/coming-soon.jpg" alt="' . $results['itemName'] . '">
		  </div>
		  <div class="thumbnailCaption">
			<h3 class="thumbnailTitle"><a href="https://cab230.sef.qut.edu.au/Students/n9554181/individual.php?itemID=' . $results['itemID'] . '">' . $results['itemName'] . '</a></h3>
			<span class="thumbnailRatings"> 4 <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></span>
			<a href="individual.php?itemID=' . $results['itemID'] . '" class="btns btn thumbnailButton">
			  <div class="icon"><i class="fas fa-eye"></i></div>
			  <span>View</span>
			</a>
		  </div>
		</div>
	</div>
	<script>
    thumbgen("' . $results['itemID'] . ", " . $results['itemName'] . ' australia");
    </script>
	';
?>