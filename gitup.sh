#!/bin/sh

git add .
# コミット
git commit -m "ブログ編集・削除機能やindex.phpのお気に入り店舗表示等修正。"
git remote add origin https://github.com/Hiroshii-m/farm-site.git
git push origin main