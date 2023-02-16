#!/bin/bash

echo "Checking for Composer"
COMPOSER_CMD=$(which composer)
if [[ "" == "$COMPOSER_CMD" ]]
then
 echo "No composer found"
else
 echo "Running Composer Commands"
 COMPOSER_OUTDATED=$(composer outdated -f json)
 COMPOSER_VERSION=$(composer --version)
 arr=($COMPOSER_VERSION)

 if [ -f composer_package_versions.json ]
 then
  rm composer_package_versions.json
 fi
 touch composer_package_versions.json

 printf "{\n \"package_details\": \n%s\n,\n \"composer_version\": \"%s\"\n}\n" "$COMPOSER_OUTDATED" "${arr[2]}" > composer_package_versions.json
 echo "Composer Outdated File Creation Completed"
fi

# Remove the 'npm_package_versions.json' file from the 'app_versions' folder if it exists
if [ -f "app_versions/composer_package_versions.json" ]; then
  rm app_versions/composer_package_versions.json
fi

# Move the 'npm_package_versions.json' file to the 'app_versions' folder if it exists
if [ -f "composer_package_versions.json" ]; then
  mv composer_package_versions.json app_versions
fi
