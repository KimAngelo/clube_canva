<?php


namespace Source\Models;


use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;

/**
 * Class ArtCategory
 * @package Source\Models
 */
class ArtCategory extends DataLayer
{
    /**
     * ArtCategory constructor.
     */
    public function __construct()
    {
        parent::__construct('art_category', ['art', 'category'], 'id', false);
    }

    public function count_arts(int $category)
    {
        $connect = Connect::getInstance();
        $sql = "SELECT count(a.id) as total FROM art_category as ac 
                inner join arts as a on ac.art = a.id
                WHERE ac.category = :category";
        $sql = $connect->prepare($sql);
        $sql->bindValue(':category', $category);
        $sql->execute();
        return $arts = $sql->fetch();
    }

    public function arts_categories(int $category, int $limit, int $offset)
    {
        $connect = Connect::getInstance();
        $sql = "SELECT a.id, a.name, a.thumb FROM art_category as ac 
                inner join arts as a on ac.art = a.id
                WHERE ac.category = :category
                ORDER BY a.id DESC LIMIT {$limit} OFFSET {$offset}";
        $sql = $connect->prepare($sql);
        $sql->bindValue(':category', $category);
        $sql->execute();
        return $arts = $sql->fetchAll();
    }

    public function filterAdminCount(string $text, int $pack, int $category)
    {
        $connect = Connect::getInstance();
        $sql = "SELECT count(*) as total FROM art_category as ac 
                inner join arts as a on ac.art = a.id
                WHERE 
                (a.name LIKE :text or a.description LIKE :text)";

        if (!empty(trim($pack))) {
            $sql .= " AND a.id_pack = :pack";
        }
        if (!empty(trim($category))) {
            $sql .= ' AND ac.category = :category';
        }

        $sql = $connect->prepare($sql);
        $sql->bindValue(':text', "%{$text}%");

        if (!empty(trim($pack))) {
            $sql->bindValue(':pack', $pack);
        }
        if (!empty(trim($category))) {
            $sql->bindValue(':category', $category);
        }
        $sql->execute();
        return $arts = $sql->fetch();
    }

    public function filterAdmin(string $text, int $pack, int $category, int $limit, int $offset)
    {
        $connect = Connect::getInstance();
        $sql = "SELECT a.id, a.name, a.thumb, ac.category FROM art_category as ac 
                inner join arts as a on ac.art = a.id
                WHERE 
                (a.name LIKE :text or a.description LIKE :text)";

        if (!empty(trim($pack))) {
            $sql .= " AND a.id_pack = :pack";
        }
        if (!empty(trim($category))) {
            $sql .= ' AND ac.category = :category';
        }
        $sql .= " GROUP BY a.id ORDER BY a.id DESC LIMIT {$limit} OFFSET {$offset}";

        $sql = $connect->prepare($sql);
        $sql->bindValue(':text', "%{$text}%");

        if (!empty(trim($pack))) {
            $sql->bindValue(':pack', $pack);
        }
        if (!empty(trim($category))) {
            $sql->bindValue(':category', $category);
        }
        $sql->execute();
        return $arts = $sql->fetchAll();
    }
}