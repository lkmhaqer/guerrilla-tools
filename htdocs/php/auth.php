<?php

// before anything else...
session_start();

// everything we need to build our page, and handle any updates.
//
// db.php		includes basic config settings.
// func.php		where most functions live, provide most lifting.
// director.php		somewhat of a big catch all for the main variable used, $_GET['a'].
// google2factor.php	to support 2fa.

include('db.php');
include('func.php');
include('director.php');
include('google2factor.php');



// Checking if the user should be here. We Authenticate ever page below.

if (!$_SESSION['authenticated'] && !($_POST['username'] && $_POST['password']) && !$_SESSION['second-stage'])
	buildLoginPage('');

if ($_POST['username'] && $_POST['password']) {

	try {

		$query = $dbh->prepare("SELECT id, username, password, privilege, two_factor_key FROM user WHERE username = :username");
		$query->execute(array("username" => $_POST['username']));
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {

		buildLoginPage('DB Error');

	}

	if (count($rows) > 0) {

		$row = array_shift($rows);

		if (password_verify($_POST['password'], $row['password'])) {

			if ($row['privilege'] > 0) {

				if ($row['two_factor_key'] != '') {

					$_SESSION['second-stage'] = $row['id'];
					include('two-factor.inc.php');
					exit;

				} else {

					$_SESSION['authenticated'] = 'true';

				}

			} else {

				buildLoginPage('Your user is inactive.');

			}

		} elseif ($row['password'] == '') {

			try {

				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$query = $dbh->prepare("UPDATE user SET password = :password WHERE id = :id");
				$query->execute(array("password" => $password, "id" => $row['id']));

			} catch (PDOException $e ) {

				buildLoginPage('DB Error');

			}

		} else {

			buildLoginPage('Bad username or password.'); // Password doesn't match user provided.

		}

	} else {

		buildLoginPage('Bad username or password.'); // No username found in DB.

	}

} elseif ($_POST['otp'] && $_SESSION['second-stage']) {

	$id = $_SESSION['second-stage'];
	unset($_SESSION['second-stage']);

	try {

                $query = $dbh->prepare("SELECT two_factor_key FROM user WHERE id = :id");
                $query->execute(array("id" => $id));
                $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

                buildLoginPage('DB Error');

        }

	if (count($rows) <= 0)
		buildLoginPage('Bad username or password.'); // No DB rows returned for userid placed in session variable from first stage of authentication.

	$row = array_shift($rows);

	if (Google2FA::verify_key($row['two_factor_key'], $_POST['otp']))
		$_SESSION['authenticated'] = 'true';
	else
		buildLoginPage('Bad OTP.');


}

?>
