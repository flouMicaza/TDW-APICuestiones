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
class RespuestaSolucion implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrespuesta_solucion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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

    /**
     * RespuestaSolucion constructor.
     *
     * @param bool $respuesta
     * @param int  $solucionesIdsolucion
     * @param int  $usuariosId
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(
        bool $respuesta,
        int $solucionesIdsolucion,
        int $usuariosId
    ) {
        $this->idrespuestaSolucion = 0;
        $this->respuesta = $respuesta;

        $this->solucionesIdsolucion = $solucionesIdsolucion;
        $this->usuariosId = $usuariosId;
    }
     /**
     * @return int
     */
    public function getIdRespuestaSolucion(){
        return $this->idrespuestaSolucion;
    }
    /**
     * @return bool
     */
    public function getRespuesta(){
        return $this->respuesta;
    }
    /**
     * @return int
     */
    public function getIdSolucion(){
        return $this->solucionesIdsolucion;
    }
    /**
     * @return int
     */
    public function getIdUsuario(){
        return $this->usuariosId;
    }
    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString()
    {
        return '[ respuestaSolucion ' .
            '(idRespuestaSolucion=' . $this->getIdRespuestaSolucion() . ', ' .
            'respuesta=' . (int) $this->getRespuesta() . ', ' .
            'solucionesIdsolucion=' . (int)$this->getIdSolucion() . ', ' .

            'usuariosId=' . (int)$this->getIdUsuario() . ', ' .
            ') ]';
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'respuestaSolucion' => [
                'idRespuestaSolucion' => $this->getIdRespuestaSolucion(),
                'respuesta' => $this->getRespuesta(),
                'solucionesIdsolucion' => $this->getIdRespuestaSolucion(),
                'usuariosId' => $this->getIdUsuario()
            ]
        ];
    }
}
/**
 * RespuestaSolucion definition
 *
 * @OA\Schema(
 *     schema = "RespuestaSolucion",
 *     type   = "object",
 *     required = { "descripcion","cuestionesIdcuestion", "usuariosId"},
 *     
 *     @OA\Property(
 *          property    = "idRespuestaSolucion",
 *          description = "Respuesta solucion id",
 *          type        = "integer"
 *      ),

 *      @OA\Property(
 *          property    = "respuesta",
 *          description = "Denotes if respuesta de solucion is correct",
 *          type        = "boolean"
 *      ),

 *      @OA\Property(
 *          property    = "solucionesIdsoluciones",
 *          description = "respuesta solucion parent solution",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 * @OA\Property(
 *          property    = "usuariosId",
 *          description = "user who created respuesta solucion",
 *          format      = "int64",
 *          type        = "integer"
 *      )
 * )
 *      
 *      example = {
 *              "idRespuestaSolucion" = 3,
 *              "respuesta"  = true,
 *              "solucionesIdsoluciones" = 7,
 *              "usuariosId" = 3
 *          }
 *     
 * )
 */

 /**
 * RespuestaSolucionData definition
 *
 * @OA\Schema(
 *     schema = "RespuestaSolucionData",
 *     type   = "object",
 *     required = { "descripcion","cuestionesIdcuestion"},
 *     
 *    
 *      @OA\Property(
 *          property    = "descripcion",
 *          description = "Respuesta solucion description",
 *          type        = "string"
 *      ),
 * @OA\Property(
 *          property    = "correcta",
 *          description = "Respuesta solucion correcta",
 *          type        = "boolean"

 *      ),
 *  *      @OA\Property(
 *          property    = "error",
 *          description = "Respuesta solucion error",
 *          type        = "string"
 *      ),

 * @OA\Property(
 *          property    = "cuestionesIdcuestion",
 *          description = "respuesta solucion parent solution",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 * 
 * )
 *      
 *      example = {
 *              
 *              "descripcion" = "Solution description",
 *              "correcta"  = true,
 *              "error" = "Corrección del maestro",
 *              "solucionesIdSolucion" = 5
 *          }
 *     
 * )
 */

 /**
 * RespuestaSolucion array definition
 *
 * @OA\Schema(
 *     schema           = "RespuestaSolucionArray",
 *     @OA\Property(
 *          property    = "respuestaSolucion",
 *          description = "RespuestaSolucion array",
 *          type        = "array",
 *          @OA\Items(
 *              ref     = "#/components/schemas/RespuestaSolucion"
 *          )
 *     )
 * )
 */