<?php declare(strict_types=1);


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use App\Repository\ProduitRepository;


use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;


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
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     */
    private float $sellPrice;



    /**
     *
     * @ManyToOne(targetEntity="Gamme",inversedBy="products",cascade="persist")
     * @ORM\JoinColumn (name="gamme_id", referencedColumnName="id")
     */
    private Gamme $gamme;


    /**
     * @OneToMany (targetEntity="ProduitFourniture",mappedBy="product",cascade="persist")
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
     * @param float $sellPrice
     */
    public function setSellPrice(float $sellPrice): void
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * @return Gamme
     */
    public function getGamme(): Gamme
    {
        return $this->gamme;
    }

    /**
     * @param Gamme $gamme
     */
    public function setGamme(Gamme $gamme): void
    {
//        $gamme->addProduct($this);
        $this->gamme = $gamme;
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


}