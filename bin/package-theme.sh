#!/bin/bash

# Include useful functions
. "$(dirname "$0")/includes.sh"

# Exit if any command fails
set -e

# Change to the expected directory
cd "$(dirname "$0")"
cd ..

# Get version number from package.json
PACKAGE_VERSION=$(cat package.json \
  | grep version \
  | head -1 \
  | awk -F: '{ print $2 }' \
  | sed 's/[",]//g' \
  | tr -d '[[:space:]]')

# Make sure there are no changes in the working tree.  Release builds should be
# traceable to a particular commit and reliably reproducible.
changed=
if ! git diff --exit-code > /dev/null; then
	changed="file(s) modified"
elif ! git diff --cached --exit-code > /dev/null; then
	changed="file(s) staged"
fi
if [ ! -z "$changed" ]; then
	git status
	echo "ERROR: Cannot build theme zip with dirty working tree."
	echo "       Commit your changes and try again."
	exit 1
fi

branch="$(git rev-parse --abbrev-ref HEAD)"
if [ "$branch" != 'master' ]; then
	echo "WARNING: You should probably be running this script against the"
	echo "         'master' branch (current: '$branch')"
	echo
	sleep 2
fi

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

# Run the build
status "Installing dependencies..."
npm install
composer install

status "Creating language files..."
wp i18n make-pot . resources/languages/bigbox.pot --domain=bigbox

status "Updating Google Fonts..."
npm run generate-font-list

status "Generating build..."
npm run build

# Update version in files.
sed -i "" "s|%BIGBOX_VERSION%|${PACKAGE_VERSION}|g" style.css
sed -i "" "s|%BIGBOX_VERSION%|${PACKAGE_VERSION}|g" functions.php

# Remove any existing zip file
rm -f bigbox*.zip

# Generate the theme zip file
status "Creating archive..."
zip -r bigbox.zip \
	functions.php \
	footer.php \
	header.php \
	index.php \
	style.css \
	app \
	bootstrap \
	resources/languages/*.{po,mo,pot} \
	resources/views \
	resources/data/*.json \
	public \
	vendor/ \
	LICENSE \
	CHANGELOG.md \
	screenshot.png \
	-x *.git*

# Rename and cleanup.
unzip bigbox.zip -d bigbox && zip -r "bigbox-$PACKAGE_VERSION.zip" bigbox
rm -rf bigbox && rm -f bigbox.zip

# Reset generated files.
git reset head --hard

success "📦  Version $PACKAGE_VERSION build complete."
