#!/bin/sh

git add .
# コミット
git commit -m "カードの商品部分を表示。お気に入り店舗一覧を更新"
git remote add origin https://github.com/Hiroshii-m/farm-site.git
git push origin main