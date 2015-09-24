<?php

function buildLoginPage($errorText) {

	if ($errorText) {

		$alert = buildAlert($errorText, 'danger');

	}

	include('login.inc.php');

	exit();

}

function buildAlert($text, $severity) {

	return "<div class=\"alert alert-$severity\"  role=\"alert\"><strong>" . ucwords($severity) . ": </strong> $text</div>\n";

}

function buildTable($tableName) {

	global $dbh;

	$tableHTML = "<table class=\"table table-hover table-condensed\"><thead>";

	switch ($tableName) {

		case 'neighbor':

			$query = $dbh->prepare("SELECT neighbor.id, aut_num.asn, aut_num.name as peer_name, router.hostname, peer_ip, soft_inbound FROM neighbor
						LEFT JOIN aut_num ON neighbor.aut_num_id = aut_num.id LEFT JOIN router ON neighbor.router_id = router.id");
			break;

		default:

			$query = $dbh->prepare("SELECT * FROM " . $tableName);

	}

	$query->execute(array());
	$rows = $query->fetchAll(PDO::FETCH_ASSOC);
	$count = 0;

	foreach ($rows as $row) {

		if ($count == 0) {
			$tableHTML .= "<tr>";

			foreach (array_keys($row) as $value) {

				$tableHTML .= "<th>$value</th>";

			}

			$tableHTML .= "<th>&nbsp;</th></tr></thead><tbody>";

		}

		$tableHTML .= "<tr>";
		$id;

		foreach ($row as $key => $value) {

			if ($key == 'id')
				$id = $value;

			if ($key == 'router_id' || $key == 'peer_ip')
				$value = long2ip($value);

			$tableHTML .= "<td>$value</td>";

		}

		$tableHTML .= "<td><a href=\"?a=delete_$tableName&id=$id\" class=\"btn btn-danger btn-xs\">Delete</a></td></tr>";
		$count++;

	}

	$tableHTML .= "</tbody></table>\n";

        if (count($rows) == 0)
                $tableHTML = buildAlert("Nothing to show", "warning");
	echo($tableHTML);

}

function checkActive($page) {

	global $currentPage;

	if ($currentPage == $page)
		echo(" class=\"active\"");

}

function buildCount($tableName) {

	global $dbh;

	$query = $dbh->prepare("SELECT count(id) FROM " . $tableName);
	$query->execute(array());
	$rows = $query->fetchAll(PDO::FETCH_ASSOC);
	$row = array_shift($rows);
	echo($row['count(id)']);

}

function buildOptions($tableName, $columnName, $helpColumnName = NULL) {

	global $dbh;

	try {

		if ($helpColumnName)
			$query = $dbh->prepare("SELECT id, " . $columnName . ", " . $helpColumnName . " FROM " . $tableName);
		else
			$query = $dbh->prepare("SELECT id, " . $columnName . " FROM " . $tableName);

		$query->execute(array());
        	$rows = $query->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {

	}

	$optionHTML = "<option value=\"-1\">$columnName</option>";

	foreach ($rows as $row) {

		$helpText;

		if ($helpColumnName)
			$helpText = " [" . $row[$helpColumnName] . "]";

		$optionHTML .= "<option value=\"" . $row['id'] . "\">" . $row[$columnName] . "$helpText</option>";

	}

	echo($optionHTML);

}

?>
