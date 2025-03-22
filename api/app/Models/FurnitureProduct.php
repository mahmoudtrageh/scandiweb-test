<?php

namespace App\Models;

class FurnitureProduct extends AbstractProduct
{
    protected $height;
    protected $width;
    protected $length;
    protected $type = 'Furniture';

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getSpecificAttributes()
    {
        return [
            'size' => null,
            'weight' => null,
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'length' => $this->getLength()
        ];
    }

    protected function setSpecificAttributes($data)
    {
        $this->setHeight($data->height ?? null);
        $this->setWidth($data->width ?? null);
        $this->setLength($data->length ?? null);
    }

    public static function createFromData($data, \PDO $db)
    {
        $product = new self($db);
        $product->setSku($data->sku ?? '');
        $product->setName($data->name ?? '');
        $product->setPrice($data->price ?? 0);
        $product->setType('Furniture');
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
            throw new \Exception("Furniture Database error: " . $e->getMessage());
        }
    }
}