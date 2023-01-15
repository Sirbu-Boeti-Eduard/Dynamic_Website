#!/bin/bash

echo $(python3 /home/parallels/web_scraping/scraping.py)
echo $(mariadb -u root -peduard17 -e "use Nyaa; source /home/parallels/web_scraping/mariadb_script;")

