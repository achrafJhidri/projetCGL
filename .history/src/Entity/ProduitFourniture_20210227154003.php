<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitFournitureRepository;

/**
 * Class ProduitFourniture
 * @package App\Entity
 * @ORM\Entity( repositoryClass=ProduitFournitureRepository::class)
 */
class ProduitFourniture
{
    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
    * @ORM\Id()
    * @ORM\ManyToOne(targetEntity="Produit", inversedBy="categoryProducts")
    * @ORM\JoinColumn(name="produit_id", referencedColumnName="id", nullable=false)
    */
    private $product;
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Fourniture", inversedBy="categoryProducts",cascade="persist")
     * @ORM\JoinColumn(name="fourniture_id", referencedColumnName="id", nullable=false)
     */
    private $fourniture;

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getFourniture()
    {
        return $this->fourniture;
    }

    /**
     * @param mixed $fourniture
     */
    public function setFourniture($fourniture): void
    {
        $this->fourniture = $fourniture;
    }

    public public function FunctionName(Type $var = null)
    {
        # code...
    }
}