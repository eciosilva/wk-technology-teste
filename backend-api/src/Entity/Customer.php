<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table(indexes={
 *      @ORM\Index(name="idx_customer_email", columns={"email"})
 * }, uniqueConstraints={
 *      @ORM\UniqueConstraint(name="idx_customer_email", columns={"email"}),
 *      @ORM\UniqueConstraint(name="idx_customer_cpf", columns={"cpf"}),
 * })
 * @UniqueEntity("email", message="customer.email.already_been_used")
 */
class Customer implements JsonSerializable
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
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 11,
     *      max = 11,
     *      normalizer = "trim"
     * )
     */
    private $cpf;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="_default.not_null")
     * @Assert\Email(
     *      mode = "html5",
     *      normalizer = "trim"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTime $birthdate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="customer")
     * @var ArrayCollection|array
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="customer", cascade={"persist", "remove"})
     * @var ArrayCollection|array
     */
    private $adresses;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->adresses = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'cpf'   => $this->cpf,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'adresses'  => $this->adresses
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
     * Get the value of cpf
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf($cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of birthdate
     */
    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     */
    public function setBirthdate(?\DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get the value of orders
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * Set the value of orders
     */
    public function setOrders(ArrayCollection|array $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get the value of adresses
     */
    public function getAdresses(): ArrayCollection
    {
        return $this->adresses;
    }

    /**
     * Set the value of adresses
     */
    public function setAdresses(ArrayCollection|array $adresses): self
    {
        $this->adresses = $adresses;

        return $this;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            /*if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }*/
        }

        return $this;
    }

    public function addAdress(Address $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setCustomer($this);
        }

        return $this;
    }

    public function removeAdress(Address $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            /*if ($adress->getCustomer() === $this) {
                $adress->setCustomer(null);
            }*/
        }

        return $this;
    }
}