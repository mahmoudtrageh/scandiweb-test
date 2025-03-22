<?php

namespace App\Models;

abstract class AbstractProduct
{
    protected $conn;
    protected $table = 'products';

    // Common product properties
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct(\PDO $db)
    {
        $this->conn = $db;
    }

    // Common getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    // Common methods for all products
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function deleteMultiple(array $ids)
    {
        if (empty($ids)) {
            return false;
        }

        $idString = implode(',', array_map('intval', $ids));
        $sql = "DELETE FROM {$this->table} WHERE id IN ($idString)";
        return $this->conn->query($sql);
    }

    // Abstract methods that must be implemented by child classes
    abstract public function save();
    abstract public function getSpecificAttributes();
    abstract protected function setSpecificAttributes($data);
    abstract public static function createFromData($data, \PDO $db);
}