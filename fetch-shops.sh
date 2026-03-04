#!/bin/bash

# Versions to be installed with their corresponding Composer versions
declare -A versions=( ["6.1"]="2" ["6.2"]="2" ["6.3"]="2" ["6.4"]="2" ["6.5"]="2" )


# Loop through each version and set up the projects
for version in "${!versions[@]}"
do
    # Determine which Composer version to use based on the version
    composer_version="${versions[$version]}"

    # Target directory for each project
    TARGET_DIR="shops/$version"

    # Remove the existing directory and recreate it
    rm -rf "$TARGET_DIR"
    mkdir -p "$TARGET_DIR"

    # Use Docker to run Composer for each project version.
    # Insecure package blocking is disabled because these old OXID
    # versions depend on packages with known advisories (smarty,
    # composer). These installs are only used as phpstan stubs.
    docker run --rm \
        -v $(pwd):/app \
        -w /app \
        composer:$composer_version \
        sh -c "composer config --global audit.block-insecure false && composer config --global allow-plugins true && composer create-project --no-dev --no-audit --ignore-platform-reqs oxid-esales/oxideshop-project /app/$TARGET_DIR dev-b-$version-ce"

    # Generate unified namespace classes (OxidEsales\Eshop\* proxies).
    # Some OXID versions don't run this automatically with --no-dev.
    docker run --rm \
        -v $(pwd):/app \
        -w /app/$TARGET_DIR \
        composer:$composer_version \
        php vendor/oxid-esales/oxideshop-unified-namespace-generator/oe-eshop-unified_namespace_generator
done

# Change the owner of the shops directory to the user who ran the script
sudo chown -R $(whoami) shops/
