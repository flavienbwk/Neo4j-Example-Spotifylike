<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not__profiler_home;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', '_profiler_home'));
                    }

                    return $ret;
                }
                not__profiler_home:

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler_open_file
                if ('/_profiler/open' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:openAction',  '_route' => '_profiler_open_file',);
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        elseif (0 === strpos($pathinfo, '/api')) {
            // api_default_index
            if ('/api' === $pathinfo) {
                return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::indexAction',  '_route' => 'api_default_index',);
            }

            if (0 === strpos($pathinfo, '/api/user')) {
                // api_default_users
                if ('/api/users' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::usersAction',  '_route' => 'api_default_users',);
                }

                if (0 === strpos($pathinfo, '/api/user/genres')) {
                    // api_default_usergenres
                    if ('/api/user/genres' === $pathinfo) {
                        return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::userGenresAction',  '_route' => 'api_default_usergenres',);
                    }

                    // api_default_usergenresadd
                    if ('/api/user/genres/add' === $pathinfo) {
                        return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::userGenresAddAction',  '_route' => 'api_default_usergenresadd',);
                    }

                }

                // api_default_user
                if ('/api/user' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::userAction',  '_route' => 'api_default_user',);
                }

                // api_default_usercreate
                if ('/api/user/create' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::userCreateAction',  '_route' => 'api_default_usercreate',);
                }

                // api_default_userauthcreate
                if ('/api/user/auth' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::userAuthCreateAction',  '_route' => 'api_default_userauthcreate',);
                }

                // api_default_usersimilars
                if ('/api/user/similars' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::userSimilarsAction',  '_route' => 'api_default_usersimilars',);
                }

                if (0 === strpos($pathinfo, '/api/user/music/similars')) {
                    // api_default_musicsimilarsgenre
                    if ('/api/user/music/similars/genre' === $pathinfo) {
                        return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicSimilarsGenreAction',  '_route' => 'api_default_musicsimilarsgenre',);
                    }

                    // api_default_musicsimilars
                    if ('/api/user/music/similars' === $pathinfo) {
                        return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicSimilarsAction',  '_route' => 'api_default_musicsimilars',);
                    }

                }

                // api_default_musiclistened
                if ('/api/user/music/listened' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicListenedAction',  '_route' => 'api_default_musiclistened',);
                }

            }

            // api_default_genres
            if ('/api/genres' === $pathinfo) {
                return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::genresAction',  '_route' => 'api_default_genres',);
            }

            if (0 === strpos($pathinfo, '/api/artist')) {
                // api_default_artist
                if ('/api/artist' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::artistAction',  '_route' => 'api_default_artist',);
                }

                // api_default_artistgenres
                if ('/api/artist/genres' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::artistGenresAction',  '_route' => 'api_default_artistgenres',);
                }

                // api_default_artistmusics
                if ('/api/artist/musics' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::artistMusicsAction',  '_route' => 'api_default_artistmusics',);
                }

                // api_default_artistalbums
                if ('/api/artist/albums' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::artistAlbumsAction',  '_route' => 'api_default_artistalbums',);
                }

                // api_default_artistsimilars
                if ('/api/artist/similars' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::artistSimilarsAction',  '_route' => 'api_default_artistsimilars',);
                }

            }

            elseif (0 === strpos($pathinfo, '/api/music')) {
                // api_default_musicalbum
                if ('/api/music/album' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicAlbumAction',  '_route' => 'api_default_musicalbum',);
                }

                // api_default_musicgenres
                if ('/api/music/genres' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicGenresAction',  '_route' => 'api_default_musicgenres',);
                }

                // api_default_music
                if ('/api/music' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicAction',  '_route' => 'api_default_music',);
                }

                // api_default_musiclike
                if ('/api/music/like' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicLikeAction',  '_route' => 'api_default_musiclike',);
                }

                // api_default_musicdisike
                if ('/api/music/dislike' === $pathinfo) {
                    return array (  '_controller' => 'ApiBundle\\Controller\\DefaultController::musicDisikeAction',  '_route' => 'api_default_musicdisike',);
                }

            }

        }

        // dashboard
        if ('/dashboard' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\DashboardController::indexAction',  '_route' => 'dashboard',);
        }

        // homepage
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_homepage;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'homepage'));
            }

            return $ret;
        }
        not_homepage:

        // login
        if ('/login' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\LoginController::loginAction',  '_route' => 'login',);
        }

        // logout
        if ('/logout' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\LoginController::logoutAction',  '_route' => 'logout',);
        }

        // register
        if ('/register' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\RegisterController::registerAction',  '_route' => 'register',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
