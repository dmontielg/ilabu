for i in *.jpg; do convert $i -resize 346x230 thumb-$i; done
for i in *.jpg; do convert $i -resize 375x250 375-$i; done
for i in *.jpg; do convert $i -resize 480x320 480-$i; done
for i in *.jpg; do convert $i -resize 1600x1066 1600-$i; done
