<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;
use App\Repository\GammeRepository;
use Doctrine\ORM\Mapping\OneToMany;
use function Sodium\add;

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
     * @ORM\OneToMany(targetEntity="Produit",mappedBy="gamme")
     */
    private  $products ;

    /**
     * @OneToMany(targetEntity="Fourniture", mappedBy="gamme")
     */
    private $fournitures;

    /**
     * @return Collection
     */
    public function getProducts() : Collection
    {
        return $this->products;
    }

    /**
     * @param Collection $products
     */
    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }
    public function addProduct (Produit  $produit) : void
    {
        if (!$this->products->contains($produit)) {
            $this->products[] = $produit;
            $produit->setGamme($this);
        }
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
     * Gamme constructor.
     */
    public function __construct()
    {
        $this->products=new ArrayCollection();
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





}