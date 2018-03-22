<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use GraphAware\Neo4j\Client\ClientBuilder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;

class DefaultController extends Controller {

    private $_api_key = "a94a8fe5ccb19ba61c4c0873d391e987982fbbd3";
    private $_neo4j_client;
    private $_neo4j_stack;
    private $_error_msg;

    /**
     * @Route("/api")
     */
    public function indexAction(Request $request) {
        $check_auth = $this->checkAuth($request);
        if ($check_auth !== 1)
            return $check_auth;

        return $this->processResponse(false, "Everything works.");
    }

    /**
     * List the users.
     * 
     * @Route("/api/users")
     */
    public function usersAction(Request $request) {
        $check_auth = $this->checkAuth($request, "GET");
        if ($check_auth !== 1)
            return $check_auth;

        $users = [];
        $query = $this->queryNeo4j("MATCH (u:User) RETURN u,ID(u)");
        foreach ($query->getRecords() as $user) {
            $email = ($user->get("u")->hasValue("email")) ? $user->get("u")->value("email") : "";
            $username = ($user->get("u")->hasValue("username")) ? $user->get("u")->value("username") : "";
            array_push($users, [
                "id" => $user->value("ID(u)"),
                "email" => $email,
                "username" => $username
            ]);
        }
        return $this->processResponse(false, "", $users);
    }

    /**
     * List the genres.
     * 
     * @Route("/api/genres")
     */
    public function genresAction(Request $request) {
        $check_auth = $this->checkAuth($request, "GET");
        if ($check_auth !== 1)
            return $check_auth;

        $genres = [];
        $query = $this->queryNeo4j("MATCH (g:Genre) RETURN g.name,ID(g)");
        foreach ($query->getRecords() as $genre) {
            array_push($genres, [
                "id" => $genre->value("ID(g)"),
                "name" => ($genre->hasValue("g.name")) ? $genre->value("g.name") : ""
            ]);
        }

        return $this->processResponse(false, "", $genres);
    }

    /**
     * @Route("/api/user/genres")
     */
    public function userGenresAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null)
            return $this->processResponse(true, "User ID not received.");
        else
            $user_id = $request->request->get('user_id');

        $genres = [];
        $query = $this->queryNeo4j("MATCH (u:User) WHERE ID(u)={user_id} \n MATCH (u)-[:LIKES]->(g:Genre) \n RETURN g.name,ID(g)", [
            "user_id" => intval($user_id)
        ]);
        foreach ($query->getRecords() as $genre) {
            array_push($genres, [
                "id" => $genre->value("ID(g)"),
                "name" => ($genre->hasValue("g.name")) ? $genre->value("g.name") : ""
            ]);
        }
        return $this->processResponse(false, "", $genres);
    }

    /**
     * @Route("/api/user/genres/add")
     */
    public function userGenresAddAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null || $request->request->get('genre_id') === null)
            return $this->processResponse(true, "User ID or Genre ID not received.");
        else {
            $user_id = $request->request->get('user_id');
            $genre_id = $request->request->get('genre_id');
        }

        $genres = [];
        $query = $this->queryNeo4j("MATCH (g:Genre) WHERE ID(g)={genre_id} \n MATCH (u:User) WHERE ID(u)={user_id} \n MERGE (u)-[:LIKES]->(g) \n RETURN g,ID(g)", [
            "user_id" => intval($user_id),
            "genre_id" => intval($genre_id)
        ]);
        foreach ($query->getRecords() as $genre) {
            array_push($genres, [
                "id" => $genre->value("ID(g)"),
                "name" => ($genre->hasValue("g.name")) ? $genre->value("g.name") : ""
            ]);
        }
        return $this->processResponse(false, "", $genres);
    }

    /**
     * @Route("/api/user")
     */
    public function userAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null)
            return $this->processResponse(true, "User ID not received.");
        else
            $user_id = $request->request->get('user_id');

        $users = [];
        $query = $this->queryNeo4j("MATCH (u:User) WHERE ID(u)={user_id} \n RETURN u,ID(u)", [
            "user_id" => intval($user_id)
        ]);
        foreach ($query->getRecords() as $user) {
            $email = ($user->get("u")->hasValue("email")) ? $user->get("u")->value("email") : "";
            $username = ($user->get("u")->hasValue("username")) ? $user->get("u")->value("username") : "";
            array_push($users, [
                "id" => $user->value("ID(u)"),
                "email" => $email,
                "username" => $username
            ]);
        }
        return $this->processResponse(false, "", $users);
    }

    /**
     * @Route("/api/user/create")
     */
    public function userCreateAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('username') === null || $request->request->get('email') === null || $request->request->get('password') === null)
            return $this->processResponse(true, "User ID not received.");
        else {
            $username = $request->request->get('username');
            $email = $request->request->get('email');
            $password_raw = $request->request->get('password');

            $user = new \AppBundle\Entity\User();
            $user->setEmail($email);
            $user->setPassword($password_raw);
            $user->setUsername($username);
            $password = $encoder->encodePassword($user, $user->getPassword());
        }

        if (empty($password_raw) || empty($username) || empty($email))
            return $this->processResponse(true, "Please fill all the fields.");

        if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
            return $this->processResponse(true, "Invalid email address.");

        $users = [];

        $query_check = $this->queryNeo4j("MATCH (u:User {username: {username}, email: {email}}) \n RETURN u,ID(u)", [
            "username" => $username,
            "email" => $email
        ]);
        if (sizeof($query_check->getRecords()) != 0)
            return $this->processResponse(true, "User already exists.");

        $query = $this->queryNeo4j("CREATE (u:User {username: {username}, email: {email}, password:{password}}) \n RETURN u,ID(u)", [
            "username" => $username,
            "email" => $email,
            "password" => $password
        ]);
        foreach ($query->getRecords() as $user) {
            $email = ($user->get("u")->hasValue("email")) ? $user->get("u")->value("email") : "";
            $username = ($user->get("u")->hasValue("username")) ? $user->get("u")->value("username") : "";
            array_push($users, [
                "id" => $user->value("ID(u)"),
                "email" => $email,
                "username" => $username
            ]);
        }
        return $this->processResponse(false, "", $users);
    }

    /**
     * @Route("/api/user/auth")
     */
    public function userAuthCreateAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('username') === null || $request->request->get('password') === null)
            return $this->processResponse(true, "User ID not received.");
        else {
            $username = $request->request->get('username');
            $password_raw = $request->request->get('password');

            $user = new \AppBundle\Entity\User();
            $user->setPassword($password_raw);
            $user->setUsername($username);
            $password = $encoder->encodePassword($user, $user->getPassword());
        }

        if (empty($password_raw) || empty($username))
            return $this->processResponse(true, "Please fill all the fields.");

        $users = [];
        $query = $this->queryNeo4j("MATCH (u:User {username: {username}, password:{password}}) \n RETURN u,ID(u) LIMIT 1", [
            "username" => $username,
            "password" => $password
        ]);

        if (sizeof($query->getRecords()) == 0)
            return $this->processResponse(true, "Invalid username or password.");

        foreach ($query->getRecords() as $user) {
            $email = ($user->get("u")->hasValue("email")) ? $user->get("u")->value("email") : "";
            $username = ($user->get("u")->hasValue("username")) ? $user->get("u")->value("username") : "";
            array_push($users, [
                "id" => $user->value("ID(u)"),
                "email" => $email,
                "username" => $username
            ]);
        }

        return $this->processResponse(false, "", $users);
    }

    /**
     * @Route("/api/artist")
     */
    public function artistAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('artist_id') === null)
            return $this->processResponse(true, "Artist ID not received.");
        else
            $artist_id = $request->request->get('artist_id');

        if (is_numeric($artist_id))
            return $this->processResponse(true, "Careful, you provided an integer. But artist IDs are alphanumerical strings.");

        $artists = [];
        $query = $this->queryNeo4j("MATCH (a:Artist {artist_id:{artist_id}}) \n RETURN a", [
            "artist_id" => $artist_id
        ]);
        foreach ($query->getRecords() as $artist) {
            $artist_id_r = ($artist->get("a")->hasValue("artist_id")) ? $artist->get("a")->value("artist_id") : "";
            $name = ($artist->get("a")->hasValue("name")) ? $artist->get("a")->value("name") : "";
            array_push($artists, [
                "id" => $artist_id_r,
                "name" => $name
            ]);
        }
        return $this->processResponse(false, "", $artists);
    }

    /**
     * @Route("/api/artist/genres")
     */
    public function artistGenresAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('artist_id') === null)
            return $this->processResponse(true, "Artist ID not received.");
        else
            $artist_id = $request->request->get('artist_id');

        if (is_numeric($artist_id))
            return $this->processResponse(true, "Careful, you provided an integer. But artist IDs are alphanumerical strings.");

        $genres = [];
        $query = $this->queryNeo4j("MATCH (a:Artist {artist_id: {artist_id}})-[:HAS_GENRE]->(g:Genre) RETURN g,ID(g)", [
            "artist_id" => $artist_id
        ]);
        foreach ($query->getRecords() as $genre) {
            $name = ($genre->get("g")->hasValue("name")) ? $genre->get("g")->value("name") : "";
            array_push($genres, [
                "id" => $genre->value("ID(g)"),
                "name" => $name
            ]);
        }
        return $this->processResponse(false, "", $genres);
    }

    /**
     * @Route("/api/artist/musics")
     */
    public function artistMusicsAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('artist_id') === null)
            return $this->processResponse(true, "Artist ID not received.");
        else
            $artist_id = $request->request->get('artist_id');

        if (is_numeric($artist_id))
            return $this->processResponse(true, "Careful, you provided an integer. But artist IDs are alphanumerical strings.");

        $musics = [];
        $query = $this->queryNeo4j("MATCH (a:Artist {artist_id: {artist_id}})-[:OWNS]->(m:Music) RETURN m,ID(m)", [
            "artist_id" => $artist_id
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("m")->hasValue("title")) ? $music->get("m")->value("title") : "";
            $duration = ($music->get("m")->hasValue("duration")) ? $music->get("m")->value("duration") : "";
            array_push($musics, [
                "id" => $music->value("ID(m)"),
                "title" => $title,
                "duration" => floatval($duration)
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /**
     * @Route("/api/artist/albums")
     */
    public function artistAlbumsAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('artist_id') === null)
            return $this->processResponse(true, "Artist ID not received.");
        else
            $artist_id = $request->request->get('artist_id');

        if (is_numeric($artist_id))
            return $this->processResponse(true, "Careful, you provided an integer. But artist IDs are alphanumerical strings.");

        $albums = [];
        $query = $this->queryNeo4j("MATCH (a:Artist {artist_id: {artist_id}})-[:CREATED]->(al:Album) RETURN al,ID(al)", [
            "artist_id" => $artist_id
        ]);
        foreach ($query->getRecords() as $album) {
            $name = ($album->get("al")->hasValue("name")) ? $album->get("al")->value("name") : "";
            array_push($albums, [
                "id" => $album->value("ID(al)"),
                "name" => $name
            ]);
        }
        return $this->processResponse(false, "", $albums);
    }

    /**
     * @Route("/api/music/album")
     */
    public function musicAlbumAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('music_id') === null)
            return $this->processResponse(true, "Music ID not received.");
        else
            $music_id = $request->request->get('music_id');

        $albums = [];
        $query = $this->queryNeo4j("MATCH (m:Music) WHERE ID(m)={music_id} \n MATCH (m)-[:IN]->(al:Album) RETURN al,ID(al)", [
            "music_id" => intval($music_id)
        ]);
        foreach ($query->getRecords() as $album) {
            $name = ($album->get("al")->hasValue("name")) ? $album->get("al")->value("name") : "";
            array_push($albums, [
                "id" => $album->value("ID(al)"),
                "name" => $name
            ]);
        }
        return $this->processResponse(false, "", $albums);
    }

    /**
     * @Route("/api/music/genres")
     */
    public function musicGenresAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('music_id') === null)
            return $this->processResponse(true, "Music ID not received.");
        else
            $music_id = $request->request->get('music_id');

        $genres = [];
        $query = $this->queryNeo4j("MATCH (m:Music) WHERE ID(m)={music_id} \n MATCH (m)-[:HAS_GENRE]->(g:Genre) RETURN g,ID(g)", [
            "music_id" => intval($music_id)
        ]);
        foreach ($query->getRecords() as $genre) {
            $name = ($genre->get("g")->hasValue("name")) ? $genre->get("g")->value("name") : "";
            array_push($genres, [
                "id" => $genre->value("ID(g)"),
                "name" => $name
            ]);
        }
        return $this->processResponse(false, "", $genres);
    }

    /**
     * @Route("/api/music")
     */
    public function musicAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('music_id') === null)
            return $this->processResponse(true, "Music ID not received.");
        else
            $music_id = $request->request->get('music_id');

        $musics = [];
        $query = $this->queryNeo4j("MATCH (m:Music) WHERE ID(m)={music_id} \n "
                . "MATCH (m)-[:RELEASED_IN]->(y:Year) \n"
                . "OPTIONAL MATCH (:User)-[li:LISTENED]->(m) \n"
                . "RETURN m,y,ID(m),li.count", [
            "music_id" => intval($music_id)
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("m")->hasValue("title")) ? $music->get("m")->value("title") : "";
            $duration = ($music->get("m")->hasValue("duration")) ? $music->get("m")->value("duration") : "";
            $year = ($music->get("y")->hasValue("year")) ? $music->get("y")->value("year") : "";
            $count = (!empty($music->value("li.count")) && intval($music->value("li.count")) > 0) ? intval($music->value("li.count")) : 0;
            array_push($musics, [
                "id" => $music->value("ID(m)"),
                "title" => $title,
                "duration" => floatval($duration),
                "released_in" => intval($year),
                "count" => $count
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /**
     * @Route("/api/music/like")
     */
    public function musicLikeAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('music_id') === null || $request->request->get('user_id') === null)
            return $this->processResponse(true, "Music ID or User ID not received.");
        else {
            $music_id = $request->request->get('music_id');
            $user_id = $request->request->get('user_id');
        }

        $query_remove = $this->queryNeo4j("MATCH (u:User) WHERE ID(u)={user_id} \n"
                . "MATCH (m:Music) WHERE ID(m)={music_id} \n"
                . "MERGE (u)-[r:DISLIKES]->(m) \n"
                . "DELETE r", [
            "music_id" => intval($music_id),
            "user_id" => intval($user_id)
        ]);

        $musics = [];
        $query = $this->queryNeo4j("MATCH (u:User) WHERE ID(u)={user_id} \n"
                . "MATCH (m:Music) WHERE ID(m)={music_id} \n"
                . "MERGE (u)-[:LIKES]->(m) \n"
                . "RETURN m, ID(m)", [
            "music_id" => intval($music_id),
            "user_id" => intval($user_id)
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("m")->hasValue("title")) ? $music->get("m")->value("title") : "";
            $duration = ($music->get("m")->hasValue("duration")) ? $music->get("m")->value("duration") : "";
            array_push($musics, [
                "id" => $music->value("ID(m)"),
                "title" => $title,
                "duration" => floatval($duration)
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /**
     * @Route("/api/music/dislike")
     */
    public function musicDisikeAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('music_id') === null || $request->request->get('user_id') === null)
            return $this->processResponse(true, "Music ID or User ID not received.");
        else {
            $music_id = $request->request->get('music_id');
            $user_id = $request->request->get('user_id');
        }

        $musics = [];
        $query_remove = $this->queryNeo4j("MATCH (u:User) WHERE ID(u)={user_id} \n"
                . "MATCH (m:Music) WHERE ID(m)={music_id} \n"
                . "MERGE (u)-[r:LIKES]->(m) \n"
                . "DELETE r", [
            "music_id" => intval($music_id),
            "user_id" => intval($user_id)
        ]);

        $query = $this->queryNeo4j(
                "MATCH (u:User) WHERE ID(u)={user_id} \n"
                . "MATCH (m:Music) WHERE ID(m)={music_id} \n"
                . "MERGE (u)-[:DISLIKES]->(m) \n"
                . "RETURN m, ID(m)", [
            "music_id" => intval($music_id),
            "user_id" => intval($user_id)
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("m")->hasValue("title")) ? $music->get("m")->value("title") : "";
            $duration = ($music->get("m")->hasValue("duration")) ? $music->get("m")->value("duration") : "";
            array_push($musics, [
                "id" => $music->value("ID(m)"),
                "title" => $title,
                "duration" => floatval($duration)
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /**
     * @Route("/api/artist/similars")
     */
    public function artistSimilarsAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('artist_id') === null)
            return $this->processResponse(true, "Artist ID not received.");
        else
            $artist_id = $request->request->get('artist_id');

        if (is_numeric($artist_id))
            return $this->processResponse(true, "Careful, you provided an integer. But artist IDs are alphanumerical strings.");

        $artists = [];
        $query = $this->queryNeo4j("MATCH (a:Artist{artist_id: {artist_id}}), (g:Genre) \n"
                . "MATCH (a)-[h:HAS_GENRE]->(g)<-[hg:HAS_GENRE]-(art) \n"
                . "RETURN art", [
            "artist_id" => $artist_id
        ]);
        foreach ($query->getRecords() as $artist) {
            $artist_id_r = ($artist->get("art")->hasValue("artist_id")) ? $artist->get("art")->value("artist_id") : "";
            $name = ($artist->get("art")->hasValue("name")) ? $artist->get("art")->value("name") : "";
            if (!empty($artist_id_r) && !empty($name)) {
                array_push($artists, [
                    "id" => $artist_id_r,
                    "name" => $name
                ]);
            }
        }
        return $this->processResponse(false, "", $artists);
    }

    /**
     * @Route("/api/user/similars")
     */
    public function userSimilarsAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null)
            return $this->processResponse(true, "User ID not received.");
        else
            $user_id = $request->request->get('user_id');

        $users = [];

        $return_value = "user";
        $query_string = "MATCH (u:User) WHERE ID(u) = {user_id} \n"
                . "MATCH (m:Music) \n"
                . "MATCH (a:Artist) \n"
                . "MATCH (g:Genre) \n"
                . "MATCH (u)-[l:LIKES]->(a)<-[lik:LIKES]-(us:User) \n"
                . "MATCH (u)-[li:LIKES]->(m)<-[lu:LIKES]-(use:User) \n"
                . "MATCH (m)-[h:HAS_GENRE]->(g)<-[ha:HAS_GENRE]-(art:Artist)<-[like:LIKES]-(user:User) \n"
                . "RETURN $return_value,ID($return_value) LIMIT {limit}";
        $query = $this->queryNeo4j($query_string, [
            "user_id" => intval($user_id),
            "limit" => 20
        ]);

        $records = $query->getRecords();
        if (sizeof($records) == 0)
            return $this->processResponse(true, "No similar user.");

        foreach ($records as $user) {
            $id = $user->value("ID($return_value)");
            $email = ($user->get("$return_value")->hasValue("email")) ? $user->get("$return_value")->value("email") : "";
            $username = ($user->get("$return_value")->hasValue("username")) ? $user->get("$return_value")->value("username") : "";
            if (intval($id) != $user_id) {
                array_push($users, [
                    "id" => $id,
                    "email" => $email,
                    "username" => $username
                ]);
            }
        }

        $users = array_values(array_unique($users, SORT_REGULAR));

        return $this->processResponse(false, "", $users);
    }

    /**
     * @Route("/api/user/music/similars/genre")
     */
    public function musicSimilarsGenreAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null || $request->request->get('genre_id') === null)
            return $this->processResponse(true, "User ID or Genre ID not received.");
        else {
            $user_id = $request->request->get('user_id');
            $genre_id = $request->request->get('genre_id');
            $limit = ($request->request->get('limit') !== null) ? $request->request->get('limit') : 20;
        }

        $musics = [];
        $query = $this->queryNeo4j("MATCH (u:User) WHERE ID(u) = {user_id} \n"
                . "MATCH (g:Genre) WHERE ID(g) = {genre_id} \n"
                . "MATCH (m:Music) \n"
                . "MATCH (g)<-[h:HAS_GENRE]-(m) \n"
                . "RETURN m,ID(m) LIMIT {limit}", [
            "user_id" => intval($user_id),
            "genre_id" => intval($genre_id),
            "limit" => intval($limit)
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("m")->hasValue("title")) ? $music->get("m")->value("title") : "";
            $duration = ($music->get("m")->hasValue("duration")) ? $music->get("m")->value("duration") : "";
            array_push($musics, [
                "id" => $music->value("ID(m)"),
                "title" => $title,
                "duration" => floatval($duration)
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /**
     * @Route("/api/user/music/similars")
     */
    public function musicSimilarsAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null)
            return $this->processResponse(true, "User ID or Genre ID not received.");
        else {
            $user_id = $request->request->get('user_id');
            $limit = ($request->request->get('limit') !== null) ? $request->request->get('limit') : 20;
        }

        $musics = [];
        $query = $this->queryNeo4j("MATCH (u:User) WHERE ID(u) = {user_id} \n"
                . "MATCH (g:Genre) \n"
                . "MATCH (m:Music) \n"
                . "MATCH (u)-[l:LIKES|:LISTENED]->(m) \n"
                . "MATCH (m)-[h:HAS_GENRE]->(g)<-[hg:HAS_GENRE]-(s:Music) \n"
                . "WITH s, rand() AS number \n"
                . "RETURN ID(s), s ORDER BY number LIMIT {limit}", [
            "user_id" => intval($user_id),
            "limit" => intval($limit)
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("s")->hasValue("title")) ? $music->get("s")->value("title") : "";
            $duration = ($music->get("s")->hasValue("duration")) ? $music->get("s")->value("duration") : "";
            array_push($musics, [
                "id" => $music->value("ID(s)"),
                "title" => $title,
                "duration" => floatval($duration)
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /**
     * @Route("/api/user/music/listened	")
     */
    public function musicListenedAction(Request $request) {
        $check_auth = $this->checkAuth($request, "POST");
        if ($check_auth !== 1)
            return $check_auth;

        if ($request->request->get('user_id') === null || $request->request->get('music_id') === null)
            return $this->processResponse(true, "Music ID or User ID not received.");
        else {
            $user_id = $request->request->get('user_id');
            $music_id = $request->request->get('music_id');
            $limit = ($request->request->get('limit') !== null) ? $request->request->get('limit') : 20;
        }

        $musics = [];
        $query = $this->queryNeo4j("MATCH (u:User) WHERE ID (u) = {user_id} \n"
                . "MATCH (m:Music) WHERE ID (m) = {music_id} \n"
                . "MERGE (u)-[li:LISTENED]->(m) \n"
                . "ON CREATE SET li.count = 1 \n"
                . "ON MATCH SET li.count = li.count + 1 \n"
                . "RETURN li.count,m,ID(m)", [
            "user_id" => intval($user_id),
            "music_id" => intval($music_id),
            "limit" => intval($limit)
        ]);
        foreach ($query->getRecords() as $music) {
            $title = ($music->get("m")->hasValue("title")) ? $music->get("m")->value("title") : "";
            $duration = ($music->get("m")->hasValue("duration")) ? $music->get("m")->value("duration") : "";
            $count = (!empty($music->value("li.count")) && intval($music->value("li.count")) > 0) ? intval($music->value("li.count")) : 0;
            array_push($musics, [
                "id" => $music->value("ID(m)"),
                "title" => $title,
                "duration" => floatval($duration),
                "count" => $count
            ]);
        }
        return $this->processResponse(false, "", $musics);
    }

    /* =======================
     *  INTERN FUNCTIONS
     * =======================
     */

    private function checkAuth(Request $request, $method = false) {
        $headers = $request->headers->all();
        if (!(isset($headers["x-api-key"][0]) && $headers["x-api-key"][0] == $this->_api_key)) {
            return $this->processResponse(true, "Wrong or missing API key.");
        }

        if ($method !== false) {
            if (!$request->getSession() == $method)
                return $this->processResponse(true, "Wrong HTTP method. Expected : " . $method);
        }

        if (!$this->initNeo4j())
            return $this->processResponse(true, "The API doesn't respond.");

        return 1;
    }

    private function queryNeo4j($query, $parameters = null) {
        $result = $this->_neo4j_client->run($query, $parameters);
        return $result;
    }

    private function addQueryNeo4j($query, $parameters = null) {
        $this->_neo4j_stack->push($query, $parameters);
    }

    private function runQueriesNeo4j() {
        if (!empty($this->_neo4j_stack)) {
            $query = $this->_neo4j_client->runStack($this->_neo4j_stack);
            return $query;
        } else {
            return false;
        }
    }

    private function initNeo4j() {
        $client = ClientBuilder::create()
                ->addConnection('default', 'http://neo4j:r6F7DPsr@localhost:7474')
                ->addConnection('bolt', 'bolt://neo4j:r6F7DPsr@localhost:7687')
                ->build();

        $result = $client->run('MATCH (a:Artist) RETURN a LIMIT 1');
        $query = $result->getRecords();
        if (!empty($query)) {
            $this->_neo4j_client = $client;
            $this->_neo4j_stack = $client->stack();
            return true;
        } else {
            return false;
        }
    }

    private function processResponse($error = true, $message = "", $details = []) {
        return new JsonResponse([
            "error" => $error,
            "message" => $message,
            "details" => $details
        ]);
    }

}
