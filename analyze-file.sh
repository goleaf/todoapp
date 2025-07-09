#!/bin/bash

if [ -z "$1" ]; then
  echo "Usage: $0 <file_path>"
  exit 1
fi

FILE=$1

echo "Analyzing file: $FILE"
echo "==============================================="

echo "File contents:"
cat $FILE

echo "==============================================="
echo "PHP blocks:"
grep -n "@php" $FILE -A 3 -B 1

echo "==============================================="
echo "PHP open tags:"
grep -n "<?php" $FILE -A 3 -B 1

echo "Analysis completed." 