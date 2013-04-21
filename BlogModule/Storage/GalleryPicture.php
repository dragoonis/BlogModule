<?php
namespace BlogModule\Storage;

use BlogModule\Storage\Base as BaseStorage;
use BlogModule\Entity\BlogCategory as Entity;

class GalleryPicture extends BaseStorage
{

    protected $_meta = array(
        'conn'      => 'main',
        'table'     => 'gallery_picture',
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
        $rows  = $this->fetchAll($this->getFetchMode());

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