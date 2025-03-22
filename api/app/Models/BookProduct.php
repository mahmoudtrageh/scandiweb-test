<?php

namespace App\Models;

class BookProduct extends AbstractProduct
{
    protected $weight;
    protected $type = 'Book';

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getSpecificAttributes()
    {
        return [
            'size' => null,
            'weight' => $this->getWeight(),
            'height' => null,
            'width' => null,
            'length' => null
        ];
    }

    protected function setSpecificAttributes($data)
    {
        $this->setWeight($data->weight ?? null);
    }

    public static function createFromData($data, \PDO $db)
    {
        $product = new self($db);
        $product->setSku($data->sku ?? '');
        $product->setName($data->name ?? '');
        $product->setPrice($data->price ?? 0);
        $product->setType('Book');
        $product->setSpecificAttributes($data);
        
        return $product;
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO {$this->table} (sku, name, price, type, size, weight, height, width, length) 
                    VALUES (:sku, :name, :price, :type, :size, :weight, :height, :width, :length)";

            $stmt = $this->conn->prepare($sql);

            $sku = htmlspecialchars($this->getSku(), ENT_QUOTES, 'UTF-8');
            $name = htmlspecialchars($this->getName(), ENT_QUOTES, 'UTF-8');
            $price = $this->getPrice();
            $type = $this->getType();
            $attributes = $this->getSpecificAttributes();

            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':size', $attributes['size']);
            $stmt->bindParam(':weight', $attributes['weight']);
            $stmt->bindParam(':height', $attributes['height']);
            $stmt->bindParam(':width', $attributes['width']);
            $stmt->bindParam(':length', $attributes['length']);

            return $stmt->execute();
        } catch (\PDOException $e) {
            // Log the actual error for debugging
            error_log("Database error in save(): " . $e->getMessage());
            throw new \Exception("BookDatabase error: " . $e->getMessage());
        }
    }
}