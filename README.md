# Neo4j Example : Spotifylike
Based on the idea of Spotify : a concrete example to understand how graph databases work, with Neo4j. 
The challenge is to create a music recommendation algorithm, using a very large database of songs (Million Song Dataset) with a graphical interface (Symfony).

# Dataset :
You can first download the list of the songs.

- Direct download: `http://static.echonest.com/millionsongsubset_full.tar.gz`

Then, extract the file :

<pre>
$> tar -xvzf millionsongsubset_full.tar.gz
$> cd MillionSongSubset/
</pre>

This is a ressource allowing us to get the list of the users, titles of the songs, along with many (many) data such as the birate of the music or the related artist of the artist who created the music.

All of that is stored inside `.h5` files.
This file format contains a folder and file tree containing data. 
Roughly speaking, these files contain batches of data in tables (as in Excel).

_You can use the"HDFView" software to see what these files actually contain._
