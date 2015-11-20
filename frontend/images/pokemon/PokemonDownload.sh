#! /bin/bash\

cd /Volumes/Hitachi\ HDD/Downloads/Pokemon

for x in {001..151}
do
    A=$( printf '%03d' $x )
	echo 'Starting download of $A .png'
    url="http://assets2.pokemon.com/assets/cms2/img/pokedex/detail/$A.png"
	wget $url
	echo $url
done
echo 'Downloads completed'