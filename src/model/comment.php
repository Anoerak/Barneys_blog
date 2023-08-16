<?php

require_once "./src/model/dbConnect.php";

class Comment extends dbConnect
{
	public int $id;
	public int $post_id;
	public int $user_id;
	public string $author_username;
	public string $content;
	public $content_status;
	public string $created_at;
	public $updated_at;
	public string $validation_status;

	public function __construct($id = null, $post_id = null, $user_id = null, $author_username = null, $content = null, $content_status = null, $created_at = null, $updated_at = null, $validation_status = null)
	{
		$this->id = $id;
		$this->post_id = $post_id;
		$this->user_id = $user_id;
		$this->author_username = $author_username;
		$this->content = $content;
		$this->content_status = $content_status;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
		$this->validation_status = $validation_status;
	}

	/* #Region getComments */
	public static function getComments($post_id)
	{
		$comments = array();
		// We get all the comments from the database
		$sql = parent::executeRequest("SELECT * FROM comment WHERE post_id = ? ORDER BY created_at ASC", array($post_id));
		// We create an array of Comment objects
		while ($comment = $sql->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment($comment['id'], $comment['post_id'], $comment['user_id'], '', $comment['content'], '', $comment['created_at'], $comment['updated_at'], $comment['validation_status']);
		}
		// We add the author's username to each comment
		foreach ($comments as $comment) {
			$author = User::getUser($comment->user_id);
			$comment->author_username = $author->username;
			// We replace the date value with the format we want
			$comment->created_at = Tools::formatDate($comment->created_at);
			if ($comment->updated_at !== null) {
				$comment->updated_at = Tools::formatDate($comment->updated_at);
			}
			if ($comment->validation_status === 'false') {
				$comment->content_status = '<font color="red">
					Attention, blog-o-sphere!<br>
					Unfortunately, this comment has been removed for not following the rules of my legendary blog.<br>
					So, if you want your comment to be seen by the world, make sure you follow these simple rules.<br>
					And if you don\'t, well, let\'s just say you\'ll be getting a visit from the comment-blocking hammer.<br>
					Suit up!</font>';
			} elseif ($comment->validation_status === 'pending') {
				// We replace the comment's content with a message if it's pending
				$comment->content_status = '<font color="blue">
					<em><b>Blog-o-sphere, gather around!</b><br>
					There\'s a new comment on my latest post that\'s waiting for my legendary approval. And let me tell you, I take this responsibility very seriously.<br>
					So, if you\'re waiting for your comment to be published, don\'t worry, it\'s in good hands. And if it doesn\'t make the cut, well, let\'s just say it\'s not you, it\'s me.<br>
					Suit up!</em></font>
					';
			}
		}
		return $comments;
	}
	/* #EndRegion */


	/* #Region Add a comment */
	public static function addComment($post_id)
	{
		if (empty($_POST['comment'])) {
			throw new Exception('Your comment is empty, come on, you can do better.', 400);
		} else {
			session_start();
			$sql = parent::executeRequest("INSERT INTO comment (post_id, user_id, content) VALUES (?,?,?)", array($post_id, $_SESSION['user_id'], $_POST['comment']));
			if (!$sql) {
				throw new Exception('Something went wrong, please try again.', 500);
			} else {
				header('Refresh: 3; URL=./index.php?page=post&action=get&option=view&id=' . $post_id);
				throw new Exception('Congrats folk, your awesome comment is now waiting for my legendary approval!', 200);
			}
		}
	}
	/* #EndRegion */


	/* #Region Update a comment */
	public static function updateComment($id)
	{
		if (empty($_POST['comment'])) {
			throw new Exception('Your comment is empty, come on, you can do better.', 400);
		} else {
			// We update the comment
			$sql = parent::executeRequest("UPDATE comment SET content = (?), validation_status = 'pending'  WHERE id = ?", array($_POST['comment'], $id));
			if (!$sql) {
				throw new Exception('Something went wrong, please try again.', 500);
			} else {
				header('Refresh: 3; URL=./index.php?page=post&action=get&option=view&id=' . $_GET['post_id']);
				throw new Exception('Congrats folk, your update is now waiting for my legendary approval!', 200);
			}
		}
	}
	/* #EndRegion */


	/* #Region Delete a comment */
	public static function deleteComment($id)
	{
		// We delete the comment
		$sql = parent::executeRequest("DELETE FROM comment WHERE id = ?", array($id));
		if (!$sql) {
			throw new Exception('Something went wrong, please try again.', 500);
		} else {
			header('Refresh: 3; URL=./index.php?page=post&action=get&option=view&id=' . $_GET['post_id']);
			throw new Exception('This comment is now deleted and can\'t be publish anymore!', 200);
		}
	}
	/* #EndRegion */


	/* #Region Refuse a comment */
	public static function refuseComment($id)
	{
		$status = 'false';
		// We update the comment validation_status
		$sql = parent::executeRequest("UPDATE comment SET validation_status = (?) WHERE id = ?", array($status, $id));
		if (!$sql) {
			throw new Exception('Something went wrong, please try again.', 500);
		} else {
			header('Refresh: 3; URL=./index.php?page=post&action=get&option=view&id=' . $_GET['post_id']);
			throw new Exception('This comment is now unavailable for all users!', 200);
		}
	}
	/* #EndRegion */


	/* #Region Validate a comment */
	public static function validateComment($id)
	{
		$status = 'true';
		// We update the comment validation_status
		$sql = parent::executeRequest("UPDATE comment SET validation_status = (?) WHERE id =?", array($status, $id));
		if (!$sql) {
			throw new Exception('Something went wrong, please try again.', 500);
		} else {
			header('Refresh: 3; URL=./index.php?page=post&action=get&option=view&id=' . $_GET['post_id']);
			throw new Exception('This comment is now available for all users', 200);
		}
	}
	/* #EndRegion */
}


// Here\'s a reminder of the rules:<br>
// 1. Keep it clean, folks. No inappropriate language or content.<br>
// 2. Let\'s keep it respectful. No hate speech or personal attacks will be tolerated.<br>
// 3. No spamming. Keep your comments relevant to the topic at hand.<br><br>

// I want to make sure that every comment on my blog is up to my high standards of awesomeness and legendarity. So, before I give it the green light, I\'ll be taking a good look at it to make sure it follows my blog`\'s rules.<br><br>