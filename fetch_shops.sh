#!/usr/bin/env bash
set -euo pipefail

versions=(6.1 6.2 6.3 6.4 6.5)
base_dir="shops"
cache_dir="$HOME/.composer-docker-cache"

mkdir -p "$base_dir"
mkdir -p "$cache_dir"

for version in "${versions[@]}"; do
  target_dir="$base_dir/$version"

  echo "==============================="
  echo "Installing OXID $version"
  echo "==============================="

  rm -rf -- "$target_dir"

  case "$version" in
    6.1|6.2) composer_image="composer:2.1.5" ;;
    6.3|6.4) composer_image="composer:2.2.23" ;;
    6.5) composer_image="composer:2.7.7" ;;
    *) echo "Unknown version $version"; exit 1 ;;
  esac

  echo "Using $composer_image"

  # 1. create-project ohne install
  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$PWD:/app" \
    -v "$cache_dir:/tmp/composer-cache" \
    -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
    -w /app \
    "$composer_image" \
    sh -c "composer config --global audit.block-insecure false 2>/dev/null || true; \
      composer create-project --no-dev --ignore-platform-reqs --no-install \
      oxid-esales/oxideshop-project \"$target_dir\" \"dev-b-${version}-ce\""

  # 2. Plugins erlauben (nur bei Composer >= 2.2)
  if [[ "$version" != "6.1" && "$version" != "6.2" ]]; then
    docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$PWD:/app" \
      -v "$cache_dir:/tmp/composer-cache" \
      -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
      -w "/app/$target_dir" \
      "$composer_image" \
      composer config --no-plugins allow-plugins.oxid-esales/oxideshop-unified-namespace-generator true

    docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$PWD:/app" \
      -v "$cache_dir:/tmp/composer-cache" \
      -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
      -w "/app/$target_dir" \
      "$composer_image" \
      composer config --no-plugins allow-plugins.oxid-esales/oxideshop-composer-plugin true
  fi

  # 3. install mit Cache
  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$PWD:/app" \
    -v "$cache_dir:/tmp/composer-cache" \
    -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
    -w "/app/$target_dir" \
    "$composer_image" \
    sh -c "composer config --global audit.block-insecure false 2>/dev/null || true; \
      composer install --no-dev --ignore-platform-reqs --no-interaction --prefer-dist"

  # 4. Generate unified namespace classes (OxidEsales\Eshop\* proxies).
  # Some OXID versions don't run this automatically with --no-dev.
  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$PWD:/app" \
    -w "/app/$target_dir" \
    "$composer_image" \
    php vendor/oxid-esales/oxideshop-unified-namespace-generator/oe-eshop-unified_namespace_generator

done

echo ""
echo "All installations completed successfully."
