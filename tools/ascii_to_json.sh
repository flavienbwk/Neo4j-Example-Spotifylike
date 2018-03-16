i=0
echo "[" > ./tools/DATASET_PROCESS/JSON_FILES/ALL_DATA_JSON.json
for file in `ls ./tools/DATASET_PROCESS/ASCII_FILES/`; do
    result=$(php ./tools/convert_ascii_to_json.php ./tools/DATASET_PROCESS/ASCII_FILES/$file)
    if [ ! -z "$result" ] && [ "$result" != "{}" ]; then
    	if [ $i != 0 ]; then
		echo "," >> ./tools/DATASET_PROCESS/JSON_FILES/ALL_DATA_JSON.json
	fi
	echo $result >> ./tools/DATASET_PROCESS/JSON_FILES/ALL_DATA_JSON.json
    else
	echo "Empty or invalid file. "
    fi
    i=$((i+1))
    echo $i
done
echo "]" >> ./tools/DATASET_PROCESS/JSON_FILES/ALL_DATA_JSON.json
