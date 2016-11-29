<?php

namespace App\Core\Controllers;

use App\Core\Controller;
use App\Core\Core;
use App\Core\Models\Entity\CommentEntity;
use App\Core\Models\Repository\CommentRepository;
use App\Libs\Facebook\FacebookCustom;

class Comments extends Controller
{
    /**
     * Comments constructor.
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        parent::_construct($core);
    }


    /**
     * @param array $params
     * @return bool
     */
    public function initialize(array $params = array())
    {
        if (empty($params)) {
            $this->redirect('/comments/');
        }

        return true;
    }


    /**
     * Основной метод
     *
     * @return mixed
     */
    public function index()
    {
        if ( isset($_SESSION[FACEBOOK_SESSION_NAME_TOKEN]) ){
            $fb = new FacebookCustom();
            $this->fb_email = $fb->getEmail();
            $this->fb_name = $fb->getName();
            $this->fb_auth = true;
        }

        $comments = new CommentRepository();
        $comment_all = $comments->build_tree_array($comments->getAllComment());

        if ( $this->isPost ){
            $comment = new CommentEntity($this->fb_email, $this->dataPost['text'], $this->dataPost['parent_id']);
            if ( $comment->isValid() ){
                $commentRepository = new CommentRepository();
                $res = $commentRepository->addComment($comment);
                if ( $res ){
                    $this->redirect('/comments/');
                }
            }
        }

        return $this->twig->render('CommentsController\index.html.twig', [
                                            'comments'  => $comment_all,
                                            'fb_auth'   => $this->fb_auth,
                                            'fb_name'   => $this->fb_name,
                                        ]);
    }
}