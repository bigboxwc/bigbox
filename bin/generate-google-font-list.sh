#!/bin/bash

# Include useful functions
source "$(dirname "$0")/wp-bin/wp-bin.sh"

read -s -p "Enter your Google Fonts API key: " key

if [ "$key" ]
then
	DATA=$(download "https://www.googleapis.com/webfonts/v1/webfonts?key=$key")
	echo ${DATA} | jq '.items | map({family, category, variants, subsets})' > "./resources/data/google-fonts.json"
fi
