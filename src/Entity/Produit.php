<?php declare(strict_types=1);


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use App\Repository\ProduitRepository;


use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Produit
 * @package App\Entity
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="le nom d'un produit doit être un nom valide")
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="le prix de vente doit être > 0")
     */
    private float $sellPrice;

    /**
     * @ManyToOne(targetEntity="Gamme",inversedBy="products")
     * @JoinColumn(name="gamme_id", referencedColumnName="id")
     */
    private Gamme $gamme;


    /**
     * @OneToMany (targetEntity="ProduitFourniture",mappedBy="product",cascade="all")
     */
    private $produitFournitures;

    /**
     * Produit constructor.
     */
    public function __construct()
    {
        $this->produitFournitures = new ArrayCollection();
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
     * @return float
     */
    public function getSellPrice(): float
    {
        return $this->sellPrice;
    }

    /**
     * @param  $sellPrice
     */
    public function setSellPrice($sellPrice): void
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * @return mixed
     */
    public function getProduitFournitures()
    {
        return $this->produitFournitures;
    }

    /**
     * @param Fourniture $fourniture
     */
    public function addFourniture(Fourniture  $fourniture,float $quantite): void
    {
        $produitFourniture=new ProduitFourniture();
        $produitFourniture->setQuantite($quantite);
        $produitFourniture->setFourniture($fourniture);
        $produitFourniture->setProduct($this);

        $this->produitFournitures[] = $produitFourniture;

    }

    public function getGamme(): ?Gamme
    {
        return $this->gamme;
    }

    public function setGamme(Gamme $gamme): void
    {
        $this->gamme = $gamme;
    }

    public function addProduitFourniture(ProduitFourniture $produitFourniture): void
    {
        if (!$this->produitFournitures->contains($produitFourniture)) {
            $this->produitFournitures[] = $produitFourniture;
            $produitFourniture->setProduct($this);
        }
    }

    public function removeProduitFourniture(ProduitFourniture $produitFourniture): void
    {
        if ($this->produitFournitures->removeElement($produitFourniture)) {
            // set the owning side to null (unless already changed)
            if ($produitFourniture->getProduct() === $this) {
                $produitFourniture->setProduct(null);
            }
        }
    }


}