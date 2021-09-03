#!/bin/bash

docker run -i -t -p "80:80" -p "3306:3306" --name=basement-cms -v ${PWD}:/app mattrayner/lamp:latest-1804-php7