<?php
/**
 * PHP version 7.2
 * src\Entity\PropuestaRazonamiento.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * PropuestaRazonamiento
 *
 * @ORM\Table(name="propuesta_razonamiento", indexes={@ORM\Index(name="fk_propuesta_razonamiento_soluciones1_idx", columns={"soluciones_idsoluciones"}), @ORM\Index(name="fk_propuesta_razonamiento_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class PropuestaRazonamiento
{
    /**
     * @var int
     *
     * @ORM\Column(name="idpropuesta_razonamiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpropuestaRazonamiento;

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

    /**
     * @var int
     *
     * @ORM\Column(name="usuarios_id", type="integer", nullable=false)
     */
    private $usuariosId;


}
