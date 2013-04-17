from pysqlite2 import dbapi2 as sqlite3
import sys
from PIL import Image, ImageMath,ImageChops,ImageDraw
import os.path
import os
import shutil

if os.path.isdir("highway_access/generated"):
    shutil.rmtree("highway_access/generated")
os.makedirs("highway_access/generated")



#BORDER_COLOR=(0,0,0,127)
SIZE=16


def colorize(im,color):
	alpha = im.split()[-1]	
	ret = Image.new('RGBA', (SIZE,SIZE), color)	
	ret.putalpha(alpha)	
	return ret
	
	
connection = sqlite3.connect('/home/klinger/mymap/data/tiles/sqlite/%s.%s.db' %(sys.argv[1], sys.argv[2]))
connection.enable_load_extension(True);        
cCursor = connection.cursor()
cursor = connection.cursor()

cursor.execute('''
	SELECT osm_id,highway,access,foot,ski,ice_skates,inline_skates,
			horse,vehicle,bicycle,carriage,trailer,caravan,motor_vehicle,motorcycle,
			mofa,motorcar,motorhome,psv,bus
	FROM highway WHERE COALESCE(access,foot,ski,ice_skates,inline_skates,
			horse,vehicle,bicycle,carriage,trailer,caravan,motor_vehicle,motorcycle,
			mofa,motorcar,motorhome,psv,bus,'') <> ''
''');

cCursor.execute("DROP TABLE IF EXISTS highway_access")
cCursor.execute("CREATE TABLE highway_access (osm_id INT, file TEXT)")
cCursor.close()

cols = ['access','foot','ski','ice_skates','inline_skates',
			'horse','vehicle','bicycle','carriage','trailer','caravan','motor_vehicle','motorcycle',
			'mofa','motorcar','motorhome','psv','bus']

while True:
	
	row_raw = cursor.fetchone()
	
	if not row_raw:
		break				
	
	#row = filter(lambda a: a and a != 'unknown',list(set(row_raw[1:])))

	row = {}
	for i in range(len(row_raw[2:])):
		if not row_raw[i+2]: continue;
		if row_raw[i+2] == 'unknown': continue;
		if cols[i] == 'access' and row_raw[i+2] in ['true','1','yes','designated','*','official']: continue;
		if row_raw[1] in ('footway','path') and cols[i] in ('motor_vehicle','motorcar','motorhome','motorcycle','bus','psv') and row_raw[i+2] in ['false','0','no']: continue;
		row[cols[i]] = row_raw[i+2]

	if not row:
		continue

	sizeY = (((len(row) - 1) / 2) + 1) * SIZE;
	sizeX = min(len(row),2) * SIZE;

	#print sizeX, sizeY

	im = Image.new('RGBA', (sizeX,sizeY), (255, 255, 255, 0))
	
	i = 0
	fileName = [];
	for col,access in row.items():	
		try:
			
			offsetY = SIZE * (i / 2)
			offsetX = SIZE * (i % 2)
			if access in ['true','1','yes','designated','*','official']:
				access = 'yes'		
			elif access in ['false','0','no','private','dismount']:
				access = 'no'
							
			if not os.path.isfile('highway_access/access_%s.png' % access):
				print "Unknown access: '%s'" % access
				continue						
			
			im2 = Image.open('highway_access/access_%s.png' % access	,'r')			
			im2.convert('RGBA')
			im2 = im2.resize((SIZE,SIZE),Image.ANTIALIAS)			
			im.paste(im2,(offsetX,offsetY),im2.split()[-1])		
					
			
			im3 = Image.open('highway_access/%s.png' % col,'r')
			im3.convert('RGBA')
			im3 = im3.resize((SIZE,SIZE),Image.ANTIALIAS)
			if access == 'yes':
				im3 = colorize(im3,'#ffffff')		
			im.paste(im3,(offsetX,offsetY),im3.split()[-1])
			fileName.append("%s_%s" % (access,col))
		except:
			print "Unexpected error:", sys.exc_info()[0]
		i += 1

	fileName = ";".join(fileName);
	
	if not fileName:
		continue

	iCursor = connection.cursor()
	#print "INSERT INTO highway_access (osm_id,file) VALUES ('%s','%s')" % (row_raw[0],fileName)
	iCursor.execute("INSERT INTO highway_access (osm_id,file) VALUES ('%s','%s')" % (row_raw[0],fileName))
	iCursor.close()

	im.save('highway_access/generated/%s.png' % fileName);

cursor.close()
connection.commit()
connection.close()
