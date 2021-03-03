<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;
use App\Repository\GammeRepository;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Class Gamme
 * @package App\Entity
 * @ORM\Entity(repositoryClass=GammeRepository::class)
 */
class Gamme
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="gamme",cascade="remove")
     */
    private  $products ;

    /**
     * @OneToMany(targetEntity="Fourniture", mappedBy="gamme",cascade="remove")
     */
    private $fournitures;

    /**
     * Gamme constructor.
     */
    public function __construct()
    {
        $this->products=new ArrayCollection();
        $this->fournitures = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return mixed
     */
    public function getFournitures()
    {
        return $this->fournitures;
    }

    /**
     * @param Fourniture $fourniture
     */
    public function addFourniture( Fourniture $fourniture): void
    {
        $this->fournitures[] = $fourniture;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Produit $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setGamme($this);
        }

        return $this;
    }

    public function removeProduct(Produit $product): void
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getGamme() === $this) {
                $product->setGamme(null);
            }
        }
    }

    public function removeFourniture(Fourniture $fourniture): void
    {
        if ($this->fournitures->removeElement($fourniture)) {
            // set the owning side to null (unless already changed)
            if ($fourniture->getGamme() === $this) {
                $fourniture->setGamme(null);
            }
        }
    }



}