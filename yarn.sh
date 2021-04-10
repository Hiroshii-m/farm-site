#!/bin/sh

yarn init
yarn add sass --dev

mkdir css js images scss
touch index.html
cd scss
touch style.scss
mkdir foundation layout object
cd foundation
touch _base.scss _reset.scss _variables.scss _mixin.scss
cd ../object
mkdir component project utility
