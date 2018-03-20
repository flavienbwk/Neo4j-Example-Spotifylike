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
These relationships are used in the API.

Please check the API documentation in `/API.md` of this Github repository.

<p align="center">
        <img src="https://i.imgur.com/UzHJN6s.png"/>
</p>
