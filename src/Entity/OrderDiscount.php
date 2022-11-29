<?php

namespace App\Entity;

use App\Repository\OrderDiscountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDiscountRepository::class)]
class OrderDiscount
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: 'Order', inversedBy: 'discount')]
    #[ORM\JoinColumn(name: 'uuid', referencedColumnName: 'uuid')]
    private Order $order;

    #[ORM\Column(type: 'float')]
    private float $discountValue;
    
    public function __construct(Order $order, float $discountValue)
    {
        $this->order = $order;
        $this->discountValue = $discountValue;
    }

    public function getDiscountValue(): float
    {
        return $this->discountValue;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
