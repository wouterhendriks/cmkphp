#!/bin/bash

IFS=$'\n'

clear

echo "------------------------"
echo "🚀 TODO's 🚀"
echo "------------------------"

# Iterate over files in the current directory

FILES=`find ./ -name '*.php' | grep -v vendor`

for FILE in $FILES; do
   for LINE in `grep -rnH TODO $FILE`; do
      echo "👉 $LINE"
   done
done

echo "------------------------"
