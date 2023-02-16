#!/bin/bash

echo "Checking for Npm"
NPM_CMD=$(which npm)
if [[ "" == "$NPM_CMD" ]]
then
   echo "No npm found"
else
  echo "Running Npm Commands"
  NPM_OUTDATED=$(npm outdated --json)

  if [ -f npm_package_versions.json ]
  then
    rm npm_package_versions.json
  fi
  touch npm_package_versions.json
  echo $NPM_OUTDATED > npm_package_versions.json
  echo "Composer Outdated File Creation Completed"
fi

# Remove the 'npm_package_versions.json' file from the 'app_versions' folder if it exists
if [ -f "app_versions/npm_package_versions.json" ]; then
  rm app_versions/npm_package_versions.json
fi

# Move the 'npm_package_versions.json' file to the 'app_versions' folder if it exists
if [ -f "npm_package_versions.json" ]; then
  mv npm_package_versions.json app_versions
fi

if [ "" == "$NPM_CMD" ]
then
  echo "Versions Generation Not Possible"
else
  NODE_VERSION=$(node -v)
  NPM_VERSION=$(npm -v)
  cd app_versions

  if [ -f current_versions.json ]
  then
    rm current_versions.json
  fi
  touch current_versions.json
  printf "{\n \"node\": \"%s\",\n \"npm\": \"%s\"}" $NODE_VERSION $NPM_VERSION  > current_versions.json
  echo "Versions File Creation Completed"
fi

# Get latest version of node and npm
if [ "" == "$NPM_CMD" ]
then
  echo "Versions Generation Not Possible"
else
  NODE_LATEST=$(npm info node version)
  NPM_LATEST=$(npm info npm version)
  arr=($COMPOSER_VERSION)

  if [ -f latest_versions.json ]
  then
    rm latest_versions.json
  fi
  touch latest_versions.json
  printf "{\n \"node\": \"%s\",\n \"npm\": \"%s\"\n}" $NODE_LATEST $NPM_LATEST > latest_versions.json
  echo "Latest Versions File Creation Completed"
fi


