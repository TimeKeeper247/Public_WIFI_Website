<?php
	$search_value = filter_input(INPUT_GET, 'searchInput');
	$select_value = filter_input(INPUT_GET, 'searchSuburb');
	$rating_value = filter_input(INPUT_GET, 'searchRating');
	
	$searched_words = preg_split("/[\s,]+/", trim($search_value, " \t\n\r\0\x0B"));
	$words_lower = array_map('strtolower', $searched_words);
	$unique_words = array_unique($words_lower);

	$common_words = array(".",","," ","in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then","there","where","like","stuff","and","things","are","spot","hotspot","wifi");
	$keywords = array_diff($unique_words, $common_words);
	
	// suburb search
	$subquery = $pdo->prepare("SELECT * FROM items WHERE itemSuburb = :suburb");
	$subquery->bindvalue(':suburb', trim($select_value));
	$subquery->execute();
	$result_arr = array();
	$match = false;
	while ($result = $subquery->fetch(PDO::FETCH_ASSOC)) {
		foreach($result_arr as $res){
  			if ($res['itemID'] == $result['itemID']) {
  			    $match = true;
  			    break;
  			}
		}
		if ($match) {
		    $match = false;
		    continue;
		}
		array_push($result_arr, $result);
	}

	// custom query search
	foreach($keywords as $words) {
		if(!empty($words)) {
			$sql = "SELECT * FROM items " .
				  "WHERE (itemName LIKE :keyword 
				  OR itemAddress LIKE :keyword 
				  OR itemSuburb LIKE :keyword
				  ) ";
			$query = $pdo->prepare($sql);
			$query->bindValue(':keyword', '%' . trim($words) . '%');
			$query->execute();
			
			while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			  foreach($result_arr as $res){
	  			  if ($res['itemID'] == $result['itemID']) {
	  			    $match = true;
	  			    break;
	  			  }
			  }
			  if ($match) {
			    $match = false;
			    continue;
			  }
				array_push($result_arr, $result);
			}
		}
	}
	
	// search by rating
	$rating_query = $pdo->query('SELECT itemID, reviewRating FROM reviews');
	$rating_results = array();
	while ($result = $rating_query->fetch(PDO::FETCH_ASSOC)) {
		if(isset( $rating_results[$result['itemID']] )) {
	        $rating_results[$result['itemID']] = $rating_results[$result['itemID']] . ' ' . $result['reviewRating'];
	    } else {
	        $rating_results[$result['itemID']] = $result['reviewRating'];
	    }
	}
	
	$rated_items = array();
	foreach($rating_results as $ID => $ratings){
		$ratings = explode(' ', trim($ratings));
		$average = round(array_sum($ratings)/count($ratings));
		$rating_results[$ID] = $average;
		
		if(!empty($_GET['searchInput']) || isset($_GET['searchSuburb'])){
			foreach($result_arr as $res){
				if ($res['itemID'] == $ID && $rating_value == $average){
					array_push($rated_items, $res);
				}
			}
		} else {
			$all_query = $pdo->query('SELECT * FROM items');
			while ($result = $all_query->fetch(PDO::FETCH_ASSOC)) {
				if ($result['itemID'] == $ID && $rating_value == $average){
					array_push($rated_items, $result);
				}
			}
		}
	}
	if ($rating_value > 0){
		$result_arr = $rated_items;
	}
?>