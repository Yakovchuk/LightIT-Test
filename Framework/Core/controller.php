<?php

namespace App\Core;

class Controller
{
	/** @var Core $core */
	public $core;

    /**
     * @var
     */
    public $twig;

    /**
     * @var bool
     */
    public $isPost = false;

    /**
     * @var
     */
    public $dataPost;

    /**
     * @var string
     */
    protected $fb_email = 'guest@guest.com';

    /**
     * @var bool
     */
    protected $fb_auth = false;

    /**
     * @var null
     */
    protected $fb_name = NULL;

	/**
	 * Конструктор класса, требует передачи Core
	 *
	 * @param Core $core
	 */
	function _construct(Core $core)
    {
		$this->core = $core;

        $this->twig = $this->core->getTwig();
	}

	/**
	 * Основной рабочий метод
	 *
	 * @return string
	 */
	public function index()
    {
		return "page";
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
     * @param string $url
     */
    public function redirect($url = '/')
    {
        header("Location: {$url}");
        exit();
    }
}
