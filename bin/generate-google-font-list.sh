#!/bin/bash

# Include useful functions
. "$(dirname "$0")/includes.sh"

DATA=$(curl "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBmZBJAajbmRv6fSyfN3Dh5iz5XkWqYjDs")

echo ${DATA} | jq '.items | map({family, category, variants, subsets})' > "./resources/data/google-fonts.json"
