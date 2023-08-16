<?php

require_once './src/model/dbConnect.php';
require_once './src/lib/tools/Tools.php';


class UserConnection extends dbConnect
{
	public int $id;
	public string $username;
	public string $password;

	public function __construct($id = null, $username = null, $password = null)
	{
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
	}

	/* #Region We Update the $_SESSION variables */
	static public function UpdateSession($user_id)
	{
		// We get the user's informations
		$userInfos = User::getUser($user_id);
		$userPrivileges = User::getUserPrivileges($user_id);
		$userNewsletter = Newsletter::getStatus($userInfos->email);
		// We check if the user exists
		if (!empty($userInfos)) {
			// We open a session and we create the $_SESSION variables
			if (!isset($_SESSION)) {
				session_start();
			}
			$_SESSION['logged_user'] = true;
			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = $userInfos->username;
			$_SESSION['firstname'] = $userInfos->firstname;
			$_SESSION['lastname'] = $userInfos->lastname;
			$_SESSION['email'] = $userInfos->email;
			$_SESSION['birthday'] = $userInfos->birthday;
			$_SESSION['profile_picture'] = $userInfos->profile_picture;
			$_SESSION['privileges'] = $userPrivileges;
			$_SESSION['newsletter'] = $userNewsletter;
		} else {
			// If the user does not exist, we throw an exception
			throw new Exception('This user does not exist.');
		}
	}
	/* #EndRegion */


	/* #Region We open a session and we create the $_SESSION variables */
	static public function logIn()
	{
		// We get the value from $_POST and we check if they are not empty
		$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
		$password = !empty($_POST['password']) ? trim($_POST['password']) : null;

		// Check if the username is already taken
		$sql = parent::executeRequest("SELECT * FROM credentials WHERE username = ?", array($username));
		if ($sql->rowCount() > 0) {
			$user = $sql->fetch();
			// Check if the password is correct
			if (password_verify($password, $user['password'])) {
				self::UpdateSession($user['user_id']);
				// We redirect the user to the home page after 3 seconds
				header('Refresh: 3; URL=index.php');
				// We throw a Throwable to display a message
				throw new Exception('You are now connected.', 200);
			} else {
				// If the password is not correct, we throw an exception
				throw new Exception('Wrong password.', 401);
			}
		} else {
			// If the username does not exist, we throw an exception
			throw new Exception('This username does not exist.', 404);
		}
	}
	/* #EndRegion */


	/* #Region We destroy the session and we redirect the user to the home page */
	static public function logOut()
	{
		session_start();
		$_SESSION = array();
		session_destroy();
		// We check if the user is connected
		if (isset($_SESSION['logged_user'])) {
			// If the user is connected, we throw an exception
			throw new Exception('You are still connected.', 401);
		} else {
			// We redirect the user to the home page after 3 seconds
			header('Refresh: 3; URL=index.php');
			// If the user is not connected, we throw a message to display
			throw new Exception('You are now disconnected.', 200);
		}
	}
	/* #EndRegion */
}