#!/bin/sh

git add .
# コミット
git commit -m "店舗詳細ページの商品情報が表示されるようにしました。店舗詳細ページ、店舗編集ページ、店舗登録ページからMAPアイフレームを削除しました。"
git remote add origin https://github.com/Hiroshii-m/farm-site.git
git push origin main