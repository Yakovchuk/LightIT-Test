<?php

namespace App\Core\Controllers;

use App\Core\Controller;
use App\Core\Core;
use App\Libs\Facebook\FacebookCustom;

class Home extends Controller
{
    /**
     * Home constructor.
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        parent::_construct($core);
    }

    /**
	 * Основной рабочий метод
	 *
	 * @return string
	 */
	public function index()
    {
        if ( isset($_SESSION['facebook_access_token']) ){
            $this->redirect('/comments/');
        }
        $fb = new FacebookCustom();

        return $this->twig->render('HomeController\index.html.twig', ['fb_auth_url' => $fb->AuthUrl()]);
	}

    /**
     * @param array $params
     * @return bool
     */
    public function initialize(array $params = array())
    {
        return true;
    }

    /**
     *
     */
    public function Logout()
    {
        session_destroy();

        $this->redirect('/');
    }
}
