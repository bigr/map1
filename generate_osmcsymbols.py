from psycopg2 import *
import sys
from PIL import Image, ImageMath,ImageChops,ImageDraw
import os.path
import os
import shutil

if os.path.isdir("osmcsymbol/generated/%s" % sys.argv[1]):
    shutil.rmtree("osmcsymbol/generated/%s" % sys.argv[1]);
os.makedirs("osmcsymbol/generated/%s" % sys.argv[1]);


COLORS = {
	'white': '#ffffff',
	'red':'#dd0000',
	'green':'#008000',
	'blue':'#0000bb',
	'yellow':'#e7c500',
	'orange':'#E77B00',
	'black':'#272727',
	'brown':'#963011',	
	'purple':'#5819B5',
	'mtb':'#e7c500',
	'gray':'#777777',
}

BORDER_COLOR=(0,0,0,127)
SIZE=14


SHAPE_DEFAULT_COLORS = {
	'shell' : 'yellow',
	'shell_modern' : 'yellow',
	'heart' : 'red',
	'wolfshook' : 'white',
}

def colorize(im,color):
	alpha = im.split()[-1]	
	ret = Image.new('RGBA', (SIZE,SIZE), color)	
	ret.putalpha(alpha)	
	return ret
	
	
    
    
connection = connect("dbname='" + sys.argv[1] + "' user='klinger' password='' port=5432");
cCursor = connection.cursor()
cursor = connection.cursor()

cursor.execute('''
	SELECT osm_id,osmcsymbol0,osmcsymbol1,osmcsymbol2,osmcsymbol3,osmcsymbol4,osmcsymbol5,osmcsymbol6,osmcsymbol7
	FROM routes WHERE COALESCE(osmcsymbol0,osmcsymbol1,osmcsymbol2,osmcsymbol3,osmcsymbol4,osmcsymbol5,osmcsymbol6,osmcsymbol7,'') <> ''
''');

cCursor.execute("DROP TABLE IF EXISTS osmcsymbols")
cCursor.execute("CREATE TABLE osmcsymbols (osm_id INT, file TEXT)")
cCursor.close()

while True:
	
	row_raw = cursor.fetchone()
	
	if not row_raw:
		break				
	
	row = map(lambda a: map(lambda b: b.split('_'),a.split(':')[1:]),filter(lambda a: a and 'mtb' not in a,list(set(row_raw[1:]))))

	if not row:
		continue

	sizeY = (((len(row) - 1) / 2) + 1) * SIZE;
	sizeX = min(len(row),2) * SIZE;

	#print sizeX, sizeY

	im = Image.new('RGBA', (sizeX,sizeY), (255, 255, 255, 0))
	
	

	i = 0
	for sym in row:		
		offsetY = SIZE * (i / 2)
		offsetX = SIZE * (i % 2)
		i += 1
		for part in sym[:4]:
			if not part or len(part) == 1 and part[0].strip() == '': continue;			
			shape = "_".join(part).strip()
			color = SHAPE_DEFAULT_COLORS[shape] if shape in SHAPE_DEFAULT_COLORS else 'black'
			if not os.path.isfile('osmcsymbol/%s.png' % shape):				
				shape = "_".join(part[1:]).strip()
				if shape == '':
					shape = 'full'
				color = part[0].strip()				
				if color not in COLORS:					
					print "not found color: %s" % "_".join(part)
					continue									
				if not os.path.isfile('osmcsymbol/%s.png' % shape):
					print "not found shape: %s" % "_".join(part)
					continue;
			im2 = Image.open('osmcsymbol/%s.png' % shape,'r')	
			im2.convert('RGBA')
			im2 = im2.resize((SIZE,SIZE),Image.ANTIALIAS)
			im2 = colorize(im2,COLORS[color])
			draw = ImageDraw.Draw(im2)
			draw.line((0, 0,0,SIZE-1), fill=BORDER_COLOR)
			draw.line((SIZE-1, 0,SIZE-1,SIZE-1), fill=BORDER_COLOR)
			draw.line((0, 0,SIZE-1,0), fill=BORDER_COLOR)
			draw.line((0, SIZE-1,SIZE-1,SIZE-1), fill=BORDER_COLOR)			
			im.paste(im2,(offsetX,offsetY),im2.split()[-1])

	fileName = ";".join(filter(lambda a: a,row_raw[1:]));

	iCursor = connection.cursor()
	iCursor.execute("INSERT INTO osmcsymbols (osm_id,file) VALUES ('%s','%s/%s')" % (row_raw[0],sys.argv[1],fileName))
	iCursor.close()
	
	
	im.save('osmcsymbol/generated/%s/%s.png' % (sys.argv[1],fileName));

cursor.close()
connection.commit()
