<?php
	// Function to display records from database
		// Type is for the amount columns
	function display_records($type, $conn, $table) {
		$data_array = array();

		if($type == 'default') {
			$get_data = $conn->prepare('SELECT * FROM `' . $table . '` WHERE `visible` = 1');
	        $get_data->execute();
	        $count = $conn->query('SELECT FOUND_ROWS()')->fetchColumn();
	    	
	    	if($count > '0') {
		        while ($data = $get_data->fetch()) {
		            $id = $data['id'];
		            $name = $data['name'];
		            #$title = $data['title'];
		            $company = $data['company'];
		            #$address = $data['address'];
		            $city = $data['city'];
		            $postcode = $data['postcode'];
		            $tel = $data['tel'];
		            $email = $data['email'];
		            $web = $data['web'];
		            $notes = $data['notes'];
		            $owned_by = $data['owned_by'];
		            $return_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&hash=' . $table;
		            $actions = '';
		            $class = '';
		            $ab_table = 'ab_' . $table;

		            if(logged_in() == true) {
		            	$onclick = "return confirm('Are you sure you want to delete this record (ID " . $id . ") from " . $table . "?')";
		            	if(in_address_book($id, $_SESSION[$ab_table]) == true) {
		            		$actions = '<a href="#" class="remove-from-address-book show-tooltip" data-id="' . $id . '" data-table="' . $table . '" data-del="false" original-title="Remove ' . $name . ' from address book"></a>';
		            		$class = ' class="in-address-book"';
		            	} else {
		            		$actions = '<a href="#" class="add-to-address-book show-tooltip" data-id="' . $id . '" data-table="' . $table . '" original-title="Add ' . $name . ' to address book"></a>';
		            	}

		            	if($_SESSION['permissions'] == 'admin' || $owned_by == $_SESSION['id']) {
		            		$actions .= '<a href="edit.php?r=' . $id . '&table=' . $table . '&return=' . $return_url . '" class="edit-record"></a> <a href="delete.php?r=' . $id . '&table=' . $table . '&return=' . $return_url . '" onclick="' . $onclick . '" class="delete-record"></a>';
		            	}
		            }

		            $row = <<<row
					    <tr$class>
					        <td>$name</td>
					        <td>$company</td>
					        <td>$city</td>
					        <td>$postcode</td>
                            <td>$tel</td>
                            <td><a href="mailto:$email">$email</a></td>
                            <td><a href="$web" target="_blank">$web</a></td>
					        <td>$notes</td>
					        <td class="actions-td"><div>$actions</div></td>
					    </tr>
row;
					// Add row to data_array to allow all records in database to be looped through
					array_push($data_array, $row);
		        }

		        return $data_array;
		    } else {
		    	return '<p><strong>We could not find any records.</strong></p>';
		    }
	    } else {
	    	return '<p><strong>We could not find any records. Reason: Not all function variables are declared.</strong></p>';
	    }
	}

	function display_address_book($type, $conn, $table) {
		$data_array = array();
		$ab_table = 'ab_' . $table;

		$get_data = $conn->prepare('SELECT * FROM `' . $table . '` WHERE `id` IN(' . $_SESSION[$ab_table] . ')');
        $get_data->execute(); 
    
        while ($data = $get_data->fetch()) {
            $id = $data['id'];
            $name = $data['name'];
            #$title = $data['title'];
            $company = $data['company'];
            #$address = $data['address'];
            $city = $data['city'];
            $postcode = $data['postcode'];
            $tel = $data['tel'];
            $email = $data['email'];
            $web = $data['web'];
            $notes = $data['notes'];
            $owned_by = $data['owned_by'];
            $return_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&hash=' . $table;
        	$actions = '<a href="#" class="remove-from-address-book show-tooltip" data-id="' . $id . '" data-table="' . $table . '" data-del="true" original-title="Remove ' . $name . ' from address book"></a>';

			if($owned_by == $_SESSION['id']) {
				$onclick = "return confirm('Are you sure you want to delete this record (ID " . $id . ") from " . $table . "?')";
        		$actions .= '<a href="edit.php?r=' . $id . '&table=' . $table . '&return=' . $return_url . '" class="edit-record"></a><a href="delete.php?r=' . $id . '&table=' . $table . '&return=' . $return_url . '" onclick="' . $onclick . '" class="delete-record"></a>';
        	}

            $row = <<<row
        <tr>
            <td>$name</td>
            <td>$company</td>
            <td>$city</td>
            <td>$postcode</td>
            <td>$tel</td>
            <td><a href="mailto:$email">$email</a></td>
            <td><a href="$web" target="_blank">$web</a></td>
            <td>$notes</td>
            <td class="actions-td"><div>$actions</div></td>
        </tr>
row;
            // Add row to data_array to allow all records in database to be looped through
			array_push($data_array, $row);
        }

        return $data_array;
	}

	// Mysql_real_escape_string equivalent 
	function protect($value) {
	    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

	    return str_replace($search, $replace, $value);
	}

	function get_category_url($categories, $category) {
		foreach ($categories as $row) {
			if($row['category'] == $category) {
				return $row['url'];
			}
		}
	}

	function get_category_name($categories, $category) {
		foreach ($categories as $row) {
			if($row['category'] == $category) {
				return $row['name'];
			}
		}
	}

	function create_salt() {
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 3);
	}

	function validate_user($id, $first_name, $last_name, $email, $permissions, $ab_count, $ab_agents, $ab_worldwide, $ab_promoters, $ab_digital, $ab_print, $ab_broadcast, $ab_venues, $ab_london, $ab_festivals, $ab_nonukfests, $ab_tech, $ab_bline, $ab_staff, $ab_classical) {
	    session_regenerate_id (); // Security measure
	    $_SESSION['valid'] = 1;
	    $_SESSION['id'] = $id;
	    $_SESSION['first_name'] = $first_name;
	    $_SESSION['last_name'] = $last_name;
	    $_SESSION['email'] = $email;
	    $_SESSION['permissions'] = $permissions;
	    $_SESSION['ab_count'] = $ab_count;
        $_SESSION['ab_agents'] = $ab_agents;
        $_SESSION['ab_worldwide'] = $ab_worldwide;
        $_SESSION['ab_promoters'] = $ab_promoters;
        $_SESSION['ab_digital'] = $ab_digital;
        $_SESSION['ab_print'] = $ab_print;
        $_SESSION['ab_broadcast'] = $ab_broadcast;
        $_SESSION['ab_venues'] = $ab_venues;
        $_SESSION['ab_london'] = $ab_london;
        $_SESSION['ab_festivals'] = $ab_festivals;
        $_SESSION['ab_americana'] = $ab_americana; // used to be called national but this table has either been renamed or doesn't exist
        $_SESSION['ab_nonukfests'] = $ab_nonukfests;
        $_SESSION['ab_tech'] = $ab_tech; // added by Tris
        $_SESSION['ab_bline'] = $ab_bline; // added by Tris
        $_SESSION['ab_staff'] = $ab_staff; // added by Tris
        $_SESSION['ab_classical'] = $ab_classical; // added by Tris
	}

	function logged_in() {
	    if(isset($_SESSION['valid']) && $_SESSION['valid']) {
	        return true;
	    } else {
	    	return false;
	    }
	}

	function logout() {
	    $_SESSION = array(); // Destroy all of the session variables
	    session_destroy();
	}

	function in_multiarray($key, $value, $array) {
	    $top = sizeof($array) - 1;
	    $bottom = 0;
	    while($bottom <= $top)
	    {
	        if($array[$bottom][$key] == $value)
	            return true;
	        else 
	            if(is_array($array[$bottom][$key]))
	                if(in_multiarray($value, ($array[$bottom][$key])))
	                    return true;

	        $bottom++;
	    }        
	    return false;
	}

	// Function checks whether an ID already exists in users address book
	function in_address_book($rid, $ab_table) {
		$check_exists = explode(', ', $ab_table);
	    if(in_array($rid, $check_exists)) {
	    	return true;
	    } else {
	    	return false;
	    }
	}

	function count_arr($arr) {
		if(!array_filter($arr)) {
		 	// array contains only empty values
			return '0';
		} else {
			return count($arr);
		}
	}
?>