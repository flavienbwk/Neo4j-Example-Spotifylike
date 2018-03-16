n=0
echo "[" > /ALL/FILES/FICHIERS_JSON/FATJSON.json
for file in `ls /ALL_FILES/FICHIERS_ASCII/`; do
    php convert_ascii_to_json.php /ALL_FILES/FICHIERS_ASCII/$file >> /ALL_FILES/FICHIERS_JSON/FATJSON.json
    n=$((n+1))
    echo $n
    echo "," >> /ALL_FILES/FICHIERS_JSON/FATJSON.json
done
echo "]" >> /ALL_FILES/FICHIERS_JSON/FATJSON.json
