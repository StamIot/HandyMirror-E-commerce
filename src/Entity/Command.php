<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\CommandItems;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CommandRepository::class)]
class Command
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\Column]
    private ?float $deliveryTax = null;

    #[ORM\ManyToOne(inversedBy: 'commands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'command', targetEntity: CommandItems::class)]
    private Collection $commandItems;

    public function __construct()
    {
        $this->commandItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getDeliveryTax(): ?float
    {
        return $this->deliveryTax;
    }

    public function setDeliveryTax(float $deliveryTax): static
    {
        $this->deliveryTax = $deliveryTax;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, CommandItems>
     */
    public function getCommandItems(): Collection
    {
        return $this->commandItems;
    }

    public function addCommandItem(CommandItems $commandItem): static
    {
        if (!$this->commandItems->contains($commandItem)) {
            $this->commandItems->add($commandItem);
            $commandItem->setCommand($this);
        }

        return $this;
    }

    public function removeCommandItem(CommandItems $commandItem): static
    {
        if ($this->commandItems->removeElement($commandItem)) {
            // set the owning side to null (unless already changed)
            if ($commandItem->getCommand() === $this) {
                $commandItem->setCommand(null);
            }
        }

        return $this;
    }
}
