<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="_default.not_null")
     * @Assert\Length(
     *      min = 4,
     *      normalizer = "trim"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank(message="_default.not_null")
     * @Assert\Positive()
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="product", cascade={"persist", "remove"})
     * @var ArrayCollection|OrderProduct[]|array
     */
    private $orderProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price
        ];
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): ArrayCollection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->add($orderProduct);
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            /*if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }*/
        }

        return $this;
    }
}