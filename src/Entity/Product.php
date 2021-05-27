<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    const DES_MENSAJE_REGISTRO_PRODUCTO = 'Producto registrado satisfactoriamente';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *      type="string", 
     *      length=10,
     *      nullable=false,
     *      unique=true
     *  )
     * @AcmeAssert\ContainsAlphanumeric
     * @Assert\NotBlank(
     *      message="Por favor ingrese un codigo de producto"
     * )  
     */
    private $code;


    /**
     * @ORM\Column(
     *      type="string", 
     *      length=255,
     *      unique=true
     * )
     * @AcmeAssert\ContainsAlphanumeric
     * @Assert\NotBlank(
     *      message="Por favor ingrese un nombre de producto"
     * )   
     */
    private $nombre;

    /**
     * @ORM\Column(
     *      type="string", 
     *      length=255
     * )
     * @AcmeAssert\ContainsAlphanumeric
     * @Assert\NotBlank(
     *      message="Por favor ingrese un descripción de producto"
     * )
     */
    private $description;

    /**
     * @ORM\Column(
     *      type="string",
     *      length=255
     * )
     * @Assert\NotBlank(
     *      message="Por favor ingrese marca de producto"
     * )
     */
    private $brand;

    /**
     * @Assert\Positive(
     *      message = "Debe colocar un valor positivo"
     * )
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
