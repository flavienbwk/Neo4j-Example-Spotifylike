<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    private static $declaredRoutes;

    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
        if (null === self::$declaredRoutes) {
            self::$declaredRoutes = array(
        '_wdt' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:toolbarAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    1 =>     array (      0 => 'text',      1 => '/_wdt',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_home' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:homeAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_search' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:searchAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/search',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_search_bar' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:searchBarAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/search_bar',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_phpinfo' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/phpinfo',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_search_results' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:searchResultsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/search/results',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_open_file' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:openAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/open',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:panelAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    1 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_router' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.router:panelAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/router',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_exception' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.exception:showAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/exception',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_exception_css' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.exception:cssAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/exception.css',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_twig_error_test' => array (  0 =>   array (    0 => 'code',    1 => '_format',  ),  1 =>   array (    '_controller' => 'twig.controller.preview_error:previewErrorPageAction',    '_format' => 'html',  ),  2 =>   array (    'code' => '\\d+',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => '[^/]++',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '\\d+',      3 => 'code',    ),    2 =>     array (      0 => 'text',      1 => '/_error',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_index' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_users' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::usersAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_genres' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::genresAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/genres',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_usergenres' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::userGenresAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/genres',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_usergenresadd' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::userGenresAddAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/genres/add',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_user' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::userAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_usercreate' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::userCreateAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/create',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_userauthcreate' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::userAuthCreateAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/auth',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_artist' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::artistAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/artist',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_artistgenres' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::artistGenresAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/artist/genres',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_artistmusics' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::artistMusicsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/artist/musics',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_artistalbums' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::artistAlbumsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/artist/albums',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musicalbum' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicAlbumAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/music/album',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musicgenres' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicGenresAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/music/genres',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_music' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/music',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musiclike' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicLikeAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/music/like',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musicdisike' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicDisikeAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/music/dislike',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_artistsimilars' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::artistSimilarsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/artist/similars',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_usersimilars' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::userSimilarsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/similars',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musicsimilarsgenre' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicSimilarsGenreAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/music/similars/genre',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musicsimilars' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicSimilarsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/music/similars',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_default_musiclistened' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'ApiBundle\\Controller\\DefaultController::musicListenedAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/user/music/listened',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'dashboard' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'AppBundle\\Controller\\DashboardController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/dashboard',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'homepage' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'login' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'AppBundle\\Controller\\LoginController::loginAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/login',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'logout' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'AppBundle\\Controller\\LoginController::logoutAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/logout',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'register' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'AppBundle\\Controller\\RegisterController::registerAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/register',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
    );
        }
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens, $hostTokens, $requiredSchemes) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }
}
