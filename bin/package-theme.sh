#!/bin/bash

# Include useful functions
source "$(dirname "$0")/wp-bin/wp-bin.sh"

# Exit if any command fails
set -e

# Change to the expected directory
go_to_root

PACKAGE_NAME="bigbox"
PACKAGE_VERSION=$(get_package_version_number)
PACKAGE_VERSION_PLACEHOLDER="BIGBOX_VERSION"

# Setup theme
source "$(dirname "$0")/setup-theme.sh"

# Update version in files.
sed -i "" "s|%${PACKAGE_VERSION_PLACEHOLDER}%|${PACKAGE_VERSION}|g" style.css
sed -i "" "s|%${PACKAGE_VERSION_PLACEHOLDER}%|${PACKAGE_VERSION}|g" functions.php

# Generate the theme zip file
status_message "Creating archive..."
zip -r $PACKAGE_NAME.zip \
	functions.php \
	footer.php \
	header.php \
	index.php \
	style.css \
	app \
	bootstrap \
	resources/**/*.{php,scss,json,po,mo,pot} \ # Excludes .js, .md, .svg, .png, .jpg
	public \
	vendor/ \
	LICENSE \
	CHANGELOG.md \
	screenshot.png \
	-x *.git*

# Rename and cleanup.
rezip_with_version $PACKAGE_NAME $PACKAGE_VERSION

# Reset generated files.
git reset head --hard

success_message "📦 Version $PACKAGE_VERSION build complete."
