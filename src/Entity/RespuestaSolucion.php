<?php
/**
 * PHP version 7.2
 * src\Entity\RespuestaSolucion.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * RespuestaSolucion
 *
 * @ORM\Table(name="respuesta_solucion", indexes={@ORM\Index(name="fk_respuesta_solucion_soluciones1_idx", columns={"soluciones_idsoluciones"}), @ORM\Index(name="fk_respuesta_solucion_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class RespuestaSolucion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrespuesta_solucion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrespuestaSolucion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="respuesta", type="boolean", nullable=true)
     */
    private $respuesta;

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
