<?php

// default page is overview
$currentPage = "overview";
$alertText;

switch ($_GET['a']) {

	case 'logout':

		unset($_SESSION);
		session_destroy();
		break;

	case 'routers':

		$currentPage = "routers";
		break;

	case 'add_router':

		$currentPage = "routers";
		$errorText;

		if ($_POST) {

			if ($_POST['hostname'] == "")
				$errorText .= "<li>No hostname.</li>";

			if ($_POST['router-id'] == "")
				$errorText .= "<li>No router-id.</li>";
                        elseif (filter_var($_POST['router-id'], FILTER_VALIDATE_IP) === false)
				$errorText .= "<li>Invalid router-id.</li>";

			if ($_POST['network-os'] == "")
				$errorText .= "<li>No network os.</li>";

			if ($errorText == '') {

				$ibgp = 0;

				if (isset($_POST['ibgp']))
					$ibgp = 1;

				try {

					$query = $dbh->prepare("INSERT INTO router (hostname, router_id, ibgp, network_os) VALUES (:hostname, INET_ATON(:router_id), :ibgp, :network-os)");
					$query->execute(array("hostname" => $_POST['hostname'], "router_id" => $_POST['router-id'], "ibgp" => $ibgp, "network-os" => $_POST['network-os']));
					$alertText = buildAlert("<ul><li>Router Added!</li></ul>", "success");

				} catch (PDOException $e) {

					$alertText = buildAlert("<ul>$e</ul>", "danger");

				}

			} else {

				$alertText = buildAlert("<ul>$errorText</ul>", "danger");

			}

		}

		break;

	case 'delete_router':

		$currentPage = "routers";

		try {

			$query = $dbh->prepare("DELETE FROM router WHERE id = :id LIMIT 1");
			$query->execute(array("id" => $_GET['id']));
			$alertText = buildAlert("Router Deleted!", "success");

		} catch (PDOException $e) {

			$alertText = buildAlert("<ul>$e</ul>", "danger");

		}

		break;

	case 'neighbors':

		$currentPage = "neighbors";
		break;

        case 'add_neighbor':

                $currentPage = "neighbors";

		if ($_POST) {

                        if ($_POST['asn'] == "-1")
                                $errorText .= "<li>No ASN.</li>";

                        if ($_POST['router'] == "-1")
                                $errorText .= "<li>No hostname.</li>";

                        if ($_POST['peer-ip'] == "")
                                $errorText .= "<li>No peer IP.</li>";
			elseif (filter_var($_POST['peer-ip'], FILTER_VALIDATE_IP) === false)
				$errorText .= "<li>Invalid peer IP.</li>";

                        if ($errorText == '') {

				$softInbound = 0;

                                if (isset($_POST['soft-inbound']))
                                        $softInbound = 1;

                                try {

                                        $query = $dbh->prepare("INSERT INTO neighbor (aut_num_id, router_id, peer_ip, soft_inbound) VALUES (:aut_num_id, :router_id, INET_ATON(:peer_ip), :soft_inbound)");
                                        $query->execute(array("aut_num_id" => $_POST['asn'], "router_id" => $_POST['router'], "peer_ip" => $_POST['peer-ip'], "soft_inbound" => $softInbound));
                                        $alertText = buildAlert("<ul><li>Neighbor Added!</li></ul>", "success");

                                } catch (PDOException $e) {

                                        $alertText = buildAlert("<ul>$e</ul>", "danger");

                                }

                        } else {

                                $alertText = buildAlert("<ul>$errorText</ul>", "danger");

                        }

                }

                break;

	case 'delete_neighbor':

                $currentPage = "neighbors";

                try {

                        $query = $dbh->prepare("DELETE FROM neighbor WHERE id = :id LIMIT 1");
                        $query->execute(array("id" => $_GET['id']));
                        $alertText = buildAlert("Neighbor Deleted!", "success");

                } catch (PDOException $e) {

                        $alertText = buildAlert("<ul>$e</ul>", "danger");

                }

                break;

	case 'aut-num':

		$currentPage = "aut-num";
		break;

	case 'add_aut-num':

		$currentPage = "aut-num";
		$errorText;

		if ($_POST) {

                        if ($_POST['asn'] == "")
                                $errorText .= "<li>No ASN.</li>";
			elseif (!is_numeric($_POST['asn']))
				$errorText .= "<li>Invalid ASN.</li>";

                        if ($_POST['name'] == "")
                                $errorText .= "<li>No name.</li>";

			if ($_POST['contact'] == "")
				$errorText .= "<li>No contact.</li>";

			if ($errorText == '') {

                                try {

                                        $query = $dbh->prepare("INSERT INTO aut_num (asn, name, contact) VALUES (:asn, :name, :contact)");
                                        $query->execute(array("asn" => $_POST['asn'], "name" => $_POST['name'], "contact" => $_POST['contact']));
                                        $alertText = buildAlert("<ul><li>ASN Added!</li></ul>", "success");

                                } catch (PDOException $e) {

                                        $alertText = buildAlert("<ul>$e</ul>", "danger");

                                }

                        } else {

                                $alertText = buildAlert("<ul>$errorText</ul>", "danger");

                        }

		}

		break;

        case 'delete_aut-num':

                $currentPage = "aut-num";

                try {

                        $query = $dbh->prepare("DELETE FROM aut-num WHERE id = :id LIMIT 1");
                        $query->execute(array("id" => $_GET['id']));
                        $alertText = buildAlert("aut-num Deleted!", "success");

                } catch (PDOException $e) {

                        $alertText = buildAlert("<ul>$e</ul>", "danger");

                }

                break;

}

?>
