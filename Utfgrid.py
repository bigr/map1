# This Python file uses the following encoding: utf-8
import json
import time
import numpy

class Utfgrid:
	
	def __init__(self):
		
		self.resultGrid = None
		self.gridKeys = []
		self.gridData = {}
		self.keyIndex = {}
		self.maxKey = -1		
		self.decodeCache = {}		
		

	def addLayer( self, layer ):		
		layer = json.loads(layer)				
		gridSize = len(layer['grid'])
		
		if self.resultGrid == None:
			self.resultGrid = numpy.empty(shape=(gridSize,gridSize),dtype=int)
			self.resultGrid.fill(-1)				
	
		keys = layer['keys']				
		
		keyRemap = {}
		remapedKeys = {}
		remapMaxKey = self.maxKey
		emptyKey = 0
		i = 0
		for k in keys:
			if k == "":
				emptyKey = i
			elif k in self.keyIndex:
				remapMaxKey += 1
				keyRemap[str(k)] = str(remapMaxKey)
			
			i += 1
		
		emptyKey = self.encodeId(emptyKey)		
		addedKeys = {}				
		chunksCount = 32
		chunkSize = gridSize/chunksCount				
		t = time.clock();	
		try:
			emptyChunk = numpy.empty(gridSize/chunksCount,dtype=str)
			emptyChunk.fill(emptyKey)
			grid = numpy.array(layer['grid'])
		except UnicodeEncodeError:
			emptyChunk = numpy.empty(gridSize/chunksCount,dtype=unicode)
			emptyChunk.fill(emptyKey)
			grid = numpy.array(layer['grid'],dtype=unicode)
			
		keyPairRemap = {}		
		for y in xrange(gridSize):			
			line = grid[y]
			for chunk in xrange(0,chunksCount):				
				if line[chunk*chunkSize:(chunk+1)*chunkSize] == emptyChunk:				
					continue;
				for x in xrange(chunk*chunkSize,(chunk+1)*chunkSize):								
					if line[x] == emptyKey:
						continue										
					
					idNo = self.decodeId(line[x])
																					
					key = str(keys[idNo])								
					
					if str(keys[idNo]) in keyRemap:
						key = keyRemap[str(keys[idNo])]
					
					if self.resultGrid[x][y] != -1:							  
						idNo2 = self.resultGrid[x][y]							
						key2 = self.gridKeys[idNo2]
						if (key,key2) in keyPairRemap:
							key = keyPairRemap[(key,key2)]
						else:
							remapMaxKey += 1
							keyPairRemap[(key,key2)] = str(remapMaxKey)
							key = str(remapMaxKey)
					
					if not key in addedKeys:
						self.keyIndex[key] = len(self.gridKeys)
						self.gridKeys.append(key)	
						if self.maxKey < int(key):
							self.maxKey = int(key)
						addedKeys[key] = True;
						
						if self.resultGrid[x][y] != -1:	
							self.gridData[key] =  self.gridData[key2][:]
							self.gridData[key].append(layer['data'][str(keys[idNo])])
						else:									
							self.gridData[key] = [layer['data'][str(keys[idNo])]]
							
							
					newId = self.keyIndex[key]
					
					self.resultGrid[x][y] = newId					

	def writeResult( self, crop = None ):
		gridSize = len(self.resultGrid)
	
		finalKeys = []
		finalData = {}
		finalGrid = []
		for y in xrange(crop[1],crop[3]):
			finalGrid.append("")
		
		finalIdCounter = 1
		idToFinalId = {}
		
		if not crop:
			crop = [0,0,gridSize,gridSize]				
		
		finalKeys.append("");
		idToFinalId[-1] = 0		
		for y in xrange(crop[1],crop[3]):
			for x in xrange(crop[0],crop[2]):
				id = self.resultGrid[x][y]
							
				if not id in idToFinalId and id != -1:
					idToFinalId[id] = finalIdCounter
					finalIdCounter = finalIdCounter + 1										
					finalKeys.append(self.gridKeys[id])
					finalData[self.gridKeys[id]] = self.gridData[self.gridKeys[id]]
				
				finalId = idToFinalId[id]				
				finalGrid[y-crop[1]] = finalGrid[y-crop[1]] + self.encodeId(finalId)
						
		result = {}
		result['keys'] = finalKeys		
					
		result['data'] = finalData		
						
		result['grid'] = finalGrid
				
		result = json.dumps(result,ensure_ascii = False).encode('utf-8')
				
		return result;

	def encodeId ( self, id ):
		id += 32
		if id >= 34:
			id = id + 1
		if id >= 92:
			id = id + 1
		return unichr(id)

	def decodeId( self, id ):
		if id in self.decodeCache:
			return self.decodeCache[id]		
		ret = ord(id)		
		if ret >= 93:
			ret -= 1
		if ret >= 35:
			ret -= 1				
		self.decodeCache[id] = ret - 32;	
		return ret - 32


