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
class Soluciones implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsoluciones", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idSoluciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=225, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(
     * name="correcta",
     * type="boolean",
     * options={ "default"=false })
     */
    private $correcta;

    /**
     * @var int
     *
     * @ORM\Column(name="cuestiones_idCuestion", type="integer", nullable=false)
     */
    private $cuestionesIdcuestion;
    
        /**
     * Cuestion constructor.
     *
     * @param string  $descripcion
     * @param bool $correcta
     * @param int  $cuestionesIdcuestion
     *
     * @throws \Doctrine\ORM\ORMException
     */
        public function __construct(
        string $descripcion,
        bool $correcta,
        int $cuestionesIdcuestion
    ) {
        $this->idSoluciones = 0;
        $this->descripcion = $descripcion;
        $this->cuestionIdcuestion = $cuestionesIdcuestion;
    }

    public function getIdSolucion(){
        return $this->idSoluciones;
    }
    public function getDescription(){
        return $this->descripcion;
    }
    public function isCorrecta(){
        return $this->correcta;
    }
    public function getIdCuestion(){
        return $this->cuestionesIdcuestion;
    }
        /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString()
    {
        return '[ cuestion ' .
            '(idSoluciones=' . $this->getIdSolucion() . ', ' .
            'descripcion="' . $this->getDescription() . '", ' .
            'correcta=' . (int) $this->isCorrecta() . ', ' .
            'cuestionesIdcuestion=' . (int)$this->getIdCuestion() . ', ' .
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
            'soluciones' => [
                'idsoluciones' => $this->getIdSolucion(),
                'descripcion' => $this->getDescription(),
                'correcta' => $this->isCorrecta(),
                'cuestionesIdcuestion' => $this->getIdCuestion(),
            ]
        ];
    }

}
/**
 * Solution definition
 *
 * @OA\Schema(
 *     schema = "Solution",
 *     type   = "object",
 *     required = { "idSoluciones" },
 *     @OA\Property(
 *          property    = "idSoluciones",
 *          description = "Soluciones Id",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 *      @OA\Property(
 *          property    = "descripcion",
 *          description = "Soluciones description",
 *          type        = "string"
 *      ),
 *      @OA\Property(
 *          property    = "correcta",
 *          description = "Denotes if solution is correct",
 *          type        = "boolean"
 *      ),
 *      @OA\Property(
 *          property    = "cuestionesIdcuestion",
 *          description = "Solutions parent question",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 *      
 *      example = {
 *          "solucion" = {
 *              "idSoluciones"           = 805,
 *              "descripcion" = "Solution description",
 *              "correcta"  = true,
 *              "cuestionesIdcuestion"              = 7
 *          }
 *     }
 * )
 */
/**
 * Solution array definition
 *
 * @OA\Schema(
 *     schema           = "SolutionsArray",
 *     @OA\Property(
 *          property    = "soluciones",
 *          description = "Solutions array",
 *          type        = "array",
 *          @OA\Items(
 *              ref     = "#/components/schemas/Solution"
 *          )
 *     )
 * )
 */