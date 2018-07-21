#!/bin/bash

# Include useful functions
source "$(dirname "$0")/wp-bin/wp-bin.sh"

DATA=$(download "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBmZBJAajbmRv6fSyfN3Dh5iz5XkWqYjDs")

echo ${DATA} | jq '.items | map({family, category, variants, subsets})' > "./resources/data/google-fonts.json"
