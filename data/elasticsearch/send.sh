#!/bin/bash
format=json
config_dir=$(pwd)/*
for dir in $config_dir
do
if [ -d "$dir" ]
then
index_name=${dir##*/}
curl -i \
        -H "Accept: application/json" \
        -H "Content-Type:application/json" \
        -X POST -d "" "https://elastic.dev.pdn.kz/$index_name/_close"
json_files=$dir/*
for file in $json_files
do
if [ -f $file ] && [ -r "$file" ] && [ -s "$file" ] && [ -O "$file" ] && [ "${file}" != "${file%.${format}}" ]
then
value=`cat $file`
file_name=${file##*/}
type_name=$(echo $file_name| cut -d'-' -f 1)
type_config=$(echo $file_name| cut -d'-' -f 2| cut -d '.' -f 1)
if [ $type_config = "analysis" ]
then
curl -i \
        -H "Accept: application/json" \
        -H "Content-Type:application/json" \
        -X PUT -d "$value" "https://elastic.dev.pdn.kz/$index_name/_settings"
elif [ $type_config = "mapping" ]
then
curl -i \
        -H "Accept: application/json" \
        -H "Content-Type:application/json" \
        -X PUT -d "$value" "https://elastic.dev.pdn.kz/$index_name/_mapping/$type_name"
fi
fi
done
curl -i \
        -H "Accept: application/json" \
        -H "Content-Type:application/json" \
        -X POST -d "" "https://elastic.dev.pdn.kz/$index_name/_open"
fi
done