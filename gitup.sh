#!/bin/sh

git add .
# コミット
git commit -m "DBへ市区町村の登録SQLとその他search.php等修正点"
git remote add origin https://github.com/Hiroshii-m/farm-site.git
git push origin main