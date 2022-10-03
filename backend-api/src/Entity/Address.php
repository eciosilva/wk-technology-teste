<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @ORM\Table(indexes={
 *  @ORM\Index(name="idx_addr_customer", columns={"customer_id"}),
 *  @ORM\Index(name="idx_addr_city", columns={"city_id"})
 * })
 */
class Address implements JsonSerializable
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
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="_default.not_null")
     */
    private $number;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="_default.not_null")
     */
    private $district;

    /**
     * @ORM\Column(type="string", length="20")
     * @Assert\NotBlank(message="_default.not_null")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      normalizer = "trim"
     * )
     */
    private $zip;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="_default.not_null")
     */
    private $complement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="adresses")
     * @ORM\JoinColumn(nullable=false)
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="_default.not_null")
     * @var City
     */
    private $city;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'number' => $this->number,
            'district' => $this->district,
            'zip' => $this->zip,
            'complement' => $this->complement,
            'city' => $this->city
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
     * Get the value of street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of street
     */
    public function setStreet($street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of number
     */
    public function setNumber($number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of district
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set the value of district
     */
    public function setDistrict($district): self
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get the value of zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set the value of zip
     */
    public function setZip($zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get the value of complement
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set the value of complement
     */
    public function setComplement($complement): self
    {
        $this->complement = $complement;

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
     * Get the value of city
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }
}