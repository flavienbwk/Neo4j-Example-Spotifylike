# Procedures

This file describes the different features of the website application.
We focus on the algorithm that decides which music the user will enjoy most.
As such, design is not a priority and the purpose of this git directory is to help you understand graph databases with Neo4j, on a concrete example.

- Register/Login system.
	As soon as you register, a MUID (music identifier) is attributed to the profile of the user so we can track which songs he likes or not.

- Dashboard.
	The first time the user connects, he will have to select the genres he likes.
	When accessing the dashboard, a list of music appears according to its tastes and the user has to select one.

- Music browser.
	When clicking on a music while visiting its dashboard, the user will see the "Music browser".
	This browser allows him whether to like or dislike a music, and see the actual song playing.

# Relations

Nodes have relationships, as for example for users.
Theses relationships are expressed in Cypher-like so everybody can understand.

## Users relationships

> (user)-[:LIKES]->(music) # User likes music.

> (user)-[:DLIKE]->(music) # User does not like music.

> (user)-[:PLAYED {count:129}]->(music) # User has played X times the music (129 in this case).

> (user)-[:LIKES]->(artist) # User likes artist.

> (user)-[:LIKES]->(genre) # User likes genre.

> (user)-[:DLIKE]->(genre) # User doesn't like genre.
