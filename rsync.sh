#!/bin/bash
rsync -avz -e ssh --exclude="email.php" --exclude="database.php" --exclude="logs/" ~/Documents/Development/Tony-richardson/cp-v2/application/ advisor:/var/www/vhosts/cp2.advisornet.ca/application
rsync -avz -e ssh ~/Documents/Development/Tony-richardson/cp-v2/www/ advisor:/var/www/vhosts/cp2.advisornet.ca/www

