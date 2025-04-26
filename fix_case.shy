#!/bin/bash

echo "Scanning and renaming all folders and files to lowercase..."

find . -depth | while read path; do
    newpath=$(dirname "$path")/$(basename "$path" | tr 'A-Z' 'a-z')
    if [ "$path" != "$newpath" ]; then
        echo "Renaming: $path -> $newpath"
        mv "$path" "$newpath"
    fi
done

echo "Done renaming."

echo "Reinstalling composer dependencies..."
rm -rf vendor/
composer install

echo "Clearing Laravel caches..."
php artisan config:clear
php artisan route:clear
php artisan cache:clear

echo "Showing Laravel routes..."
php artisan route:list

echo "All done!"

