import json

class Jsdb:
	_KEY = '__'
	def __init__(self, db = {}):				
		self._db = db
		
	def toList(self, db = None, _ret = {}, _from = False):
		if None == db:
			db = self._db				
		for key in db:
			if Jsdb._KEY == key:
				for k in db[key]:
					if not _from or k in _from:
						for data in db[Jsdb._KEY][k]:
							_ret.append((k,data))												
			else:
				self.toList(db[key],_ret)
		return _ret
	
	def insert(self, key, data):
		keys = key.split(' ')
		for k in keys:			
			pt = self._db
			for ch in k.lower():
				if ch not in pt:
					pt[ch] = {}			
				pt = pt[ch]
			if Jsdb._KEY not in pt:
				pt[Jsdb._KEY] = {}			
			if key not in pt[Jsdb._KEY]:
				pt[Jsdb._KEY][key] = []			
			
			pt[Jsdb._KEY][key].append(data)
	
	def like(self, key, order = False):
		ret = False
		keys = key.split(' ')
		for k in keys:
			pt = self._db
			for ch in k.lower():
				if ch not in pt:
					return []
				
				pt = pt[ch]
			ret = self.toList(pt,_from = ret)

		if order:
			order = order.split(' ')			
			desc = 1 in order[1] and order[1].lower() == 'desc'
			order = order[0]						
			
			if desc:
				ret.sort(key = lambda x: x[1][order])
			else:
				ret.sort(key = lambda x: -x[1][order])

		return ret;
		
	def json(self):
		return json.dumps(self._db)
