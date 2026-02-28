#!/usr/bin/env bash
set -euo pipefail

# Define PHP versions to test against
versions=("7.0" "7.1" "7.2" "7.3" "7.4" "8.0" "8.1")

# Initialize a flag to track syntax errors
syntax_error_found=0

# Loop through each version and run tests for each PHP file
for version in "${versions[@]}"; do
    if [ $syntax_error_found -eq 1 ]; then
        break
    fi
    echo "Testing with PHP $version..."
    while IFS= read -r -d '' file; do
        echo "Testing the syntax of $file"
        output=$(docker run --rm -v "$PWD:/app" -w /app "php:${version}-cli" php -l "$file")
        if [[ $output == *"Errors parsing"* ]]; then
            echo "Syntax error found in $file with PHP $version: $output"
            syntax_error_found=1
            break
        fi
    done < <(find . -type f -name "*.php" ! -path "./vendor/*" ! -path "./node_modules/*" ! -path "./shops/*" -print0)
done

if [ $syntax_error_found -eq 1 ]; then
    echo "Syntax errors were found."
    exit 1
else
    echo "No syntax errors found."
fi
