<?php
namespace BlogModule\Storage;

use BlogModule\Storage\Base as BaseStorage;
use BlogModule\Entity\BlogCategory as Entity;

class BlogPostCategory extends BaseStorage
{

    protected $_meta = array(
        'conn'      => 'main',
        'table'     => 'blog_post_category',
        'primary'   => 'id',
        'fetchMode' => \PDO::FETCH_ASSOC
    );

    /**
     * Check if a user record exists by User ID
     *
     * @param integer $id
     *
     * @return bool
     */
    public function existsByPostID($id)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.post_id = :id')
            ->setParameter(':id', $id)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

    public function getByPostId($id)
    {
        $rows = $this->createQueryBuilder()
            ->select('c.*')
            ->from($this->getTableName(), 't')
            ->leftJoin('t', 'blog_category', 'c', 'c.id = t.category_id')
            ->andWhere('t.post_id = :id')
            ->setParameter(':id', $id)
            ->execute()
            ->fetchAll($this->getFetchMode());

        return $this->rowsToEntities($rows);
    }

    public function isExists($catId, $postId)
    {

        $row = $this->createQueryBuilder()
            ->select('t.*')
            ->from($this->getTableName(), 't')
            ->andWhere('t.post_id = :post_id')
            ->andWhere('t.category_id = :category_id')
            ->setParameter(':post_id', $postId)
            ->setParameter(':category_id', $catId)
            ->execute()
            ->fetch($this->getFetchMode());

        return !empty($row);
    }

    public function create($post)
    {
        return $this->insert($post);
    }


    public function rowsToEntities($rows)
    {
        $ent = array();
        foreach ($rows as $r) {
            $ent[] = new Entity($r);
        }

        return $ent;
    }

}