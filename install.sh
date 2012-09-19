#! /bin/bash
mysqladmin drop agricare_nepal
mysqladmin create agricare_nepal
mysql agricare_nepal < agricare_nepal.sql
