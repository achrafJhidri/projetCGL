<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitFournitureRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProduitFourniture
 * @package App\Entity
 * @ORM\Entity( repositoryClass=ProduitFournitureRepository::class)
 */
class ProduitFourniture
{
    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="le nombre de fourniutre doit être > 0")
     */
    private $quantite;

    /**
    * @ORM\Id()
    * @ORM\ManyToOne(targetEntity="Produit", inversedBy="produitFournitures")
    * @JoinColumn(name="product_id", referencedColumnName="id")
    */
    private $product;
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Fourniture", inversedBy="fournitureProduit")
     * @JoinColumn(name="fourniture_id", referencedColumnName="id")
     */
    private Fourniture $fourniture;

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

    public function __toString()
    {
        return json_encode(["idFourniture" => $this->fourniture->getId(),"quantite"=>$this->quantite,'originalPrice'=>$this->fourniture->getBuyPrice(),'isUpdatable'=>$this->fourniture->getIsPriceUpdatable()]);
    }

}