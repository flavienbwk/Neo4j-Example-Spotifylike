# API

This part describes the working of the Symfony API available in `/symfony` of this Github repository.

This API communicates with the Neo4j database. The following pattern is always returned.

With this Symfony API, you would be able to design your own application.


## API key access.

The API requires an API key to secure the access to it. Well, by default, the API key is  `a94a8fe5ccb19ba61c4c0873d391e987982fbbd3`. You need to add it inside the **header** request with the key name `x-api-key`.

Modify the API key under `/symfony/src/ApiBundle/Controller/DefaultController.php`.


## Routes

### Check if the API is reachable.
If you want to check is _reachable_, that you provided the right _API key_ and that the _connection with the database_ is successful, use the following route.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api` | GET |


In case of a **success**, you'll get the following answer :

```
{
	"error": false,
    "message": "Everything works.",
    "details": []
}
```

### Get the list of all the genres.


The first time the user connects, he will have to choose the genres he likes. So we will be able to provide the user a first list of musics he's prone to like.
This route is especially useful with the following route just below.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/genres` | GET |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "name": (string)
        },
    	{
        	"id": (int),
            "name": (string)
        },
        [...]
    ]
}
```
:information_source: Cypher command :
`MATCH (g:Genre) RETURN g`

### Get the genres the user likes.


| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/genres` | POST |

Parameters to send :

| user_id |
| :-------------: |
| _(int)_ |

```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "name": (string)
        },
    	{
        	"id": (int),
            "name": (string)
        },
        [...]
    ]
}
```

:information_source: Cypher command :
```
MATCH (u:User) WHERE ID(u)={user_id}
MATCH (u)-[:LIKES]->(g:Genre)
RETURN g
```

### Set a genre the user likes.


| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/genres/add` | POST |

Parameters to send :

| user_id | genre_id |
| :-------------: | :----: |
| _(int)_ | _(int)_ |

The genre set that the user likes is returned.

```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "name": (string)
        }
    ]
}
```

:information_source: Cypher command :
```
MATCH (g:Genre) WHERE ID(g)={genre_id}
MATCH (u:User) WHERE ID(u)={user_id}
MERGE (u)-[:LIKES]->(g)
```

### Get details of one user by its `id`.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user` | POST |

Parameters to send :

| user_id |
| :-------------: |
| _(int)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "username": (string),
            "email": (string)
        }
    ]
}
```


### Get the list of all the users.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/users` | GET |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "username": (string),
            "email": (string)
        },
    	{
        	"id": (int),
            "username": (string),
            "email": (string)
        },
        [...]
    ]
}
```
:information_source: Cypher command :
`MATCH (u:User) RETURN u`

### Create a user.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/create` | POST |

Parameters to send :

| username | password |email |
| :--------: | :--------: | :---: |
| _(string)_ | _(string)_ | _(string)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "username": (string),
            "email": (string)
        }
    ]
}
```

:information_source: The clear password will be processed by Symfony to create a true secure password inside Neo4j.


### Get details of one user by `username` and clear `password`.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/auth` | POST |

Parameters to send :

| username | password |
| :--------: | :--------: |
| _(string)_ | _(string)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "username": (string),
            "email": (string)
        }
    ]
}
```

:information_source: The clear password will be processed by Symfony to create a true secure password inside Neo4j.


### Get details of one user by its `id`.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user` | POST |

Parameters to send :

| user_id |
| :-------------: |
| _(int)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "username": (string),
            "email": (string)
        }
    ]
}
```

:information_source: Cypher command :
`MATCH (u:User) WHERE ID(u)={user_id} RETURN u`

### Get the details of one artist.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/artist` | POST |

Parameters to send :

| artist_id |
| :-------------: |
| _(string)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"artist_id": (string),
            "name": (string)
        }
    ]
}
```

:information_source: Cypher command :
`MATCH (a:Artist {artist_id: {artist_id}}) RETURN a`

### Get artist genres.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/artist/genres` | POST |

Parameters to send :

| artist_id |
| :-------------: |
| _(string)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "name": (string)
        },
    	{
        	"id": (int),
            "name": (string)
        },
    	{
        	"id": (int),
            "name": (string)
        },
        [...]
    ]
}
```

:information_source: Cypher command :
`MATCH (a:Artist {artist_id: {artist_id}})-[:HAS_GENRE]->(g:Genre) RETURN g`

### Get artist musics.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/artist/musics` | POST |

Parameters to send :

| artist_id |
| :-------------: |
| _(string)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        },
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        },
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        }
        [...]
    ]
}
```

:information_source: `duration` in second.

:information_source: Cypher command :
`MATCH (a:Artist {artist_id: {artist_id}})-[:OWNS]->(m:Music) RETURN m`


### Get music genres.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/music/genres` | POST |

Parameters to send :

| music_id |
| :-------------: |
| _(string)_ |


```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "name": (string)
        },
    	{
        	"id": (int),
            "name": (string)
        },
    	{
        	"id": (int),
            "name": (string)
        }
        [...]
    ]
}
```

:information_source: Cypher command :
```
MATCH (m:Music) WHERE ID(m)={music_id}
MATCH (m)-[:HAS_GENRE]->(g:Genre) RETURN g
```

### Set that a user like a music.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/music/like` | POST |

Parameters to send :

| user_id | music_id |
| :-----: | :---: |
| _(int)_ | _(string)_ |

Returns the music liked.

```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        }
    ]
}
```

### Set that a user dislike a music.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/music/dislike` | POST |

Parameters to send :

| user_id | music_id |
| :-----: | :---: |
| _(int)_ | _(string)_ |

Returns the music disliked.

```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        }
    ]
}
```


### Get recommandation music list for user for any genre.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/music/recommandations` | POST |

Parameters to send :

| user_id | limit |
| :-------------: | :----: |
| _(int)_ | _(int)_ |

```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        },
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        },
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        }
        [...]
    ]
}
```

### Get recommandation music list for user by `Genre`.

| Endpoint | Method |
| :-------------: |:-------------:|
| `/api/user/music/recommandations/genre` | POST |

Parameters to send :

| user_id | genre_id | limit |
| :-----: | :---: | :----: |
| _(int)_ | _(string)_ | _(int)_ |

```
{
	"error": false,
    "message": "",
    "details": [
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        },
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        },
    	{
        	"id": (int),
            "title": (string),
            "duration": (int)
        }
        [...]
    ]
}
```
