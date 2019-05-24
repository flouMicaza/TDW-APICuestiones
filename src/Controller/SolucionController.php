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
     *     description = "Returns the list if solutions related with `questionId`.",
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
         }


        /**
     * Summary: Creates a new question
     *
     * @OA\Post(
     *     path        = "/solutions",
     *     tags        = { "Solutions" },
     *     summary     = "Creates a new solution",
     *     description = "Creates a new solution",
     *     operationId = "tdw_post_solutions",
     *     @OA\RequestBody(
     *         description = "`Soluciones` properties to add to the system",
     *         required    = true,
     *         @OA\JsonContent(
     *             ref = "#/components/schemas/SolucionesData"
     *         )
     *     ),
     *     security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *     @OA\Response(
     *          response    = 201,
     *          description = "`Created`: solution created",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/Solution"
     *         )
     *     ),
     *      * @OA\Response(
     *          response    = 400,
     *          description = "`Bad Request`:insert valid data",
     *          @OA\JsonContent(
     *              ref ="#/components/schemas/Message",
     *              example = {
     *                  "code"    = 400,
     *                  "message" = "`Bad Request`: insert valid data"
     *              }
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
     *          response    = 409,
     *          description = "`Conflict`: cuestionesIdcuestion does not exist.",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/Message",
     *              example          = {
     *                   "code"      = 409,
     *                   "message"   = "`Conflict`: cuestionesIdcuestion does not exist."
     *              }
     *         )
     * )
     * )
     * @param Request $request
     * @param Response $response
     * @return Response
     */
     public function post(Request $request, Response $response): Response
    {
        if (!$this->jwt->isMaestro) {
            
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }
        $req_data = $request ->getParsedBody() ?? json_decode($request->getBody(),true);
        $entity_manager = Utils::getEntityManager();
        
        //comprobar que la cuestion existe y tengo derecho sobre ella.
        
        $cuestion = $entity_manager->
            getRepository(Cuestion::class)->
            findOneBy(['idCuestion' => $req_data['cuestionesIdcuestion']]);
        
        //la cuestion no existe
        if($cuestion===null ){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_CONFLICT);
        }
        //no tengo derecho sobre la cuestion
        if($cuestion->getCreador()!==null && $cuestion->getCreador()->getId()!==$this->jwt->user_id){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }

        $solucionIgual = $entity_manager ->getRepository(Soluciones::class)->findOneBy(['descripcion'=>$req_data['descripcion']]);
            //no pueden haber dos soluciones con la misma descripcion
            if(null!==$solucionIgual){
                return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
            }
        //si no le pasa los parametros necesarios
        if(!isset($req_data['descripcion']) || !isset($req_data['cuestionesIdcuestion'])){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
        }
        $solucion = new Soluciones(
            $req_data['descripcion'],
            $req_data['correcta'] ?? false,
            $req_data['cuestionesIdcuestion']
        );
        if(isset($req_data['correcta'])){
            if($req_data['correcta']===true){
                $solucion->setCorrecta(true);
            }
        }
        //validar que la descripcion sea unica

         $entity_manager -> persist($solucion);
        $entity_manager->flush();
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => $this->jwt->user_id, 'status' => StatusCode::HTTP_CREATED ]
        );

        //201
        return $response->withJson($solucion, StatusCode::HTTP_CREATED); // 201
    }
    /**
     * Summary: Updates a solution
     *
     * @OA\Put(
     *     path        = "/solutions/{solutionId}",
     *     tags        = { "Solutions" },
     *     summary     = "Updates a solution",
     *     description = "Updates the solution identified by `solutionsId`.",
     *     operationId = "tdw_put_solutions",
     *     @OA\Parameter(
     *          ref    = "#/components/parameters/solutionId"
     *     ),
     *     @OA\RequestBody(
     *         description = "`Solution` data to update",
     *         required    = true,
     *         @OA\JsonContent(
     *             ref = "#/components/schemas/SolucionesData"
     *         )
     *     ),
     *     security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *    
     *     @OA\Response(
     *          response    = 209,
     *          description = "`Content Returned`: solution previously existed and is now updated",
     *          @OA\JsonContent(
     *              ref = "#/components/schemas/Solution"
     *         )
     *     ),
     * @OA\Response(
     *          response    = 400,
     *          description = "`Bad Request`:insert valid data",
     *          @OA\JsonContent(
     *              ref ="#/components/schemas/Message",
     *              example = {
     *                  "code"    = 400,
     *                  "message" = "`Bad Request`: insert valid data"
     *              }
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
    public function put(Request $request, Response $response, array $args): Response
    {
        if (!$this->jwt->isMaestro) { // 403
           
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }
        $req_data
            = $request->getParsedBody()
            ?? json_decode($request->getBody(), true);
        $entity_manager = Utils::getEntityManager();

    /** @var Soluciones $solucion */
        $solucion = $entity_manager->find(Soluciones::class, $args['id']);
        
        if (null === $solucion) {    // 404
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_NOT_FOUND);
        }
        if(isset($req_data['descripcion'])){
            $solucionIgual = $entity_manager ->getRepository(Soluciones::class)->findOneBy(['descripcion'=>$req_data['descripcion']]);
            //no pueden haber dos soluciones con la misma descripcion
            if(null!==$solucionIgual){
                return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
            }
            $solucion->setDescripcion($req_data['descripcion']);
        }
        if(isset($req_data['correcta'])){
            $solucion->setCorrecta($req_data['correcta']);
        }
        $entity_manager->flush();
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => $this->jwt->user_id, 'status' => 209 ]
        );

        return $response
            ->withJson($solucion)
            ->withStatus(209, 'Content Returned');
    
    }
 /**
     * Summary: Deletes a solution
     *
     * @OA\Delete(
     *     path        = "/solutions/{solutionId}",
     *     tags        = { "Solutions" },
     *     summary     = "Deletes a solution",
     *     description = "Deletes the solution identified by `solutionId`.",
     *     operationId = "tdw_delete_solutions",
     *     parameters={
     *          { "$ref" = "#/components/parameters/solutionId" }
     *     },
     *     security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *     @OA\Response(
     *          response    = 204,
     *          description = "Solution deleted &lt;Response body is empty&gt;"
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
     *     )
     * )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
     public function delete(Request $request, Response $response, array $args): Response
    {
        //Si no es maestro no puede acceder.
        if (!$this->jwt->isMaestro) { // 403
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }

        //Busco  la cuestion con ese id. 
        $entity_manager = Utils::getEntityManager();
        $solution =  $entity_manager
                        ->find(Soluciones::class,$args['id']);
        
        //404 si no encuentra la cuestion
        if(null===$solution){
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_NOT_FOUND);
        }

        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [
                'uid' => $this->jwt->user_id,
                'status' => StatusCode::HTTP_NO_CONTENT
            ]
        );
        $entity_manager->remove($solution);
        //TODO: hacer remove de todos los razonamientos que dependen de el y las propuestas y eso
        $entity_manager->flush();
        
        //la cuestion no existe
        return $response->withStatus(StatusCode::HTTP_NO_CONTENT);  // 204
    }

    /**
     * Summary: Provides the list of HTTP supported methods
     *
     * @OA\Options(
     *     path        = "/solutions",
     *     tags        = { "Solutions" },
     *     summary     = "Provides the list of HTTP supported methods",
     *     description = "Return a `Allow` header with a comma separated list of HTTP supported methods.",
     *     operationId = "tdw_options_solutions",
     *     @OA\Response(
     *          response    = 200,
     *          description = "`Allow` header &lt;Response body is empty&gt;",
     *          @OA\Header(
     *              header      = "Allow",
     *              description = "List of HTTP supported methods",
     *              @OA\Schema(
     *                  type="string"
     *              )
     *          )
     *     )
     * )
     *
     * @OA\Options(
     *     path        = "/solutions/{solutionId}",
     *     tags        = { "Solutions" },
     *     summary     = "Provides the list of HTTP supported methods",
     *     description = "Return a `Allow` header with a comma separated list of HTTP supported methods.",
     *     operationId = "tdw_options_solutions_id",
     *     parameters={
     *          { "$ref" = "#/components/parameters/solutionId" },
     *     },
     *     @OA\Response(
     *          response    = 200,
     *          description = "`Allow` header &lt;Response body is empty&gt;",
     *          @OA\Header(
     *              header      = "Allow",
     *              description = "List of HTTP supported methods",
     *              @OA\Schema(
     *                  type="string"
     *              )
     *          )
     *     )
     * )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function options(Request $request, Response $response, array $args): Response
    {
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath()
        );

        $methods = isset($args['id'])
            ? [ 'GET', 'PUT', 'DELETE' ]
            : [ 'GET', 'POST' ];

        return $response
            ->withAddedHeader(
                'Allow',
                implode(', ', $methods)
            );
    }
}