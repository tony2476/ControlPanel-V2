#!/bin/bash
sudo mysqldump -uroot -p cp2 >cp2.sql
cp cp2.sql advisor:/root/
ssh advisor mysql -ucp2 -p'uk4Hza12AZ' cp2 </root/cp2.sql
