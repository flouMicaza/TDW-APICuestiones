<?php
/**
 * PHP version 7.2
 * src\Entity\RespuestaRazonamiento.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * RespuestaRazonamiento
 *
 * @ORM\Table(name="respuesta_razonamiento", indexes={@ORM\Index(name="fk_respuesta_razonamiento_usuarios1_idx", columns={"usuarios_id"}), @ORM\Index(name="fk_respuesta_razonamiento_razonamiento1_idx", columns={"razonamiento_idrazonamiento"})})
 * @ORM\Entity
 */
class RespuestaRazonamiento
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrespuesta_razonamiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrespuestaRazonamiento;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="respuesta", type="boolean", nullable=true)
     */
    private $respuesta;

    /**
     * @var int
     *
     * @ORM\Column(name="usuarios_id", type="integer", nullable=false)
     */
    private $usuariosId;

    /**
     * @var int
     *
     * @ORM\Column(name="razonamiento_idrazonamiento", type="integer", nullable=false)
     */
    private $razonamientoIdrazonamiento;


}
