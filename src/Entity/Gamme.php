<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @OneToMany(targetEntity="Produit", mappedBy="gamme")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     */
    private  $products ;

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

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Produit $product
     */
    public function addProduct(Produit $product): void
    {
        $this->products[] = $product;
    }



}