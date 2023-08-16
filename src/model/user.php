<?php

require_once './src/model/dbConnect.php';
require_once './src/lib/tools/Tools.php';

class User extends dbConnect
{
	public int $id;
	public $username;
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $birthday;
	public $profile_picture;
	public $created_at;
	public $updated_at;

	public function __construct($id = null, $username = null, $firstname = null, $lastname = null, $email = null, $password = null, $birthday = null, $profile_picture = null, $created_at = null, $updated_at = null)
	{
		$this->id = $id;
		$this->username = $username;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->birthday = $birthday;
		$this->profile_picture = $profile_picture;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
	}

	/* #Region getUser */
	public static function getUser(int $id)
	{
		$sql = parent::executeRequest("SELECT * FROM user WHERE id = ?", array($id));
		$user = $sql->fetch();
		return new User($user['id'], $user['username'], $user['firstname'], $user['lastname'], $user['email'], '', Tools::formatDateForBirthday($user['birthday']), $user['profile_picture'], $user['created_at'], $user['updated_at']);
	}
	/* #EndRegion */


	/* #Region getUserPrivilege */
	public static function getUserPrivileges(int $id)
	{
		$sql = parent::executeRequest("SELECT privilege FROM privilege WHERE user_id = ?", array($id));
		$user = $sql->fetch();
		return $user;
	}
	/* #EndRegion */


	/* #Region getUsers */
	public static function getUsers()
	{
		$users = array();
		$sql = parent::executeRequest("SELECT * FROM user");
		while ($user = $sql->fetch()) {
			$users[] = new User($user['id'], $user['username'], $user['email'], $user['password'], $user['created_at'], $user['updated_at']);
		}
		return $users;
	}
	/* #EndRegion */


	/* #Region createUser */
	public static function createUser()
	{
		// We get the value from $_POST and we check if they are not empty
		$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
		$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
		$password = !empty($_POST['password']) ? trim($_POST['password']) : null;
		$passwordCheck = !empty($_POST['passwordCheck']) ? trim($_POST['passwordCheck']) : null;


		// Check if the username is already taken
		$sql = parent::executeRequest("SELECT * FROM user WHERE username = ?", array($username));
		if ($sql->rowCount() > 0) {
			throw new Exception('This username is already taken.');
		}

		// Check if the email is already taken
		$sql = parent::executeRequest("SELECT * FROM user WHERE email = ?", array($email));
		if ($sql->rowCount() > 0) {
			throw new Exception('This email is already taken.');
		}

		// Check is passwords match
		if ($password !== $passwordCheck) {
			throw new Exception('The passwords do not match.');
		}

		// Check if the password is valid
		if (!Tools::checkPassword($password, $passwordCheck)) {
			throw new Exception('The password is not valid. Must be least 8 characters long, contains at least one uppercase letter, one lowercase letter, one number and one special character');
		}

		// Hash the password & the email
		$password = password_hash($password, PASSWORD_DEFAULT);

		// Sanitize the email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		// We create the user in user table
		$sql = parent::executeRequest("INSERT INTO user (username, email) VALUES (?, ?)", array($username, $email));

		// We get the id of the user
		$id = parent::getLastInsertedId();

		// Create the user in credentials table
		$sql = parent::executeRequest("INSERT INTO credentials (username, password, user_id) VALUES (?, ?, ?)", array($username, $password, $id));

		// Create the user in the privilege table
		$sql = parent::executeRequest("INSERT INTO privilege (user_id) VALUES (?)", array($id));

		// We check if the user has been created
		if ($sql) {
			header('Refresh: 3; URL=./index.php?page=login');
			echo 'Your account has been created. You will be redirected to the login page in 3 seconds.';
		} else {
			throw new Exception('An error occurred while creating your account.');
		}
	}
	/* #EndRegion */


	/* #Region updateUser */
	public static function updateUser()
	{
		$values = array(
			'id' => null,
			'username' => null,
			'firstname' => null,
			'lastname' => null,
			'email' => null,
			'birthday' => null,
			'profile_picture' => null,
			'currentPassword' => null,
			'newPassword' => null,
			'passwordCheck' => null
		);

		/* #Region We get the value from $_POST, we check if they are not empty and add them to the array */
		// If the value is empty, we fetch the value from the $_SESSION array
		foreach ($values as $key => $value) {
			if ($key !== 'passwordCheck' && $key !== 'newPassword' && $key !== 'currentPassword') {
				$values[$key] = !empty($_POST[$key]) ? trim($_POST[$key]) : $_SESSION[$key];
			}
		}
		// We add the values for oldPassword, currentPassword and newPassword
		$values['currentPassword'] = !empty($_POST['currentPassword']) ? trim($_POST['currentPassword']) : null;
		$values['newPassword'] = !empty($_POST['newPassword']) ? trim($_POST['newPassword']) : null;
		$values['passwordCheck'] = !empty($_POST['passwordCheck']) ? trim($_POST['passwordCheck']) : null;
		/* #EndRegion */

		/* #Region We check if the username is already taken */
		if ($values['username'] !== $_SESSION['username']) {
			$sql = parent::executeRequest("SELECT * FROM user WHERE username = ?", array($values['username']));
			if ($sql->rowCount() > 0) {
				throw new Exception('This username is already taken.');
			}
		}
		/* #EndRegion */

		/* #Region We check if the email is already taken */
		if ($values['email'] !== $_SESSION['email']) {
			$sql = parent::executeRequest("SELECT * FROM user WHERE email = ?", array($values['email']));
			if ($sql->rowCount() > 0) {
				throw new Exception('This email is already taken.');
			}
		}
		/* #EndRegion */

		/* #Region We check if the birthday is valid */
		if ($values['birthday'] !== $_SESSION['birthday']) {
			if (!Tools::checkBirthday($values['birthday'])) {
				throw new Exception('The birthday is not valid.');
			}
			// We replace the birthday format for the database(datetime)
			$values['birthday'] = date('Y-m-d', strtotime($values['birthday']));
		} else {
			$values['birthday'] = date('Y-m-d', strtotime($values['birthday']));
		}
		/* #EndRegion */

		/* #Region We check if the profile picture is valid */
		if (!empty($_FILES['profile_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('profile_picture');
			if (!$checkPicture) {
				throw new Exception();
			} else {
				$values['profile_picture'] = $checkPicture;
			}
		}
		/* #EndRegion */

		/* #Region We check if the old password matches the hashed one in credentials table, is different from the new password and is valid */
		// We get the password from the credentials table
		if (!empty($values['currentPassword']) && !empty($values['newPassword']) && !empty($values['passwordCheck'])) {
			$sql = parent::executeRequest("SELECT password FROM credentials WHERE user_id = ?", array($values['id']));
			$hashedPassword = $sql->fetch(PDO::FETCH_ASSOC);
			// We check if the password matches the hashed one
			if (!password_verify($values['currentPassword'], $hashedPassword['password'])) {
				throw new Exception('The old password is not valid.');
			}
			// We check if the password is valid
			if (!Tools::checkPassword($values['newPassword'], $values['passwordCheck'])) {
				throw new Exception('The password is not valid. Must be least 8 characters long, contains at least one uppercase letter, one lowercase letter, one number and one special character');
			}
			// We check if the password matches the password check
			if ($values['newPassword'] !== $values['passwordCheck']) {
				throw new Exception('The passwords do not match.');
			}
			// We hash the password
			$values['newPassword'] = password_hash($values['newPassword'], PASSWORD_DEFAULT);
		}
		/* #EndRegion */

		/* #Region We sanitize the email */
		if ($values['email'] !== $_SESSION['email']) {
			$values['email'] = filter_var($values['email'], FILTER_SANITIZE_EMAIL);
		}
		/* #EndRegion */

		/* #Region We update the user in the user table */
		foreach ($values as $key => $value) {
			if ($key !== 'id' && $key !== 'passwordCheck' && $key !== 'currentPassword' && $key !== 'newPassword') {
				$sql = parent::executeRequest("UPDATE user SET $key = ? WHERE id = ?", array($value, $values['id']));

				if (!$sql) {
					throw new Exception('An error occurred while updating your account.');
				}
			}
		}
		/* #EndRegion */

		/* #Region We update the user in the credentials table */
		if (!empty($values['newPassword'])) {
			$sql = parent::executeRequest("UPDATE credentials SET password = ? WHERE user_id = ?", array($values['newPassword'], $values['id']));
			if (!$sql) {
				throw new Exception('An error occurred while updating your account.');
			}
		}
		/* #EndRegion */

		/* #Region We update the user in the profile picture */
		if (!empty($values['profile_picture'])) {
			// We update the $_SESSION array
			UserConnection::updateSession($values['id']);
		}
		/* #EndRegion */

		/* #Region We check if the user has been updated */
		if ($sql) {
			header('Refresh: 3; URL=./index.php?page=userProfile&action=get&option=user&id=' . $values['id'] . '');
			echo 'Your account has been updated. You will be redirected to the profile page in 3 seconds.';
		} else {
			throw new Exception('An error occurred while updating your account.');
		}
		/* #EndRegion */
	}
	/* #EndRegion */


	/* #Region deleteUser */
	public static function deleteUser($id)
	{
		$sql = parent::executeRequest("DELETE FROM user WHERE id = ?", array($id));

		if ($sql) {
			session_destroy();
			header('Refresh: 3; URL=./index.php');
			echo 'The user has been deleted. You will be redirected to the home page in 3 seconds.';
		} else {
			throw new Exception('An error occurred while deleting the user.');
		}
	}
	/* #EndRegion */
}