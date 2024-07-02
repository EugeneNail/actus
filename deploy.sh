#!/bin/bash

function execute_pipe() {
    local commands=("$@")

    for command in "${commands[@]}"; do
        echo -e "\033[1;33m[ $command ]\033[0m"
        if ! eval "$command" ; then
            return 1
        fi
    done
}

commands=(
    "git pull origin main"
    "composer install"
    "composer dump-autoload"
    "npm install"
    "npm run build"
    "php artisan optimize:clear"
    "php artisan migrate"
    "php artisan serve --host=$(hostname -I | awk '{print $1}')"
)

execute_pipe "${commands[@]}"
