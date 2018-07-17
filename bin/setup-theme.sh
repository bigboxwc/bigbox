#!/bin/bash

# Include useful functions
. "$(dirname "$0")/includes.sh"

# Exit if any command fails
set -e

# Change to the expected directory
cd "$(dirname "$0")"
cd ..

# Do a dry run of the repository reset. Prompting the user for a list of all
# files that will be removed should prevent them from losing important files!
status "Resetting the repository to pristine condition."
git clean -xdf --dry-run
warning "About to delete everything above! Is this okay?"
echo -n "[Y]es/[N]o: "
read answer
if [ "$answer" != "${answer#[Yy]}" ]; then
	# Remove ignored files to reset repository to pristine condition. Previous
	# test ensures that changed files abort the plugin build.
	status "Cleaning working directory..."
	git clean -xdf
else
	error "Aborting."
	exit 1
fi

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
