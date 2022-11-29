<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $uuid;

    #[ORM\OneToOne(targetEntity: 'OrderDiscount', mappedBy: 'order', cascade: ['persist'])]
    private OrderDiscount $discount;

    #[ORM\OneToOne(targetEntity: 'OrderTax', mappedBy: 'order', cascade: ['persist'])]
    private OrderTax $tax;
    
    private function __construct()
    {
        $this->uuid = uniqid();
    }
    
    public static function fromValues(float $tax, float $discount)
    {
        $instance = new self();
        $instance->tax = new OrderTax($instance, $tax);
        $instance->discount = new OrderDiscount($instance, $discount);
                
        return $instance;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    public function getTax(): OrderTax
    {
        return $this->tax;
    }

    public function getDiscount(): OrderDiscount
    {
        return $this->discount;
    }
}
