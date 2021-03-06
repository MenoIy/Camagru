<?php

require_once("./app/controllers/UserController.php");
require_once("./app/models/UserModel.php");
require_once("./app/controllers/ImageController.php");
require_once("./app/models/ImageModel.php");
require_once('./config/database.php');
require_once("./core/Database.php");
require_once("./core/Validator.php");
require_once("./app/controllers/ImageController.php");
require_once("./core/Picture.php");


session_start();


$db = new Database();
$url = 'home';
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_GET['url']))
	$url = $_GET['url'];
if (isset($_SERVER['REQUEST_URI']))
	$request = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['loggued_on_user']) &&
	(strcmp($url, "login") == 0 || (strcmp($url, "register") == 0) || (strcmp($url, "reset") == 0)))
	$url = "home";
else if (!isset($_SESSION['loggued_on_user']) && (strcmp($url, "camera") == 0))
		$url = "home";

switch ($url)
{
	case "login":
	{
		$errors = [''];
		switch ($method)
		{
			case "POST":
			{
				$userController = new UserController($db);
				$errors = $userController->login($_POST);
			} break ;
		}
		if (isset($errors))
			require(__DIR__. '/view/login/login.php');
		else
			require(__DIR__ . '/view/home/home.php');
	} break ;


	case "register":
	{
		$errors = [''];
		switch ($method)
		{
			case "POST":
			{
				$userController = new UserController($db);
				$errors = $userController->addUser($_POST);
			} break ;
		}
		if (isset($errors))
			require(__DIR__. '/view/register/register.php');
		else
			require(__DIR__ . '/view/login/login.php');
	} break ;


	case "home":
	{
		$errors = null;
		switch($method)
		{
			case "POST" :
			{
				$imageController = new ImageController($db);
				switch($_POST['action'])
				{
					case "like" :
					{
						$errors = $imageController->like($_POST);
					}break;
					case "comment":
					{
						$errors = $imageController->comment($_POST);  
					}break;
				}
			}break;
		}
		if (isset($errors))
		{
			switch($errors['error_type'])
			{
				case 'Login to Comment':
				{
					require(__DIR__. '/view/login/login.php');
				}break;
				default:
				{
					require(__DIR__ . '/view/home/home.php');
				}break;
			}
		}
		else
			require(__DIR__ . '/view/home/home.php');
	} break ;
	case "verify" :
	{
		switch ($method)
		{
			case "GET":
			{
				$UserController = new UserController($db);
				if ($UserController->verifyAccount($_GET))
					header("location: index.php?url=login");
				else
					echo "Account activation failed !";
			}break;
		}
	}break;
	case "logout" :
	{
		switch ($method)
		{
			case "GET":
			{
				$UserController = new UserController($db);
				$UserController->logout();
				require(__DIR__ . '/view/home/home.php');
			}break;
		}
	}break;
	case "profile" :
	{   
		$errors = [''];
		switch ($method)
		{
			case "POST":
			{
				$UserController = new UserController($db);
				$errors = $UserController->changeProfile($_POST);
			}break;
		}
		if (isset($errors))
			require(__DIR__. '/view/profile/profile.php');
		else
			require(__DIR__ . '/view/home/home.php');
	} break;

	case "reset_password" :
	{
		$errors = [''];
		switch ($method)
		{
			case "POST":
			{
				$UserController = new UserController($db);
				$errors = $UserController->resetPassword($_POST); 
			}break;
		}
		if (isset($errors))
			require(__DIR__ . '/view/reset_password/reset_password.php');
		else
			require(__DIR__ . '/view/login/login.php');
 
	} break ;

	case "reset" :
	{
			$errors = [''];
	   
			switch ($method)
			{
				case "GET" :
				{
					if (isset($_GET['token']))
						$_SESSION['token'] = $_GET['token'];
				   // require(__DIR__ . '/view/reset_password/reset.php');
				}break ;
				case "POST":
				{
					$UserController = new UserController($db);
					$errors = $UserController->newPassword($_POST); 
				}break;
			}
			if (isset($errors))
				require(__DIR__ . '/view/reset_password/reset.php');
			else
			{
				$_SESSION['token'] = null;
				require(__DIR__ . '/view/login/login.php');
			}

	} break ;
	case "camera" :
	{
			switch ($method)
			{
				case "POST" :
					{
						$ImageController = new ImageController($db);
						switch($_POST['action'])
						{
							case "delete" :
							{
								$ImageController->deleteImage($_POST);
							}break;
							case "save":
							{
								$ImageController->saveImage($_POST, $_SESSION['loggued_on_user']);
							}break;
						}
					}break;
			}
			require(__DIR__ . '/view/camera/camera.php');
	} break ;
	default :
	{
		require(__DIR__ . '/view/home/home.php'); 
	}
 
}
if (isset($_SESSION['loggued_on_user']))
	echo "  connected user = ".$_SESSION['loggued_on_user'];
else
	echo "";
?>
<script>
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>