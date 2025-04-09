<?php

namespace App\DTO;

class ProductDTO
{
    private ?int $id;

    private string $name;

    private ?string $description;

    private float $price;

    private ?string $image;

    public function __construct(
        string $name,
        float $price,
        ?string $description = null,
        ?string $image = null,
        ?int $id = null
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->description  = $description;
        $this->price        = $price;
        $this->image        = $image;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            (float) $data['price'],
            $data['description'] ?? null,
            $data['image'] ?? null,
            $data['id'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'price'         => $this->price,
            'image'         => $this->image,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
