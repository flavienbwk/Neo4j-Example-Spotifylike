i=0
for file in `ls ./tools/DATASET_PROCESS/H5_FILES/`; do
    var=$file".txt"
    python ./tools/display_song.py ./tools/DATASET_PROCESS/H5_FILES/$file > ./tools/DATASET_PROCESS/ASCII_FILES/$file.txt
    i=$((i+1))
    echo $i
done
