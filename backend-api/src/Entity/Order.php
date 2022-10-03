<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`", indexes={
 *  @ORM\Index(name="idx_order_customer", columns={"customer_id"})
 * })
 */
class Order implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $totalValue;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="order", cascade={"persist", "remove"})
     * @var ArrayCollection|array
     */
    private $orderProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'customer'  => $this->customer,
            'createdAt'  => $this->createdAt,
            'totalValue'   => $this->totalValue
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
     * Get the value of createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

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

    /**
     * Get the value of customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * Set the value of customer
     */
    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get the value of orderProducts
     */
    public function getOrderProducts(): ArrayCollection|array
    {
        return $this->orderProducts;
    }

    /**
     * Set the value of orderProducts
     */
    public function setOrderProducts($orderProducts): self
    {
        $this->orderProducts = $orderProducts;

        return $this;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->add($orderProduct);
            $orderProduct->setOrder($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            /*if ($orderProduct->getOrder() === $this) {
                $orderProduct->setOrder(null);
            }*/
        }

        return $this;
    }
}