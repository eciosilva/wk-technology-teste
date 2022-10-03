<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderProductRepository")
 * @ORM\Table(indexes={
 *  @ORM\Index(name="idx_order", columns={"order_id"}),
 *  @ORM\Index(name="idx_product", columns={"product_id"})
 * })
 */
class OrderProduct implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderProducts")
     */
    private $order;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="orderProducts")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $unitValue;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $totalValue;

    public function jsonSerialize(): array
    {
        return [
            'order' => $this->order,
            'product' => $this->product,
            'amount' => $this->amount,
            'unitValue' => $this->unitValue,
            'totalValue' => $this->totalValue
        ];
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     */
    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of unitValue
     */
    public function getUnitValue()
    {
        return $this->unitValue;
    }

    /**
     * Set the value of unitValue
     */
    public function setUnitValue($unitValue): self
    {
        $this->unitValue = $unitValue;

        return $this;
    }

    /**
     * Get the value of totalValue
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * Set the value of totalValue
     */
    public function setTotalValue($totalValue): self
    {
        $this->totalValue = $totalValue;

        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }
    
}