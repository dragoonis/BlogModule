<?php
namespace BlogModule\Storage;

use BlogModule\Storage\Base as BaseStorage;
use BlogModule\Entity\BlogTag as Entity;

class BlogPostTag extends BaseStorage
{

    protected $_meta = array(
        'conn'      => 'main',
        'table'     => 'blog_post_tag',
        'primary'   => 'id',
        'fetchMode' => \PDO::FETCH_ASSOC
    );

    public function create($post)
    {
        return $this->insert($post);
    }

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

    public function isExists($tagId, $postId)
    {

        $row = $this->createQueryBuilder()
            ->select('t.*')
            ->from($this->getTableName(), 't')
            ->andWhere('t.post_id = :post_id')
            ->andWhere('t.tag_id = :tag_id')
            ->setParameter(':post_id', $postId)
            ->setParameter(':tag_id', $tagId)
            ->execute()
            ->fetch($this->getFetchMode());

        return !empty($row);
    }


    public function getByPostId($id)
    {
        $rows = $this->createQueryBuilder()
            ->select('c.*')
            ->from($this->getTableName(), 't')
            ->leftJoin('t', 'blog_tag', 'c', 'c.id = t.tag_id')
            ->andWhere('t.post_id = :id')
            ->setParameter(':id', $id)
            ->execute()
            ->fetchAll($this->getFetchMode());

        return $this->rowsToEntities($rows);
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