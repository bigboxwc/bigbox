#!/bin/bash

# Include useful functions
. "$(dirname "$0")/includes.sh"

# Exit if any command fails
set -e

# Change to the expected directory
cd "$(dirname "$0")"
cd ..

status "
.______    __    _______ .______     ______   ___   ___
|   _  \  |  |  /  _____||   _  \   /  __  \  \  \ /  /
|  |_)  | |  | |  |  __  |  |_)  | |  |  |  |  \  V  /
|   _  <  |  | |  | |_ | |   _  <  |  |  |  |   >   <
|  |_)  | |  | |  |__| | |  |_)  | |  \`--'  |  /  .  \
|______/  |__|  \______| |______/   \______/  /__/ \__\\";

# Remove ignored files to reset repository to pristine condition. Previous test
# ensures that changed files abort the plugin build.
status "Cleaning working directory..."
git clean -xdf

status "Installing Node modules..."
npm install

status "Installing PHP dependencies..."
composer install 

status "Generating .pot file..."
wp i18n make-pot . resources/languages/bigbox.pot --domain=bigbox

status "Generating Google Fonts..."
npm run generate-font-list

status "Building and watching assets..."
npm run dev
