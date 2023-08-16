<?php

require_once './templates/view.php';
require_once './src/controllers/constructor/ModelConstructor.php';
require_once './src/model/post.php';
require_once './src/model/comment.php';
require_once './src/model/user.php';
require_once './src/model/userConnection.php';
require_once './src/model/newsletter.php';


class ControllerConstructor extends ModelConstructorController
{
	private $view;
	private $datas;
	private $title = 'My Awesome Blog !! - ';
	private $templatePath;

	private function setTitleAndTemplatePath($titleAppendix, $templatePathAppendix)
	{
		$this->title .= $titleAppendix;
		$this->templatePath = $templatePathAppendix;
	}

	private function setDefaultTitleAndTemplatePath($page)
	{
		$this->setTitleAndTemplatePath(ucfirst($page), $page . '/' . $page);
	}

	private function handlePostAction($action, $option, $page)
	{
		switch ($action) {
			case 'get':
				$this->setTitleAndTemplatePath(ucfirst($option) . ' a ' . $page, $page . '/' . $page . ucfirst($option));
				break;
			case 'add':
				$titleAppendix = 'a ' . ($option === 'comment' ? '' : $page);
				$templatePathAppendix = $page . '/' . ($option === 'comment' ? $page : $page . 'Add');
				$this->setTitleAndTemplatePath(ucfirst($action) . $titleAppendix, $templatePathAppendix);
				break;
				// Handle other cases...
		}
	}

	public function buildControllerMethod($page, $action = null, $option = null, $id = null)
	{
		switch ($page) {
			case 'post':
				$this->handlePostAction($action, $option, $page);
				break;
			case 'userProfile':
				session_start();
				if (!isset($_SESSION['logged_user'])) {
					header('Location: index.php?page=login');
					exit();
				}
				switch ($action) {
					case 'get':
					case 'update':
					case 'delete':
						$this->setDefaultTitleAndTemplatePath($page);
						break;
				}
				break;
				// Handle other cases...
			default:
				$this->setDefaultTitleAndTemplatePath($page);
				break;
		}

		if (empty($this->datas)) {
			$this->datas = parent::buildModelMethod($page, $action, $option, $id);
		}

		$this->view = new View($this->templatePath, $this->title);
		$this->view->render(['title' => $this->title, 'page' => $page, 'datas' => $this->datas, 'filter' => $option]);
	}
}





// class ControllerConstructor extends ModelConstructorController
// {
// 	private $view;
// 	private $datas;
// 	private $title = 'My Awesome Blog !! - ';
// 	private $templatePath;


// 	public function buildControllerMethod($page, $action = null, $option = null, $id = null)
// 	{
// 		switch ($page) {
// 			case 'post':
// 				switch ($action) {
// 					case 'get':
// 						$this->title = $this->title . ucfirst($option) . ' a ' . $page;
// 						$this->templatePath = $page . '/' . $page . ucfirst($option);
// 						break;
// 					case 'add':
// 						switch ($option) {
// 							case 'comment':
// 								$this->title = $this->title . ucfirst($action) . 'a ' . $option;
// 								$this->templatePath = $page . '/' . $page;
// 								break;

// 							default:
// 								$this->title = $this->title . ucfirst($action) . 'a ' . $page;
// 								$this->templatePath = $page . '/' . $page . 'Add';
// 								break;
// 						}
// 						break;
// 					case 'new':
// 						$this->title = $this->title . ucfirst($action) . 'a ' . $page;
// 						$this->templatePath = $page . '/' . $page . 'Add';
// 						break;
// 					case 'update':
// 						switch ($option) {
// 							case 'get':
// 								$this->title = $this->title . ucfirst($action) . ' a ' . $page;
// 								$this->templatePath = $page . '/' . $page . ucfirst($action);
// 								break;
// 							case 'comment':
// 								$this->title = $this->title . ucfirst($action) . 'a ' . $option;
// 								$this->templatePath	= $page . '/' . $page;
// 								break;
// 							default:
// 								$this->title = $this->title . ucfirst($action) . ' a ' . $page;
// 								$this->templatePath = $page . '/' . $page;
// 								break;
// 						}
// 						break;
// 					case 'delete':
// 						switch ($option) {
// 							case 'comment':
// 								$this->title = $this->title . ucfirst($action) . 'a ' . $option;
// 								$this->templatePath	= $page . '/' . $page;
// 								break;
// 							default:
// 								$this->title = $this->title . ucfirst($action) . ' a ' . $page;
// 								$this->templatePath = $page . '/' . $page;
// 								break;
// 						}
// 						break;
// 					case 'validate':
// 						$this->title = $this->title . ucfirst($action) . ' a ' . $option;
// 						$this->templatePath = $page . '/' . $page;
// 						break;
// 					case 'refuse':
// 						$this->title = $this->title . ucfirst($action) . 'a ' . $option;
// 						$this->templatePath = $page . '/' . $page;
// 						break;
// 				}
// 				break;
// 				/* #EndRegion: Post */
// 			case 'userProfile':
// 				session_start();
// 				if (!isset($_SESSION['logged_user'])) {
// 					header('Location: index.php?page=login');
// 					exit();
// 				}
// 				switch ($action) {
// 					case 'get':
// 						$this->title = $this->title . ucfirst($page);
// 						$this->templatePath = $page . '/' . $page;
// 						break;
// 					case 'update':
// 						$this->title = $this->title . ucfirst($action) . ucfirst($page);
// 						$this->templatePath = $page . '/' . $page;
// 						break;
// 					case 'delete':
// 						$this->title = $this->title . ucfirst($action) . ucfirst($page);
// 						$this->templatePath = $page . '/' . $page;
// 						break;
// 				}
// 				break;
// 			case 'contact':
// 				switch ($action) {
// 					case 'send':
// 						$this->title = $this->title . ucfirst($action) . ' a ' . $page;
// 						$this->datas = Tools::contactForm();
// 						$this->templatePath = $page . '/' . $page;
// 						break;
// 				}
// 				$this->title = $this->title . ucfirst($page);
// 				$this->templatePath = $page . '/' . $page;
// 				break;
// 			case 'resume':
// 				switch ($action) {
// 					case 'download':
// 						$this->title = $this->title . ucfirst($action) . ' a ' . $page;
// 						$this->templatePath = $page . '/' . $page;
// 						$this->datas = Tools::downloadResume();
// 						break;
// 				}
// 				$this->title = $this->title . 'My Bro-lific ' . ucfirst($page);
// 				$this->templatePath = $page . '/' . $page;
// 				break;
// 			default:
// 				$this->title = $this->title . ucfirst($page);
// 				$this->templatePath = $page . '/' . $page;
// 				break;
// 		}
// 		if (empty($this->datas)) {
// 			$this->datas = parent::buildModelMethod($page, $action, $option, $id);
// 		}
// 		$this->view = new View($this->templatePath, $this->title);
// 		$this->view->render(array('title' => $this->title, 'page' => $page, 'datas' => $this->datas, 'filter' => $option));
// 	}
// }