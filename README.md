# Neo4j Example : Spotifylike
Based on the idea of Spotify : a concrete example to understand how graph databases work, with Neo4j. 
The challenge is to create a music recommendation algorithm, using a very large database of songs (Million Song Dataset) with a graphical interface (Symfony).

**Take the time to read what I wrote here so you will understand what you do.**

# Installation procedure

## Dataset :
You can first download the list of the songs.

- Direct download: `http://static.echonest.com/millionsongsubset_full.tar.gz`

Then, extract the file :

<pre>
$> tar -xvzf millionsongsubset_full.tar.gz
$> cd MillionSongSubset/
</pre>

This is a ressource allowing us to get the list of the titles of the songs, along with many (many) data such as the bitrates of the musics or the related artists of the artist who created the music.

All of that is stored inside `.h5` files.
This file format contains a folder and file tree containing data. 
Roughly speaking, these files contain batches of data in tables (as in Excel).

_You can use the"HDFView" software to see what these files actually contain._

## Processing the .h5 files :

### 1. Congregate all the files in a single directory.

The dataset downloaded previously comes with the `.h5` files stored under multiple directories.
We store everything in the same directory to make the following scripts easier to process.

<pre>
$> find -name "*.h5" -exec cp {} ./DATASET_PROCESS/H5_FILES/ \;
</pre>

The dataset provide the data of exactly `10 000` songs.
To be sure everything is in there, execute :

<pre>
$> ls ./DATASET_PROCESS/H5_FILES/ | wc -l
</pre>

### 2. Convert .h5 files in a ASCII format text file.

A Python script allows us to extract the data from the dataset, with the information we want (title, artists related, play time etc...).
Execute `script_python_h5_to_ascii.sh` to run the script that translate `.h5` files to human-readable ASCII files.

<pre>
$> sh ./script_python_h5_to_ascii.sh
</pre>
Everything will be stored under `./DATASET_PROCESS/ASCII_FILES/`.

### 3. Convert ASCII format text file to JSON (and then CSV).

Neo4j allows to import CSV files.
But as the first script outputs only a ASCII text file, we have to format it in JSON and then in CSV.

<pre>
$> sh ./script_convert_ascii_to_json.sh
</pre>
Everything will be stored under `./DATASET_PROCESS/JSON_FILES/`.

This script as well concatenate the JSON files into a single file (in `./ALL_DATA_JSON.json`) so we will easily convert it to CSV.
