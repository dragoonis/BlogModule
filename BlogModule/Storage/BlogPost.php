<?php
namespace BlogModule\Storage;

use BlogModule\Storage\Base as BaseStorage;
use BlogModule\Entity\BlogPost as Entity;

class BlogPost extends BaseStorage
{

    protected $_meta = array(
        'conn'      => 'main',
        'table'     => 'blog_post',
        'primary'   => 'id',
        'fetchMode' => \PDO::FETCH_ASSOC
    );

    /**
     * Get a class entity by its ID
     *
     * @param $memberID
     *
     * @return mixed
     * @throws \Exception
     */
    public function getByID($memberID)
    {
        $row = $this->find($memberID);
        if ($row === false) {
            throw new \Exception('Unable to obtain class row for id: ' . $memberID);
        }

        return new Entity($row);

    }

    public function getSomePosts($limit)
    {

        // creating the sql statement.
        $rows = $this->createQueryBuilder()
                    ->select('t.*')
                    ->from($this->getTableName(), 't')
                    ->andWhere('t.published = 1')
                    ->orderBy('t.created_at', 'desc')
                    ->setMaxResults($limit)
                    ->execute()
                    ->fetchAll($this->getFetchMode());

        // avoiding an exception here..
        if ($rows === false) { return false; }

        return $this->rowsToEntities($rows);
    }

    public function getAllPublished()
    {

        $rows = $this->_conn->createQueryBuilder()
            ->select('bp.*')
            ->from($this->_meta['table'], 'bp')
            ->andWhere('bp.published = 1')
            ->orderBy('bp.created_at', 'desc')
            ->execute()->fetchAll($this->getFetchMode());

        if($rows === false) {
            throw new \Exception('No blog entries found');
        }

        return $this->rowsToEntities($rows);
    }

    public function getPostsFromCat($cat)
    {

        $rows = $this->_conn->createQueryBuilder()
            ->select('bp.*')
            ->from($this->_meta['table'], 'bp')
            ->innerJoin('bp', 'blog_post_category', 'bpc', 'bpc.post_id = bp.id')
            ->innerJoin('bp', 'blog_category', 'bc', 'bc.id = bpc.category_id')
            ->andWhere('bc.slug = :slug')
            ->andWhere('bp.published = 1')
            ->setParameter(':slug', $cat)
            ->orderBy('bp.created_at', 'desc')
            ->execute()->fetchAll($this->getFetchMode());

        if($rows === false) {
            throw new \Exception('No blog entries found');
        }

        return $this->rowsToEntities($rows);
    }

    public function getCatsByPostId($posts, $catStorage)
    {

        $map = array();
        foreach ($posts as $post) {
            $map[$post->getId()] = $catStorage->getByPostId($post->getId());
        }

        return $map;
    }

    public function getTagsByPostId($posts, $blogPostTagStorage)
    {

        $map = array();
        foreach ($posts as $post) {
            $map[$post->getId()] = $blogPostTagStorage->getByPostId($post->getId());
        }

        return $map;
    }

    public function getRelatedPostsByTag($id, $blogPostTagStorage)
    {

        $tags    = $blogPostTagStorage->getTagsByPostId($id);
        $related = array();

        foreach ($tags as $tag) {

            $posts = $blogPostTagStorage->getPostsByTagId($tag->getTagId());

            foreach ($posts as $post) {

                $postID = $post->getId();

                if ($id == $postID) { continue; }

                $related[$post->getId()] = $post;
            }

        }

        return $related;
    }

    /**
     * Delete a class by its primary key
     *
     * @param integer $memberID
     *
     * @return mixed
     */
    public function deleteByID($memberID)
    {
        return $this->delete(array($this->getPrimaryKey() => $memberID));
    }

    public function getTitleById($id)
    {

        $row = $this->createQueryBuilder()
                ->select('c.title')
                ->from($this->getTableName(), 'c')
                ->andWhere('c.id = :id')
                ->setParameter(':id', $id)
                ->execute()
                ->fetch($this->getFetchMode());

        if ($row === false) {
            return null;
        }

        return $row['title'];
    }

    public function getPublishedPosts()
    {
        $rows = $this->createQueryBuilder()
                ->select('p.*')
                ->from($this->getTableName(), 'p')
                ->andWhere('p.published = 1')
                ->execute()
                ->fetchAll($this->getFetchMode());

        // No blog posts?
        if (empty($rows)) {
            return new Entity(array());
        }

        return $this->rowsToEntities($rows);
    }

    public function getDraftedPosts()
    {
        $rows = $this->createQueryBuilder()
                ->select('p.*')
                ->from($this->getTableName(), 'p')
                ->andWhere('p.published = 0')
                ->execute()
                ->fetchAll($this->getFetchMode());

        // No blog posts?
        if (empty($rows)) {
            return new Entity(array());
        }

        return $this->rowsToEntities($rows);
    }

    public function getByTitle($title)
    {

        $row = $this->createQueryBuilder()
                ->select('c.*')
                ->from($this->getTableName(), 'c')
                ->andWhere('c.title = :title')
                ->setParameter(':title', $title)
                ->execute()
                ->fetch($this->getFetchMode());

        if ($row === false) {
            throw new \Exception('Unable to find member record by title: ' . $title);
        }

        return new Entity($row);

    }

    public function getBySlug($slug)
    {

        $row = $this->createQueryBuilder()
                ->select('c.*')
                ->from($this->getTableName(), 'c')
                ->andWhere('c.slug = :slug')
                ->setParameter(':slug', $slug)
                ->execute()
                ->fetch($this->getFetchMode());

        if ($row === false) {
            throw new \Exception('Unable to find member record by slug: ' . $slug);
        }

        return new Entity($row);

    }

    /**
     * Check if a user record exists by User ID
     *
     * @param integer $id
     *
     * @return bool
     */
    public function existsByID($id)
    {
        $row = $this->createQueryBuilder()
                ->select('count(id) as total')
                ->from($this->getTableName(), 'u')
                ->andWhere('u.id = :id')
                ->setParameter(':id', $id)
                ->execute()
                ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

    public function create($post)
    {
        return $this->insert($post);
    }


    /**
     * Get entity objects from all users rows
     *
     * @return Entity The Entities map.
     */
    public function getAll()
    {
        $rows = $this->fetchAll($this->getFetchMode());

        return $this->rowsToEntities($rows);

    }

    /**
     * Get the total number of
     *
     * @return integer
     */
    public function countAll()
    {
        $row = $this->createQueryBuilder()
                ->select('count(id) as total')
                ->from($this->getTableName(), 'c')
                ->execute()
                ->fetch($this->getFetchMode());

        return $row['total'];
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