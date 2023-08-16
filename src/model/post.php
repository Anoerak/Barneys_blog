<?php

require_once "./src/model/dbConnect.php";
require_once "./src/lib/tools/Tools.php";

class Post extends dbConnect
{
	public int $id;
	public int $author_id;
	public string $author_username;
	public string $category;
	public string $picture;
	public string $title;
	public string $content;
	public string $created_at;
	public $comments;
	public $updated_at;

	public function __construct($id = null, $author_id = null, $author_username = null, $category = null, $picture = null, $title = null, $content = null, $created_at = null, $comments = null, $updated_at = null)
	{
		$this->id = $id;
		$this->author_id = $author_id;
		$this->author_username = $author_username;
		$this->category = $category;
		$this->picture = $picture;
		$this->title = $title;
		$this->content = $content;
		$this->created_at = $created_at;
		$this->comments = $comments;
		$this->updated_at = $updated_at;
	}

	/* #Region getPosts */
	public static function getPosts($filter)
	{
		// We create an empty array to collect all the posts
		$posts = array();
		// We check if the filter's value and query the database with the right SQL request
		switch ($filter) {
			case 'none':
				$sql = parent::executeRequest("SELECT * FROM post ORDER BY created_at DESC LIMIT 3");
				break;
			case 'all':
				$sql = parent::executeRequest("SELECT * FROM post ORDER BY created_at DESC");
				break;
			case 'latest':
				$sql = parent::executeRequest("SELECT * FROM post ORDER BY created_at DESC");
				break;
			case 'popular':
				$sql = parent::executeRequest("SELECT * FROM post ORDER BY created_at DESC");
				break;
			case 'mostCommented':
				$sql = parent::executeRequest("SELECT * FROM post ORDER BY created_at DESC");
				break;
			case '':
				$sql = parent::executeRequest("SELECT * FROM post ORDER BY created_at DESC LIMIT 3");
				break;
			default:
				$sql = parent::executeRequest("SELECT * FROM post WHERE category = ? ORDER BY created_at DESC", array($filter));
				break;
		}

		// We check if the request returned at least one result
		if ($sql->rowCount() > 0) {
			// We create a new Post object for each post
			while ($post = $sql->fetch(PDO::FETCH_ASSOC)) {
				$posts[] = new Post($post['id'], $post['author_id'], '', $post['category'], $post['picture'], $post['title'], $post['content'], $post['created_at'], $post['updated_at']);
			}
			// We get the author's username for each post
			foreach ($posts as $post) {
				$author = User::getUser($post->author_id);
				$post->author_username = $author->username;
				// We replace the date value with the format we want
				$post->created_at = Tools::formatDate($post->created_at);
				$post->updated_at = Tools::formatDate($post->updated_at);
			}
			// We return an array of posts
			return $posts;
		} else {
			// We throw an exception if no post was found
			throw new Exception("No articles found for the category '$filter'", 400);
		}
	}
	/* #EndRegion */


	/* #Region getPost($id) */
	public static function getPost($id)
	{
		// We get the post from the database
		$sql = parent::executeRequest("SELECT * FROM post WHERE id = ?", array($id));

		// We check if the request returned at least one result
		if ($sql->rowCount() > 0) {
			$post = $sql->fetch(PDO::FETCH_ASSOC);
			// We get the author's username
			$author = User::getUser($post['author_id']);
			// We replace the date value with the format we want
			$post['created_at'] = Tools::formatDate($post['created_at']);
			if ($post['updated_at'] !== null) {
				$post['updated_at'] = Tools::formatDate($post['updated_at']);
			} else {
				$post['updated_at'] = null;
			};
			// We return the post
			return new Post($post['id'], $author->id, $author->username, $post['category'], $post['picture'], $post['title'], $post['content'], $post['created_at'], $post['updated_at']);
		} else {
			// We throw an exception if no post was found
			throw new Exception("No article found for the id '$id'", 400);
		}
	}
	/* #EndRegion */


	/* #Region createPost */
	public static function addPost()
	{
		// We get the values from $_POST array
		$author_id = $_POST['author_id'];
		$category = filter_input(INPUT_POST, 'category');
		$title = $_POST['title'];
		$picture = $_FILES['post_picture'];
		$content = $_POST['content'];

		// We check the picture format and add it if OK
		if (!empty($_FILES['post_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('post_picture');
			if (!$checkPicture) {
				throw new Exception('The picture format is not valid.', 400);
			} else {
				$picture = $checkPicture;
			}
		}

		// We add the post to the database
		$sql = parent::executeRequest("INSERT INTO post (author_id, category, title, picture, content) VALUES (?,?,?,?,?)", array($author_id, $category, $title, $picture, $content));

		// We check if everything worked out fine
		if ($sql) {
			header('Refresh: 3; URL=./index.php?page=blog&option=all');
			throw new Exception('Your post has been successfully created.', 200);
		} else {
			throw new Exception('An error occurred while creating your post.', 400);
		}
	}
	/* #EndRegion */


	/* #Region updatePost */
	public static function updatePost()
	{
		// We get the values from $_POST array
		$id = $_POST['post_id'];
		$category = filter_input(INPUT_POST, 'category');
		$title = $_POST['title'];
		$content = $_POST['content'];
		$picture = '';

		// We check the picture format and add it if OK
		if (!empty($_FILES['post_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('post_picture');
			if (!$checkPicture) {
				throw new Exception('The picture format is not valid.', 400);
			} else {
				if (!empty($checkPicture)) {
					$picture = $checkPicture;
				} else {
					$picture = Post::getPost($id)->picture;
				}
			}
		}

		// We get the original values from the database
		$origin = Post::getPost($id);

		// we create an array with the values to update
		$datas = array(
			'title' => $title !== $origin->title ? $title : null,
			'category' => $category !== $origin->category ? $category : null,
			'content' => $content !== $origin->content ? $content : null,
			'picture' => $picture !== $origin->picture ? $picture : null
		);

		// For each value equal to null or empty, we remove it from the array
		foreach ($datas as $key => $value) {
			if ($value === null || $value === '') {
				unset($datas[$key]);
			}
		}

		// We check if the array is not empty
		if (!empty($datas)) {
			// We create the request
			foreach ($datas as $key => $value) {
				$set[] = "$key = ?";
				$bind[] = $value;
			}
			$set = implode(', ', $set);
			$bind[] = $id;
			$sql = parent::executeRequest("UPDATE post SET $set, updated_at = NOW() WHERE id = ?", $bind);


			// We check if everything worked out fine
			if ($sql) {
				header('Refresh: 3; URL=./index.php?page=blog&option=all');
				throw new Exception('Your post has been successfully updated.', 200);
			} else {
				throw new Exception('An error occurred while updating your post.', 400);
			}
		} else {
			header('Refresh: 3; URL=./index.php?page=blog&option=all');
			throw new Exception('No changes have been made.', 200);
		}
	}
	/* #EndRegion */


	/* #Region deletePost */
	public static function deletePost($id)
	{
		// We delete the post based on the post id
		$sql = parent::executeRequest("DELETE FROM post WHERE id =?", array($id));

		// We check if everything worked out fine
		if ($sql) {
			header('Refresh: 3; URL=./index.php?page=blog&option=all');
			throw new Exception('Your post has been successfully deleted.', 200);
		} else {
			// We throw an error
			throw new Exception("Something weird happened. Your post is active still!.", 400);
		}
	}
	/* #EndRegion */
}
