<?php

namespace App\Entity;

use App\Repository\OrderTaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderTaxRepository::class)]
class OrderTax
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: 'Order', inversedBy: 'tax')]
    #[ORM\JoinColumn(name: 'uuid', referencedColumnName: 'uuid')]
    private Order $order;

    #[ORM\Column(type: 'float')]
    private float $taxValue;
    
    public function __construct(Order $order, float $taxValue)
    {
        $this->order = $order;
        $this->taxValue = $taxValue;
    }

    public function getTaxValue(): float
    {
        return $this->taxValue;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
