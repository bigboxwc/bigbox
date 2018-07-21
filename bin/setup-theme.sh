#!/bin/bash

# Ensure we have access to wp-bin
git submodule update --recursive

# Include useful functions
source "$(dirname "$0")/wp-bin/wp-bin.sh"

# Exit if any command fails
set -e

# Change to the expected directory
go_to_root

# Make sure there are no changes in the working tree.  Release builds should be
# traceable to a particular commit and reliably reproducible.
check_for_clean_cwd

# Do a dry run of the repository reset. Prompting the user for a list of all
# files that will be removed should prevent them from losing important files!
reset_cwd

# Run the build
status_message "Installing dependencies..."
npm install
composer install

status_message "Creating language files..."
wp i18n make-pot . resources/languages/bigbox.pot --domain=bigbox

status_message "Updating Google Fonts..."
npm run generate-font-list

status_message "Building assets..."
npm run build
