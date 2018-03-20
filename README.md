# Neo4j Example : Spotifylike
Based on the idea of Spotify : a concrete example to understand how graph databases work, with Neo4j. 
The challenge is to create a music recommendation algorithm, using a very large database of songs (Million Song Dataset) with a graphical interface (Symfony).

**Take the time to read what I wrote here so you will understand what you do.**

# Formatting the data for Neo4j

Datasets are a bunch of data in a certain form, but we have to convert them to match what Neo4j wants to ingest.

## Dataset :
You can first download the data list of the songs. Then, extract it.

<pre>
$> wget http://static.echonest.com/millionsongsubset_full.tar.gz
$> tar -xvzf millionsongsubset_full.tar.gz
</pre>

This will create a `./MillionSongSubset` directory.
This is a ressource allowing us to get the list of the titles of the songs, along with many (many) data such as the bitrates of the musics or the related artists of the artist who created the music.

Each data of a song is stored inside its `.h5` file.
This file format contains a folder and file tree containing data. 
Roughly speaking, these files contain batches of data in tables (as in Excel).

_You can use the"HDFView" software to see what these files actually contain._

## Processing the .h5 files :

### 1. Congregate all the files in a single directory.

The dataset downloaded previously comes with the `.h5` files stored under multiple directories.
We store everything in the same directory to make the following scripts easier to process.

<pre>
$> find -name "*.h5" -exec cp {} ../tools/DATASET_PROCESS/H5_FILES/ \;
</pre>

The dataset provides the data of exactly `10 000` songs.
To be sure everything is in there, execute :

<pre>
$> ls ./tools/DATASET_PROCESS/H5_FILES/ | wc -l
</pre>

### 2. Convert .h5 files in a ASCII format text file.

A Python script allows us to extract the data from the dataset, with the information we want (title, artists related, play time etc...).
Execute `h5_to_ascii.sh` to run the script that translate `.h5` files to human-readable ASCII files.

<pre>
$> sh ./tools/h5_to_ascii.sh
</pre>
Everything will be stored under `./tools/DATASET_PROCESS/ASCII_FILES/`.

### 3. Convert ASCII format text file to JSON (and then CSV).

Neo4j allows to import CSV files.
But as the first script outputs only a ASCII text file, we have to format it in JSON and then in CSV.

:warning: This script is experimental. You might experience an invalid JSON file as some songs have no title or special characters.
<pre>
$> sh ./tools/ascii_to_json.sh
</pre>
Everything will be stored under `./tools/DATASET_PROCESS/JSON_FILES/`.

This script as well concatenate the JSON files into a single file **(in `./tools/DATASET_PROCESS/JSON_FILES/ALL_DATA_JSON.json`)** so we will easily convert it to CSV.

### 4. Convert JSON to CSV.

To convert the JSON we've outputed to CSV, we use an excellent website :
- `https://codebeautify.org/json-to-csv`

Click the "Browse" button, select `./ALL_DATA_JSON.json` and click "Download".

Don't forget to add the file on your server with the name : `ALL_DATA_CSV.csv`.

### 5. Get the list of the artist IDs in a single CSV file.

Get these files we've compiled inside :
<pre>
./data/processed/artists_ids.csv
./data/processed/genres.csv
</pre>

We've stepped into several problems while importing the csv data with our first algorithm.
So to have a cleaner and slimmer import, we had to list the artists IDs in a single node to then link the _similar artists_ of a music, to the music.
Same thing for the genres.

**Here are the steps to get the artist IDs:**

Inside the downloaded song list directory : (by default `./MillionSongSubset/`), is a file named `./MillionSongSubset/subset_artist_term.db`.
This file is a SQLite database file.

We've just browsed this database with the [SQLite browser](http://sqlitebrowser.org/) and used the function "export", selecting only the `artist_id` column.

<hr/>

# Installing Neo4j

You can follow [this official tutorial](https://neo4j.com/docs/operations-manual/current/installation/linux/debian/) to install Neo4j for your Debian machine.

## Configuration of Neo4j :

Inside `/etc/neo4j/neo4j.conf` :
<pre>
# Uncomment :
dbms.security.auth_enabled=false
dbms.security.allow_csv_import_from_file_urls=true

# Comment :
#dbms.directories.import=/var/lib/neo4j/import
</pre>

Restart Neo4j :
<pre>
$> service neo4j restart
</pre>

# Fill the database :

All the queries below are written in _Cypher_.
_Cypher_ is to _Neo4j_ what _SQL_ is to _MySQL_.

Access your browser instance of Neo4j with the following link.
Replace _localhost_ by your IP address if it is necessary.

<pre>
http://localhost:7474/browser
</pre>

Just before continuing, we have to increase the limit of 300 nodes display for Neo4j using this command in the Neo4j console :
Change `1000` by the number you want. But careful : it may make your browser crash.
<pre>
:config initialNodeDisplay: 1000
</pre>

## Import the *artists_id.csv* file.

Replace */home/user* by the absolute file where you've cloned this git repository.
<pre>
LOAD CSV WITH HEADERS FROM "file:/home/user/Neo4j-Example-Spotifylike/data/processed/artists_id.csv" AS csvLine
CREATE (a:Artist { artist_id: csvLine.artist_id })
</pre>

## Import the *genres.csv* file.

Replace */home/user* by the absolute file where you've cloned this git repository.
<pre>
LOAD CSV WITH HEADERS FROM "file:/home/user/Neo4j-Example-Spotifylike/data/processed/genres.csv" AS csvLine
CREATE (g:Genre { name: csvLine.mbtag })
</pre>

## Linking artists' gender to artists.

For this, we will use the `./data/processed/artist_genre.csv` file.

Replace */home/user* by the absolute file where you've cloned this git repository.
<pre>
LOAD CSV WITH HEADERS FROM "file:/artist_genre.csv" AS csvLine
MATCH (a:Artist {artist_id:csvLine.artist_id}), (g:Genre {name: csvLine.mbtag})
MERGE (a)-[:HAS_GENRE]->(g)
</pre>

## Import the songs data.

Well, it is not just about importing the song list. The fact is that each music has a "similar_artists" property, which is really heavy and will overload our server for no reason.
To fix this, we will use the `Artist` nodes, and add a relation : `music OWNED_BY artist`. 

<pre>
LOAD CSV WITH HEADERS FROM "file:/ALL_DATA_CSV.csv" AS csvLine

// Creating the music node.
MERGE (m:Music {title: csvLine.title, duration: csvLine.duration})
WITH m, csvLine
MATCH (a:Artist {artist_id: csvLine.artist_id})
MERGE (a)-[:OWNS]->(m)
SET a.name = csvLine.artist_name

MERGE (y:Year {year: csvLine.year})
MERGE (m)-[:RELEASED_IN]->(y)

MERGE (al:Album {name: csvLine.album})
MERGE (m)-[:IN]->(al)
MERGE (a)-[:CREATED]->(al)

WITH a, m, csvLine

UNWIND split(csvLine.all_terms, ',') as genre_instance
MATCH (g:Genre {name: genre_instance})
MERGE (m)-[:HAS_GENRE]->(g)

WITH a, m, csvLine

UNWIND split(csvLine.similar_artists, ',') as asi
MATCH (as:Artist {artist_id: asi})
MERGE (a)-[:SIMILAR_TO]->(as)

RETURN count(*)

// LIMIT 5; // Limit the query if you computer is not really powerful.
</pre>

:information_source: You might experience some problems while importing a large quantity of data. 
Use the following command at the beginning of the previous command to make it work. It will persist the data every `50` entity processed.
<pre>
USING PERIODIC COMMIT 50
</pre>

:information_source: You might experience bugs of memory while importing the data. In `/etc/neo4j/neo4j.conf`, uncomment and modify the following line.
<pre>
dbms.memory.heap.max_size=1024m
</pre>

<p align="center">
	<img src="https://i.imgur.com/UzHJN6s.png"/>
</p>
