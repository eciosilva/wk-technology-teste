<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table(indexes={
 *      @ORM\Index(name="idx_customer_email", columns={"email"})
 * }, uniqueConstraints={
 *      @ORM\UniqueConstraint(name="idx_customer_email", columns={"email"}),
 *      @ORM\UniqueConstraint(name="idx_customer_cpf", columns={"cpf"}),
 * })
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
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $cpf;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private \DateTime $birthdate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="customer")
     * @var Order[]
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="customer")
     * @var Address[]
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
            'cpf'  => $this->cpf,
            'email'   => $this->email,
            'birthdate'   => $this->birthdate
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
    public function setBirthdate(\DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get the value of orders
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * Set the value of orders
     */
    public function setOrders(array $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get the value of adresses
     */
    public function getAdresses(): array
    {
        return $this->adresses;
    }

    /**
     * Set the value of adresses
     */
    public function setAdresses(array $adresses): self
    {
        $this->adresses = $adresses;

        return $this;
    }
}