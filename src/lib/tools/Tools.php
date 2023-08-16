<?php

require_once "./src/model/dbConnect.php";

class Tools
{
	/* #Region We manage the errors and we display them in a modal */
	static public function error($msgError, $code)
	{
		if ($code >= 400 && $code <= 500) {
			$view = new View('error/error', 'Error');
			$view->render(array('msgError' => $msgError));
		} else {
			$view = new View('loading/loading', 'Message');
			$view->render(array('datas' => $msgError));
		}
	}
	/* #EndRegion */


	/* #Region We format the date to display it in a more readable way */
	static public function formatDate($dateToFormat)
	{
		$date = new DateTime($dateToFormat ?? '');
		return $date->format('d/m/Y \a\t H:i');
	}
	/* #EndRegion */


	/* #Region We format the date for the birthday input */
	static public function formatDateForBirthday($dateToFormat)
	{
		if (!empty($dateToFormat)) {
			$date = new DateTime($dateToFormat);
			return $date->format('Y-m-d');
		}
	}
	/* #EndRegion */


	/* #Region We get the picture from the addPost form and we upload it to the server */
	static public function uploadPicture($pictureOrigin)
	{
		// We get the picture's name
		$pictureName = $_FILES[$pictureOrigin]['name'];
		// We get the picture's extension
		$pictureExtension = pathinfo($pictureName, PATHINFO_EXTENSION);
		// We get the picture's size
		$pictureSize = $_FILES[$pictureOrigin]['size'];
		// We get the picture's temporary name
		$pictureTmpName = $_FILES[$pictureOrigin]['tmp_name'];
		// We get the picture's error
		$pictureError = $_FILES[$pictureOrigin]['error'];
		// We get the picture's allowed extensions
		$pictureAllowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
		// We get the picture's allowed MIMEtypes
		$pictureAllowedMimeTypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
		// We get the picture's mime type
		$pictureMimeType = $_FILES[$pictureOrigin]['type'];
		// We check if the picture's extension is allowed
		if (in_array($pictureExtension, $pictureAllowedExtensions)) {
			// We check if the MIME type is allowed
			if (in_array($pictureMimeType, $pictureAllowedMimeTypes)) {
				// We check if there is no error
				if ($pictureError === 0) {
					// We check if the picture's size is less than 2MB
					if ($pictureSize < 2000000) {
						// We create a new name for the picture
						$pictureNewName = uniqid('', true) . "." . $pictureExtension;
						// We set the picture's destination
						$pictureDestination = "./public/img/" . $pictureOrigin . "/" . $pictureNewName;
						// For Production :
						// 	$pictureDestination = "public/img/" . $pictureOrigin . "/" . $pictureNewName;
						// We upload the picture to the server
						move_uploaded_file($pictureTmpName, $pictureDestination);
						// We return the picture destination
						return $pictureDestination;
					} else {
						// We return an error message
						throw new \Exception("Your picture is too big. Max size is 2MB.");
					}
				} else {
					// We return an error message
					throw new \Exception("An error occurred while uploading the picture.");
				}
			} else {
				throw new \Exception("MIME type not allowed");
			}
		} else {
			// We return an error message
			throw new \Exception("Your picture should have one of this extensions: " . implode(", ", $pictureAllowedMimeTypes));
		}
	}
	/* #EndRegion */


	/* #Region We Check if the password is valid */
	static public function checkPassword($password)
	{
		// We check if the password is at least 8 characters long, contains at least one uppercase letter, one lowercase letter, one number and one special character
		if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $password)) {
			// We return true
			return true;
		} else {
			// We return false
			return false;
		}
	}
	/* #EndRegion */


	/* #Region We check if the birthday is valid */
	static public function checkBirthday($birthday)
	{
		// We check if the birthday is valid, in the format Y-m-d, before today - 18 years and after today - 100 years
		if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $birthday) && $birthday < date('Y-m-d', strtotime('-18 years')) && $birthday > date('Y-m-d', strtotime('-100 years'))) {
			// We return true
			return true;
		} else {
			// We return false
			return false;
		}
	}
	/* #EndRegion */


	/* #Region We check if the email is valid */
	static public function checkEmail($email)
	{
		// We check if the email is valid
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// We return true
			return true;
		} else {
			// We return false
			return false;
		}
	}
	/* #EndRegion */


	/* #Region A contact form which send an email to the blogmaster and the user */
	static public function contactForm()
	{
		// We get the blogmaster's email
		$blogmasterEmail = "seb@iamseb.dev";

		// We get the information from the contact form
		$contactName = $_POST['contactName'];
		$contactEmail = $_POST['contactEmail'];
		$contactSubject = $_POST['contactSubject'];
		$contactMessage = $_POST['contactMessage'];

		// We check if the email is valid
		if (self::checkEmail($contactEmail)) {
			// We check if the name is not empty
			if (!empty($contactName)) {
				// We check if the subject is not empty
				if (!empty($contactSubject)) {
					// We check if the message is not empty
					if (!empty($contactMessage)) {
						// We set the headers
						// Production
						// $headers = "From: daemon@iamseb.dev";
						// Development
						$headers = "From: daemon@iamseb.dev \r \n Reply-To: " . $contactEmail . " \r \n X-Mailer: PHP/" . phpversion();
						// We set the message
						$message = "You received a message from " . $contactName . " with the email address " . $contactEmail . ".\n\n" . $contactMessage;
						// We send the email to the blogmaster
						mail($blogmasterEmail, $contactSubject, $message, $headers);
						// We send the email to the user
						mail($contactEmail, "Your message has been sent", "Your message has been sent. We will answer you as soon as possible.", $headers);
						// We return a success message
						header('Refresh: 5; URL=/index.php');
						throw new \Exception("Your message has been sent. We will answer you as soon as possible.", 200);
					} else {
						// We return an error message
						throw new \Exception("Please enter a message.", 400);
					}
				} else {
					// We return an error message
					throw new \Exception("Please enter a subject.", 400);
				}
			} else {
				// We return an error message
				throw new \Exception("Please enter a name.", 400);
			}
		} else {
			// We return an error message
			throw new \Exception("Please enter a valid email address.", 400);
		}
	}
	/* #EndRegion */


	/* #Region The visitor download the resume */
	static public function downloadResume()
	{
		// We get the resume's path
		$resumePath = "public/files/bro-lific_resume.pdf";
		// We get the resume's name
		$resumeName = "bro-lific_resume.pdf";
		// We get the resume's size
		$resumeSize = filesize($resumePath);
		// We set the headers
		header("Content-Length: " . $resumeSize);
		header("Content-Disposition: attachment; filename=" . $resumeName);
		// We read the file
		readfile($resumePath);
	}
	/* #EndRegion */
}
