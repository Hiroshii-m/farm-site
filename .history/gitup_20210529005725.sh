#!/bin/sh

git add .
# コミット
git commit -m "サーバーへアップロードしてからの調整等"
git remote add origin https://github.com/Hiroshii-m/farm-site.git
git push origin main