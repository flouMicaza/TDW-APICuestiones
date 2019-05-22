<?php
/**
 * PHP version 7.2
 * src\Entity\Razonamiento.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * Razonamiento
 *
 * @ORM\Table(name="razonamiento", indexes={@ORM\Index(name="fk_razonamiento_soluciones1_idx", columns={"soluciones_idsoluciones"})})
 * @ORM\Entity
 */
class Razonamiento
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrazonamiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrazonamiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=225, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="justificado", type="boolean", nullable=true)
     */
    private $justificado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="error", type="string", length=225, nullable=true)
     */
    private $error;

    /**
     * @var int
     *
     * @ORM\Column(name="soluciones_idsoluciones", type="integer", nullable=false)
     */
    private $solucionesIdsoluciones;


}
