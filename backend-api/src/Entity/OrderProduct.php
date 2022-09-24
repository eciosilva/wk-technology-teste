<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="order_id", type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderProducts")
     */
    private $order;

    /**
     * @ORM\Id()
     * @ORM\Column(name="product_id", type="integer")
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
}