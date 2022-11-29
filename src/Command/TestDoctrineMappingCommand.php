<?php

namespace App\Command;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-doctrine-mapping',
    description: 'Add a short description for your command',
)]
class TestDoctrineMappingCommand extends Command
{
    private EntityManagerInterface $em;
  
    public function __construct(EntityManagerInterface $em)
    {   
        $this->em = $em;
        parent::__construct();
    }
  
    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $order = Order::fromValues(25, 10);
        $uuid = $order->getUuid();
        $this->em->persist($order);
        $this->em->flush();
        
        $this->em->clear();
        
        $repository = $this->em->getRepository(Order::class);
        /** @var Order $order */
        $order = $repository->find($uuid);

        $output->writeln($order->getUuid());
        $output->writeln("{$order->getDiscount()->getOrder()->getUuid()}, discount: {$order->getDiscount()->getDiscountValue()}");
        $output->writeln("{$order->getTax()->getOrder()->getUuid()}, tax: {$order->getTax()->getTaxValue()}");

        return Command::SUCCESS;
    }
}
