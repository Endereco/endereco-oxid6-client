#!/usr/bin/env bash
set -euo pipefail

versions=(6.2 6.3 6.4 6.5)
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
    6.2) composer_image="composer:2.1.5" ;;
    6.3|6.4) composer_image="composer:2.2.23" ;;
    6.5) composer_image="composer:2.7.7" ;;
    *) echo "Unknown version $version"; exit 1 ;;
  esac

  echo "Using $composer_image"

  # 1. create-project ohne install
  docker run --rm \
    -v "$PWD:/app" \
    -v "$cache_dir:/tmp/composer-cache" \
    -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
    -w /app \
    "$composer_image" \
    composer create-project --no-dev --ignore-platform-reqs --no-install \
      oxid-esales/oxideshop-project "$target_dir" "dev-b-${version}-ce"

  # 2. Plugins erlauben (nur bei Composer >= 2.2)
  if [[ "$version" != "6.2" ]]; then
    docker run --rm \
      -v "$PWD:/app" \
      -v "$cache_dir:/tmp/composer-cache" \
      -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
      -w "/app/$target_dir" \
      "$composer_image" \
      composer config --no-plugins allow-plugins.oxid-esales/oxideshop-unified-namespace-generator true

    docker run --rm \
      -v "$PWD:/app" \
      -v "$cache_dir:/tmp/composer-cache" \
      -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
      -w "/app/$target_dir" \
      "$composer_image" \
      composer config --no-plugins allow-plugins.oxid-esales/oxideshop-composer-plugin true
  fi

  # 3. install mit Cache
  docker run --rm \
    -v "$PWD:/app" \
    -v "$cache_dir:/tmp/composer-cache" \
    -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
    -w "/app/$target_dir" \
    "$composer_image" \
    composer install --no-dev --ignore-platform-reqs --no-interaction --prefer-dist

done

# Rechte korrigieren
if command -v sudo >/dev/null 2>&1; then
  if [[ "${EUID:-$(id -u)}" -ne 0 ]]; then
    sudo chown -R "$(id -u):$(id -g)" "$base_dir"
  fi
fi

echo ""
echo "All installations completed successfully."