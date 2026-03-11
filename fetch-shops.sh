#!/usr/bin/env bash
set -euo pipefail

# Supported OXID versions.
# Uses indexed array (not declare -A) for bash 3.2 compatibility (macOS default).
versions=(6.1 6.2 6.3 6.4 6.5)

base_dir="shops"
cache_dir="$PWD/.composer-docker-cache"
home_dir="$PWD/.composer-docker-home"

mkdir -p "$base_dir" "$cache_dir" "$home_dir"

# Runs a Composer command in Docker with shared cache and home directories.
# Uses --user to avoid root-owned output files (no sudo needed).
# Requires $composer_image to be set by the caller.
docker_run() {
    local workdir="$1"; shift
    docker run --rm \
        --user "$(id -u):$(id -g)" \
        -v "$PWD:/app" \
        -v "$cache_dir:/tmp/composer-cache" \
        -v "$home_dir:/tmp/composer-home" \
        -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
        -e COMPOSER_HOME=/tmp/composer-home \
        -w "$workdir" \
        "$composer_image" \
        "$@"
}

for version in "${versions[@]}"; do
    target_dir="$base_dir/$version"

    if [ -d "$target_dir/vendor" ]; then
        echo "Skipping OXID $version – already installed"
        continue
    fi

    echo "==============================="
    echo "Installing OXID $version"
    echo "==============================="

    # Pinned Composer images per OXID version ensure reproducible installs and
    # avoid running a modern Composer (with audit) against old OXID packages.
    case "$version" in
        6.1|6.2) composer_image="composer:2.1.5"  ;;
        6.3|6.4) composer_image="composer:2.2.23" ;;
        6.5)     composer_image="composer:2.7.7"  ;;
        *)       echo "Unknown version: $version"; exit 1 ;;
    esac

    echo "Using $composer_image"

    # Step 1: Create project skeleton without installing dependencies yet.
    docker_run /app \
        composer create-project \
            --no-dev --no-install --ignore-platform-reqs \
            oxid-esales/oxideshop-project \
            "$target_dir" \
            "dev-b-${version}-ce"

    # Step 2: Allow required OXID plugins.
    # The allow-plugins security feature was introduced in Composer 2.2.
    # Composer 2.1.x (OXID 6.1/6.2) accepts plugins without explicit approval.
    if [[ "$version" != "6.1" && "$version" != "6.2" ]]; then
        docker_run "/app/$target_dir" \
            composer config --no-plugins \
                allow-plugins.oxid-esales/oxideshop-unified-namespace-generator true
        docker_run "/app/$target_dir" \
            composer config --no-plugins \
                allow-plugins.oxid-esales/oxideshop-composer-plugin true
    fi

    # Step 3: Install all dependencies.
    docker_run "/app/$target_dir" \
        composer install \
            --no-dev --no-interaction --ignore-platform-reqs --prefer-dist

    # Step 4: Generate OxidEsales\Eshop\* proxy classes required for phpstan.
    # Some OXID versions skip this step automatically when --no-dev is used.
    docker_run "/app/$target_dir" \
        php vendor/oxid-esales/oxideshop-unified-namespace-generator/oe-eshop-unified_namespace_generator

done

echo ""
echo "All installations completed successfully."