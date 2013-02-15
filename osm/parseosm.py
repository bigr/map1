import sys
from lxml import etree

def fast_iter(source,func):	
	context = etree.iterparse(source, events=('end','start'))	
	context = iter(context)
	event, root = context.next()
	
	for event, elem in context:
		if event == 'end':
			func(elem)
		root.clear()
                
	del context


def parseelem(elem):
	print elem.tag


fast_iter(sys.stdin,parseelem);
