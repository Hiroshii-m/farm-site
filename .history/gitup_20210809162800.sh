#!/bin/sh

git add .
# コミット
git commit -m "20210809デザインの不具合を修正しました。"
git remote add origin https://github.com/Hiroshii-m/farm-site.git
git push origin main