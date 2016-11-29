<?php

namespace App\Core\Models\Repository;

use App\Core\DB\DatabaseService;
use App\Core\Models\Entity\CommentEntity;

class CommentRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * CommentRepository constructor.
     */
    public function __construct()
    {
        $this->pdo = DatabaseService::getInstance()->getPDO();
    }

    /**
     * Добавление коментария в БД
     *
     * @param CommentEntity $commentEntity
     * @return bool
     */
    public function addComment(CommentEntity $commentEntity)
    {
        $sql = "INSERT INTO comments (text, email, parent_id, created_at) 
                        VALUES (:text, :email, :parent_id, :created_at)";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([
            'text'          => $commentEntity->getText(),
            'email'         => $commentEntity->getEmail(),
            'parent_id'     => $commentEntity->getParentId(),
            'created_at'    => date("Y-m-d H:i:s"),
        ]);
    }

    /**
     * Получение всех сообщений с БД
     *
     * @return array|bool
     */
    public function getAllComment(){
        $sql = "SELECT * FROM comments ORDER BY created_at ASC";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        if( $stm->rowCount() > 0 ){
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        }

        return false;
    }

    /**
     * Построение древовидных комментариев
     *
     * @param $array
     * @return array
     */
    public function build_tree_array($array) {
        $tree = array();
        if (is_array($array)) {
            $new_key = array();
            foreach ($array as $key => &$val) {
                $new_key[$val['id']] = &$val;
            }

            if (!empty($new_key)) {
                foreach ($new_key as $id => &$row) {
                    if ($row['parent_id'] == 0) {
                        $tree[$id] = &$row;
                    } else {
                        $new_key[$row['parent_id']]['children'][$id] = &$row;
                    }
                }
            }
        }

        return array_reverse($tree);
    }
}