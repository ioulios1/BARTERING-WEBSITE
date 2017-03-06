<!DOCTYPE html>
<html>
<head>
	<title>Administration Page</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/admin.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		table th { background-color:#5882FA; color:white; }
		#linkButton { background:none; border:none; color:#0066ff; text-decoration:underline; cursor:pointer; }
		/*
		ul.topnav { list-style-type:none; margin:0; padding:0; overflow:hidden; background-color:#333; }
		.tree { text-align:center; }
		.tree > ul { display:inline-block; font-size:15px; }
		ul.topnav li { float:left; }
		ul.topnav li a { display: block; color:white; text-align:center; padding:14px 16px; text-decoration:none; }
		ul.topnav li a:hover:not(.active) { background-color:#111; }
		ul.topnav li a.active { background-color:#4CAF50; }
		ul.topnav li.right { float:right; }
		*/
	</style>
</head>
<body>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand">-ΤοΠάρεΔώσε-</a>
		</div>
		<ul class="nav navbar-nav">
			<!--<li><a href="moderator.php">Αρχική</a></li>-->
			<li><a href="?option=users">Διαχείριση χρηστών</a></li>
			<li><a href="?option=categories">Διαχείριση κατηγοριών</a></li>
			<!--<li><a href="?option=category_tree">Σχεδιάγραμμα κατηγοριών</a></li>-->
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a><span class="glyphicon glyphicon-user"></span> Γεια σου <?php session_start(); echo $_SESSION['moderator']?></a></li>
			<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Έξοδος</a></li>
		</ul>
	</div>
</nav>

<?php
if(!$_SESSION['login'] == 1) header("Location: index.php");
/*
status = 0 -> request for registration (αίτηση εγγραφής)
status = 1 -> verified registration (εγκεκριμένος χρήστης)
status = 2 -> pause (προσωρινή παύση χρήστη)
διαγραφή χρήστη -> οριστική παύση χρήστη
*/
if($_GET['option'] == 'users') users();
if($_GET['option'] == 'categories') categories();
if($_GET['option'] == 'category_tree') category_tree();

function users() {
	include '../db_connection.php';
	$sort = 0; //initial value

	if (isset($_POST['accept'])) {
		$user = $_POST['accept'];
		$update_status = mysqli_query($connection, "UPDATE users SET status = 1 WHERE username = '$user' "); //updates user status so as to confirm registration
	}
	else if (isset($_POST['pause'])) {
		$user = $_POST['pause'];
		$update_status = mysqli_query($connection, "UPDATE users SET status = 2 WHERE username = '$user' "); //updates user status so as to pause user's activity
	}
	else if (isset($_POST['delete'])) {
		$user = $_POST['delete'];
		$update_status = mysqli_query($connection, "DELETE FROM users WHERE username = '$user' "); //deletes selected user
	}
	
	if (isset($_POST['sort'])) {
		$sort = 1;
		$show_users = mysqli_query($connection, "SELECT username, password, status FROM users ORDER BY status"); //existing users with ascending sort
	}
	else if (isset($_POST['sort_desc'])) {
		$sort = 2;
		$show_users = mysqli_query($connection, "SELECT username, password, status FROM users ORDER BY status DESC"); //existing users with descending sort
	}
	else
		$show_users = mysqli_query($connection, "SELECT username, password, status FROM users"); //existing users

	$n = mysqli_num_fields($show_users); //how many columns are there in users
	echo '<table class="table table-striped table-bordered table-hover table-condensed">';
	
	if ($sort == 0) {
		echo '<th>username</th><th>password</th><form method="post" action=""><th>status 
		      <input type="image" name="sort" src="images/sort.png" value="status" height="10" width="10">
	          </th></form><th>Ενέργεια</th>';
	}
	else if ($sort == 1) {
		echo '<th>username</th><th>password</th><form method="post" action=""><th>status 
		      <input type="image" name="sort_desc" src="images/sort_desc.png" value="status" height="10" width="10">
	          </th></form><th>Ενέργεια</th>';
	}
	else if ($sort == 2) {
		echo '<th>username</th><th>password</th><form method="post" action=""><th>status 
		      <input type="image" name="sort" src="images/sort_asc.png" value="status" height="10" width="10">
	          </th></form><th>Ενέργεια</th>';
	}
	
	while ($row = mysqli_fetch_array($show_users)) {
		echo '<tr>';
		if ($row[2] == 0) $row[2] = 'Αίτημα εγγραφής';
		else if ($row[2] == 1) $row[2] = 'Ενεργός χρήστης';
		else $row[2] = 'Παύση χρήστη';
	
		for ($i=0; $i<$n; $i++) {
			echo '<td>' . $row[$i] . '</td>';
		}
		echo '<td style="width:20%"><form method="post" action="">';
		if ($row['status'] == 0) {
			echo '<button type="submit" name="accept" id="linkButton" value="'.$row['username'].'"><span class="glyphicon glyphicon-ok" style="color:green"></span>Αποδοχή</button>';
		}
		else if ($row['status'] == 1) {
			echo '<button type="submit" name="pause" id="linkButton" value="'.$row['username'].'"><span class="glyphicon glyphicon-pause" style="color:brown"></span>Παύση</button><br>
			      <button type="submit" name="delete" id="linkButton" value="'.$row['username'].'"><span class="glyphicon glyphicon-trash" style="color:red"></span>Διαγραφή</button>';
		}
		else {
			echo '<button type="submit" name="accept" id="linkButton" value="'.$row['username'].'"><span class="glyphicon glyphicon-play" style="color:blue"></span>Αναίρεση Παύσης</button><br>
			      <button type="submit" name="delete" id="linkButton" value="'.$row['username'].'"><span class="glyphicon glyphicon-trash" style="color:red"></span>Διαγραφή</button>';	
		}
		echo '</form></td></tr>';
	}
	echo '</table>';
	
	mysqli_close($connection);
}

function categories() {
	include '../db_connection.php';
	if (isset($_POST['category'])) {
		$category = $_POST['category'];
		if ($category == NULL) echo '<script language="javascript">alert("Συμπλήρωσε το πεδίο.")</script>';
		else {
			$parent_id = $_POST['parents'];
			$leaf = 1; //every new category is leaf
			if ($parent_id != 0) {
				$update_parent_leaf = mysqli_query($connection, "UPDATE categories SET leaf = 0 WHERE category_id = '$parent_id'");
			}
			$add = mysqli_query($connection, "INSERT INTO categories (name, parent_id, leaf) VALUES('$category', $parent_id, $leaf)");
		}
	}

	if (isset($_POST['delete'])) {
		$c_id = $_POST['delete'];
		$parent_of_c_id = mysqli_query($connection, "SELECT leaf, parent_id FROM categories WHERE category_id = $c_id");
		$row = mysqli_fetch_array($parent_of_c_id);
		$id = $row['parent_id']; //parent of deleted category
		//check if there are products in this category
		$check_products = mysqli_query($connection, "SELECT product_id FROM products WHERE category_id = $c_id");
		$num_of_products =  mysqli_num_rows($check_products);

		//if ($id == 0)
		//		$check = mysqli_query($connection, "SELECT parent_id FROM categories where parent_id = $c_id");
		//else 	
	    // check if there are other subcategories in the parent of the deleted category
		$check = mysqli_query($connection, "SELECT parent_id FROM categories where parent_id = $id");
		$num_rows = mysqli_num_rows($check);
		
		if ($row['leaf'] == 0) {
		//if ($id == 0 && $num_rows > 0) //root
		//{
			echo '<script language="javascript">alert("Σφάλμα! Η παρούσα κατηγορία περιέχει υποκατηγορίες.")</script>';
		}
		else if ($num_of_products > 0) {
			echo '<script language="javascript">alert("Σφάλμα! Η παρούσα κατηγορία περιέχει προϊόντα.")</script>';
		}
		else {
			if ($num_rows == 1) 
				$update_parent_leaf = mysqli_query($connection, "UPDATE categories SET leaf = 1 WHERE category_id = '$id'");
			$delete_category = mysqli_query($connection, "DELETE FROM categories WHERE category_id = $c_id"); //deletes selected category
		}
	}
	
	$show_categories = mysqli_query($connection, "SELECT categories.category_id, categories.name, parents.name AS parent_id FROM categories LEFT JOIN categories AS parents ON parents.category_id = categories.parent_id ORDER BY parent_id");

	echo '<table class="table table-striped table-bordered table-hover table-condensed">';
	echo '<th>Όνομα κατηγορίας</th><th>Ανήκει στην κατηγορία</th><th>Ενέργεια</th>';
	
	while ($row = mysqli_fetch_array($show_categories)) {
		echo '<tr>';
		echo '<td>' . $row['name'] . '</td>';
		echo '<td>' . $row['parent_id'] . '</td>';
			
		echo '<td style="width:20%"><form method="post" action="">';
		echo '<button type="submit" name="delete" id="linkButton" value="'.$row['category_id'].'"><span class="glyphicon glyphicon-trash" style="color:red"></span>Διαγραφή</button>';
		echo '</form></td></tr>';
	}
	echo '</table>';
	$categories = mysqli_query($connection, "SELECT category_id, name FROM categories ORDER BY name");
	echo '<br><form method="post" action="" align="center">
	      <input type="text" name="category" value="" placeholder="Νέα κατηγορία">
		  <select name="parents">
		  <option value="0"></option>';
	while ($row = mysqli_fetch_array($categories)) {
		echo '<option value="'.$row['category_id'].'">' . $row['name'] . '</option>';
	}
	echo '</select>
		  <button class="btn btn-primary">
          <span class="glyphicon glyphicon-plus-sign"></span> Προσθήκη</button>
		  </form>';
	
	mysqli_close($connection);
}
/*
function category_tree() {
	include '../db_connection.php';
	$sql = array('','','','');
	$rs = array('','','','');
	$sql[0]=mysqli_query($connection, "SELECT category_id, parent_id, name FROM categories where parent_id = 0");
	$select='<ul name="select">';
	while($rs[0]=mysqli_fetch_array($sql[0])){
		  $select.='<li value="">'.$rs[0]['name'].'</li><ul>';
		  $sql[1]=mysqli_query($connection, "SELECT category_id, parent_id, name FROM categories where parent_id =" . $rs[0]['category_id']);
		  while($rs[1]=mysqli_fetch_array($sql[1])){
			  $select.='<li value="">'.$rs[1]['name'].'</li><ul>';
			  $sql[2] = mysqli_query($connection, "SELECT category_id, parent_id, name FROM categories where parent_id =" . $rs[1]['category_id']);
			  while($rs[2]=mysqli_fetch_array($sql[2])) {
				$select.='<li value="">'.$rs[2]['name'].'</li><ul>';
				$sql[3] = mysqli_query($connection, "SELECT category_id, parent_id, name FROM categories where parent_id =" . $rs[2]['category_id']);
				while($rs[3]=mysqli_fetch_array($sql[3])) {
					$select.='<li value="">'.$rs[3]['name'].'</li>';
				}
				$select.='</ul>';
			  }
			$select.='</ul>';
		  }
		  $select.='</ul>';
	}
	$select.='</ul>';
	echo '<div class="tree" style="font-size=50px;">';
	echo $select;
	echo '<div>';
	
	mysqli_close($connection);
}*/
?>

</body>
</html>