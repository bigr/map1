# -*- coding: utf-8 -*-

from jsdb import Jsdb 

db = Jsdb()

db.insert(U'Železný Brod',U'pokus')
db.insert(U'Havlíčkův Brod',U'pokus2')
db.insert(U'Brod nad Lesy',U'pokus2')
db.insert(U'Železná Ruda',U'pokus2')
db.insert(U'lesy Havlíčkův',U'pokus2')
db.insert(U'brod',U'pokus2')

test = db.like(U'ŽELEZ')

print db.json()
