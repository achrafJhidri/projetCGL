<?php declare(strict_types=1);
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;
use App\Repository\FournitureRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Fourniture
 * @package App\Entity
 * @ORM\Entity(repositoryClass=FournitureRepository::class)
 */
class Fourniture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="le nom d'une game doit être un nom valide")
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="le prix d'achat doit être > 0")
     */
    private float $buyPrice;

    /**
     * @ORM\Column (type="boolean", nullable=true)
     */
    private  bool $isPriceUpdatable = false;

    /**
     * @OneToMany (targetEntity="ProduitFourniture",mappedBy="fourniture",cascade="all")
     */
    private  $fournitureProduit;

    /**
     * @ManyToOne  (targetEntity="Gamme",inversedBy="fourniture")
     * @JoinColumn(name="gamme_id", referencedColumnName="id")
     */
    private $gamme ;

    /**
     * @return mixed
     */
    public function getGamme()
    {
        return $this->gamme;
    }

    /**
     * @param mixed $gamme
     */
    public function setGamme($gamme): void
    {
        $this->gamme = $gamme;
    }

    /**
     * Fourniture constructor.
     */
    public function __construct()
    {
        $this->fournitureProduit = new ArrayCollection();
    }




    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getBuyPrice(): float
    {
        return $this->buyPrice;
    }

    /**
     * @param float $buyPrice
     */
    public function setBuyPrice(float $buyPrice): void
    {
        $this->buyPrice = $buyPrice;
    }

    /**
     * @return bool
     */
    public function isPriceUpdatable(): bool
    {
        return $this->isPriceUpdatable;
    }

    /**
     * @param bool $isPriceUpdatable
     */
    public function setIsPriceUpdatable(bool $isPriceUpdatable): void
    {
        $this->isPriceUpdatable = $isPriceUpdatable;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getIsPriceUpdatable(): ?bool
    {
        return $this->isPriceUpdatable;
    }

    /**
     * @return Collection|ProduitFourniture[]
     */
    public function getFournitureProduit(): Collection
    {
        return $this->fournitureProduit;
    }

    public function addFournitureProduit(ProduitFourniture $fournitureProduit): void
    {
        if (!$this->fournitureProduit->contains($fournitureProduit)) {
            $this->fournitureProduit[] = $fournitureProduit;
            $fournitureProduit->setFourniture($this);
        }
    }

    public function removeFournitureProduit(ProduitFourniture $fournitureProduit): void
    {
        if ($this->fournitureProduit->removeElement($fournitureProduit)) {
            // set the owning side to null (unless already changed)
            if ($fournitureProduit->getFourniture() === $this) {
                $fournitureProduit->setFourniture(null);
            }
        }
    }
}