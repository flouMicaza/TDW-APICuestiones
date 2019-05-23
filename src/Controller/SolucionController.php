<?php
/**
 * PHP version 7.2
 * apiTDWUsers - src/Controller/SolucionController.php
 */

namespace TDW\GCuest\Controller;

use OpenApi\Annotations as OA;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Entity\Cuestion;

use TDW\GCuest\Entity\Soluciones;
use TDW\GCuest\Error;
use TDW\GCuest\Utils;

/**
 * Class SolucionController
 */
class SolucionController
{
    /** @var string ruta api gestión cuestiones  */
    public const PATH_USUARIOS = '/solutions';

    /** @var ContainerInterface $container */
    protected $container;

    /** @var \Firebase\JWT\JWT */
    protected $jwt;

    /** @var \Monolog\Logger $logger */
    protected $logger;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->jwt = $this->container->get('jwt');
        $this->logger = $this->container->get('logger');
    }


    /**
     * Summary: Returns a list of solutions based on a question ID
     *
     * @OA\Get(
     *     path        = "/solutions/{questionId}",
     *     tags        = { "Solutions" },
     *     summary     = "Returns a list of solutions based on a question ID",
     *     description = "Returns the list if solutions identified by `questionId`.",
     *     operationId = "tdw_get_solutions",
     *     @OA\Parameter(
     *          ref    = "#/components/parameters/questionId"
     *     ),
     *     security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *     @OA\Response(
     *          response    = 200,
     *          description = "Array of Solutions",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/SolutionsArray"
     *         )
     *     ),
     *     @OA\Response(
     *          response    = 401,
     *          ref         = "#/components/responses/401_Standard_Response"
     *     ),
     *     @OA\Response(
     *          response    = 403,
     *          ref         = "#/components/responses/403_Forbidden_Response"
     *     ),
     *     @OA\Response(
     *          response    = 404,
     *          ref         = "#/components/responses/404_Resource_Not_Found_Response"
     *     ),
     * 
     * )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function get(Request $request, Response $response, array $args): Response
    {
        //403 Forbidden
        if (0 === $this->jwt->user_id) {
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }

        $cuestion = Utils::getEntityManager()->getRepository(Cuestion::class)
                ->findBy(['idCuestion'=> $args['id'] ]);
        //si la cuestion no existe devuelve 409 conflict
        if($cuestion==null){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_NOT_FOUND);
        }
        //El admin y los alumonos ven todas las soluciones
        if($this->jwt ->isAdmin || !$this->jwt->isMaestro){
            $soluciones  = Utils::getEntityManager()->getRepository(Soluciones::class)
                ->findBy(['cuestionesIdcuestion'=> $args['id'] ]);
            
        }else{
            $creador = $cuestion.getCreador();
            if($creador.getId()!=$this->jwt->user_id){
                //no tiene permiso para ver esta cuestion
                return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
            }
        }
        
        //404 Si no encuentra ninguna con ese id.
        if(0===count($soluciones)){
            
            return Error::error($this->container,$request, $response, StatusCode::HTTP_NOT_FOUND);
        }
        
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => $this->jwt->user_id, 'status' => StatusCode::HTTP_OK ]
        );

        //200 
        return $response
            ->withJson(
                ['soluciones' => $soluciones],
                StatusCode::HTTP_OK // 200
            );
         //return Error::error($this->container, $request, $response, StatusCode::HTTP_NOT_IMPLEMENTED);
        }
}