<?php
/**
 * PHP version 7.2
 * src\routes.php
 */

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use TDW\GCuest\Controller\CuestionController;
use TDW\GCuest\Controller\LoginController;
use TDW\GCuest\Controller\UsuarioController;
use TDW\GCuest\Controller\SolucionController;

use TDW\GCuest\Controller\PropuestaSolucionController;

/**
 * @var \Slim\App $app
 */
$app->get(
    '/',
    function (Request $request, Response $response): Response {
        // Log message
        $this->get('logger')->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => 0, 'status' => StatusCode::HTTP_MOVED_PERMANENTLY ]
        );

        // Redirect index view
        return $response
            ->withRedirect('/api-docs/index.html');
    }
);

/**
 * POST /login
 */
$app->post(
    $_ENV['RUTA_LOGIN'],
    LoginController::class . ':post'
)->setName('tdw_post_login');

/**
 * ############################################################
 * Usuario routes
 * ############################################################
 */

// CGET: Returns all users
$app->get(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS,
    UsuarioController::class . ':cget'
)->setName('tdw_cget_users');

// GET: Returns a user based on a single ID
$app->get(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS . '/{id:[0-9]+}',
    UsuarioController::class . ':get'
)->setName('tdw_get_users');

// GET: Returns status code 204 if username exists
$app->get(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS . '/username/{username:[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\.-]+}',
    UsuarioController::class . ':getUsername'
)->setName('tdw_get_user_name');

// DELETE: Deletes a user
$app->delete(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS . '/{id:[0-9]+}',
    UsuarioController::class . ':delete'
)->setName('tdw_delete_users');

// OPTIONS: Provides the list of HTTP supported methods
$app->options(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS . '[/{id:[0-9]+}]',
    UsuarioController::class . ':options'
)->setName('tdw_options_users');

// POST: Creates a new user
$app->post(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS,
    UsuarioController::class . ':post'
)->setName('tdw_post_users');

// PUT: Updates a user
$app->put(
    $_ENV['RUTA_API'] . UsuarioController::PATH_USUARIOS . '/{id:[0-9]+}',
    UsuarioController::class . ':put'
)->setName('tdw_put_users');

/**
 * ############################################################
 * Cuestion routes
 * ############################################################
 */

// CGET: Returns all questions
$app->get(
    $_ENV['RUTA_API'] . '/questions',
    CuestionController::class . ':cget'
)->setName('tdw_cget_questions');

// GET: Returns a question based on a single ID
$app->get(
    $_ENV['RUTA_API'] . '/questions/{id:[0-9]+}',
    CuestionController::class . ':get'
)->setName('tdw_get_questions');

// DELETE: Deletes a question
$app->delete(
    $_ENV['RUTA_API'] . '/questions/{id:[0-9]+}',
    CuestionController::class . ':delete'
)->setName('tdw_delete_questions');

// OPTIONS: Provides the list of HTTP supported methods
$app->options(
    $_ENV['RUTA_API'] . '/questions[/{id:[0-9]+}]',
    CuestionController::class . ':options'
)->setName('tdw_options_questions');

// POST: Creates a new question
$app->post(
    $_ENV['RUTA_API'] . '/questions',
    CuestionController::class . ':post'
)->setName('tdw_post_questions');

// PUT: Updates a question
$app->put(
    $_ENV['RUTA_API'] . '/questions/{id:[0-9]+}',
    CuestionController::class . ':put'
)->setName('tdw_put_questions');



/**
 * ############################################################
 * Solucion routes
 * ############################################################
 */

 $app ->get(
     $_ENV['RUTA_API'] . '/solutions/{id:[0-9]+}',
     SolucionController::class . ':get'
 )->setName('tdw_get_solutions');

 // POST: Creates a new solution
$app->post(
    $_ENV['RUTA_API'] . '/solutions',
    SolucionController::class . ':post'
)->setName('tdw_post_solutions');

 // PUT: Updates a question
$app->put(
    $_ENV['RUTA_API'] . '/solutions/{id:[0-9]+}',
    SolucionController::class . ':put'
)->setName('tdw_put_solutions');
// OPTIONS: Provides the list of HTTP supported methods
$app->options(
    $_ENV['RUTA_API'] . '/solutions[/{id:[0-9]+}]',
    SolucionController::class . ':options'
)->setName('tdw_options_solutions');
// DELETE: Deletes a question
$app->delete(
    $_ENV['RUTA_API'] . '/solutions/{id:[0-9]+}',
    SolucionController::class . ':delete'
)->setName('tdw_delete_solutions');


/**
 * ############################################################
 * propuestaSolucion routes
 * ############################################################
*/
// POST: Creates a new propuestaSolucion
$app->post(
    $_ENV['RUTA_API'] . PropuestaSolucionController::PATH_PROPUESTASOLUCION,
    PropuestaSolucionController::class . ':post'
)->setName('tdw_post_propuestaSolucion');
$app->get(
    $_ENV[RUTA_API]. PropuestaSolucionController::PATH_PROPUESTASOLUCION.'/{idu:[0-9]+}/{idc:[0-9]+}',
    PropuestaSolucionController::class . ':get'
)->setName('tdw_get_propuestaSolucion');
$app->put(
    $_ENV[RUTA_API]. PropuestaSolucionController::PATH_PROPUESTASOLUCION.'/{id:[0-9]+}',
    PropuestaSolucionController::class . ':put'
)->setName('tdw_put_propuestaSolucion');