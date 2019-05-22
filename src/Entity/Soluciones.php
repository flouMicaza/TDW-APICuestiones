<?php
/**
 * PHP version 7.2
 * src\Entity\Soluciones.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * Soluciones
 *
 * @ORM\Table(name="soluciones", indexes={@ORM\Index(name="fk_soluciones_cuestiones_idx", columns={"cuestiones_idCuestion"})})
 * @ORM\Entity
 */
class Soluciones
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsoluciones", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsoluciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=225, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="correcta", type="boolean", nullable=true)
     */
    private $correcta;

    /**
     * @var int
     *
     * @ORM\Column(name="cuestiones_idCuestion", type="integer", nullable=false)
     */
    private $cuestionesIdcuestion;


}
