#!/bin/sh

# Crear los archivos PHP
touch ./index.php
touch ./choose.php
touch ./login.php
touch ./signin.php
touch ./customer.php
touch ./admin.php
touch ./logout.php
touch ./buycar.php

# Crear los directorios
mkdir -p ./assets
mkdir -p ./templates

# Crear los archivos dentro de templates
touch ./templates/foot.php
touch ./templates/head.php
touch ./templates/nbar.php
touch ./templates/nbarc.php
touch ./templates/nbara.php
touch ./templates/all.php
touch ./templates/allc.php
touch ./templates/alla.php

echo "Archivos y directorios creados correctamente."
