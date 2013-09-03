#!/usr/bin/env python
#
# geo.py is a python module with no dependencies on extra packages,
# providing some convenience functions for working with geographic
# coordinates
#
# Copyright (C) 2010  Maximilian Hoegner <hp.maxi@hoegners.de>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

### Part one - Functions for dealing with points on a sphere ###
import math

EARTH_RADIUS = 6370000.
MAG_LAT=82.7
MAG_LON=-114.4

direction_names = ["N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW"]
directions_num = len(direction_names)
directions_step = 360./directions_num

def xyz(lat,lon,r=EARTH_RADIUS):
	""" Takes spherical coordinates and returns a triple of cartesian coordinates """
	x = r*math.cos(math.radians(lat))*math.cos(math.radians(lon))
	y = r*math.cos(math.radians(lat))*math.sin(math.radians(lon))
	z = r*math.sin(math.radians(lat))
	return x,y,z

def dot(p1,p2):
	""" Dot product of two vectors """
	return p1[0]*p2[0]+p1[1]*p2[1]+p1[2]*p2[2]

def cross(p1,p2):
	""" Cross product of two vectors """
	x = p1[1]*p2[2]-p1[2]*p2[1]
	y = p1[2]*p2[0]-p1[0]*p2[2]
	z = p1[0]*p2[1]-p1[1]*p2[0]
	return x,y,z

def determinant(p1,p2,p3):
	""" Determinant of three vectors """
	return dot(p1,cross(p2,p3))

def normalize_angle(angle):
	""" Takes angle in degrees and returns angle from 0 to 360 degrees """
	cycles = angle/360.
	normalized_cycles = cycles - math.floor(cycles)
	return normalized_cycles*360.

def sgn(x):
	""" Returns sign of number """
	if x==0: return 0.
	elif x>0: return 1.
	else: return -1.

def angle(v1,v2,n=None):
	""" Returns angle between v1 and v2 in degrees. n can be a vector that points to an observer who is looking at the plane containing v1 and v2. This way, you can get well-defined signs. """
	if n==None:
		n=cross(v1,v2)

	prod = dot(v1,v2) / math.sqrt( dot(v1,v1) * dot(v2,v2) )
        if prod>1: prod=1.0 # avoid numerical problems for very small angles
	rad = sgn(determinant(v1,v2,n)) * math.acos( prod )
	deg = math.degrees(rad)
	return normalize_angle(deg)

def great_circle_angle(p1,p2,p3):
	""" Returns angle w(p1,p2,p3) in degrees. Needs p1 != p2 and p2 != p3. """
	n1=cross(p1,p2)
	n2=cross(p3,p2)
	return angle(n1,n2,p2)

def distance(p1,p2,r=EARTH_RADIUS):
	""" Returns length of curved way between two points p1 and p2 on a sphere with radius r. """
	return math.radians(angle(p1,p2)) * r

def direction_name(angle):
	""" Returns a name for a direction given in degrees. Example: direction_name(0.0) returns "N", direction_name(90.0) returns "O", direction_name(152.0) returns "SSO". """
	index = int(round( normalize_angle(angle)/directions_step ))
	index %= directions_num
	return direction_names[index]

magnetic_northpole=xyz(MAG_LAT,MAG_LON)
geographic_northpole=xyz(90,0)

### Part two - A tolerant parser for position strings ###
import re

class Parser:
	""" A parser class using regular expressions. """
	def __init__(self):
		self.patterns={}
		self.raw_patterns={}
		self.virtual={}

	def add(self,name,pattern,virtual=False):
		""" Adds a new named pattern (regular expression) that can reference previously added patterns by %(pattern_name)s.
		Virtual patterns can be used to make expressions more compact but don't show up in the parse tree. """
		self.raw_patterns[name] = "(?:"+pattern+")"
		self.virtual[name]=virtual

		try:
			self.patterns[name] = ("(?:"+pattern+")") % self.patterns
		except KeyError,e:
			raise Exception, "Unknown pattern name: %s" % str(e)

	def parse(self,pattern_name,text):
		""" Parses 'text' with pattern 'pattern_name' and returns parse tree """

		# build pattern with subgroups
		sub_dict = {}
		subpattern_names = []
		for s in re.finditer("%\(.*?\)s",self.raw_patterns[pattern_name]):
			subpattern_name = s.group()[2:-2]
			if not self.virtual[subpattern_name]:
				sub_dict[subpattern_name]="("+self.patterns[subpattern_name]+")"
				subpattern_names.append(subpattern_name)
			else:
				sub_dict[subpattern_name]=self.patterns[subpattern_name]

		pattern = "^"+( self.raw_patterns[pattern_name] % sub_dict )+"$"

		# do matching
		m=re.match(pattern, text)

		if m==None:
			return None

		# build tree recursively by parsing subgroups
		tree={"TEXT":text}

		for i in xrange(len(subpattern_names)):
			text_part = m.group(i+1)
			if not text_part==None:
				subpattern = subpattern_names[i]
				tree[subpattern]=self.parse(subpattern,text_part)

		return tree

position_parser=Parser()
position_parser.add("direction_ns",r"[NSns]")
position_parser.add("direction_ew",r"[EOWeow]")
position_parser.add("decimal_separator",r"[\.,]",True)
position_parser.add("sign",r"[+-]")

position_parser.add("nmea_style_degrees",r"[0-9]{2,}")
position_parser.add("nmea_style_minutes",r"[0-9]{2}(?:%(decimal_separator)s[0-9]*)?")
position_parser.add("nmea_style", r"%(sign)s?\s*%(nmea_style_degrees)s%(nmea_style_minutes)s")

position_parser.add("number",r"[0-9]+(?:%(decimal_separator)s[0-9]*)?|%(decimal_separator)s[0-9]+")

position_parser.add("plain_degrees",r"(?:%(sign)s\s*)?%(number)s")

position_parser.add("degree_symbol",r"\xc2\xb0",True)
position_parser.add("minutes_symbol",r"'|\xe2\x80\xb2|`|\xc2\xb4",True)
position_parser.add("seconds_symbol",r"%(minutes_symbol)s%(minutes_symbol)s|\xe2\x80\xb3|\"",True)
position_parser.add("degrees",r"%(number)s\s*%(degree_symbol)s")
position_parser.add("minutes",r"%(number)s\s*%(minutes_symbol)s")
position_parser.add("seconds",r"%(number)s\s*%(seconds_symbol)s")
position_parser.add("degree_coordinates","(?:%(sign)s\s*)?%(degrees)s(?:[+\s]*%(minutes)s)?(?:[+\s]*%(seconds)s)?|(?:%(sign)s\s*)%(minutes)s(?:[+\s]*%(seconds)s)?|(?:%(sign)s\s*)%(seconds)s")

position_parser.add("coordinates_ns", r"%(nmea_style)s|%(plain_degrees)s|%(degree_coordinates)s")
position_parser.add("coordinates_ew", r"%(nmea_style)s|%(plain_degrees)s|%(degree_coordinates)s")

position_parser.add("position", """\
\s*%(direction_ns)s\s*%(coordinates_ns)s[,;\s]*%(direction_ew)s\s*%(coordinates_ew)s\s*|\
\s*%(direction_ew)s\s*%(coordinates_ew)s[,;\s]*%(direction_ns)s\s*%(coordinates_ns)s\s*|\
\s*%(coordinates_ns)s\s*%(direction_ns)s[,;\s]*%(coordinates_ew)s\s*%(direction_ew)s\s*|\
\s*%(coordinates_ew)s\s*%(direction_ew)s[,;\s]*%(coordinates_ns)s\s*%(direction_ns)s\s*|\
\s*%(coordinates_ns)s[,;\s]+%(coordinates_ew)s\s*\
""")

def get_number(b):
	""" Takes appropriate branch of parse tree and returns float. """
	s = b["TEXT"].replace(",",".")
	return float(s)

def get_coordinate(b):
	""" Takes appropriate branch of the parse tree and returns degrees as a float. """

	r=0.

	if b.has_key("nmea_style"):
		if b["nmea_style"].has_key("nmea_style_degrees"): r += get_number(b["nmea_style"]["nmea_style_degrees"])
		if b["nmea_style"].has_key("nmea_style_minutes"): r += get_number(b["nmea_style"]["nmea_style_minutes"])/60.
		if b["nmea_style"].has_key("sign") and b["nmea_style"]["sign"]["TEXT"]=="-": r *= -1.
	elif b.has_key("plain_degrees"):
		r += get_number(b["plain_degrees"]["number"])
		if b["plain_degrees"].has_key("sign") and b["plain_degrees"]["sign"]["TEXT"]=="-": r *= -1.
	elif b.has_key("degree_coordinates"):
		if b["degree_coordinates"].has_key("degrees"):
			r += get_number(b["degree_coordinates"]["degrees"]["number"])
		if b["degree_coordinates"].has_key("minutes"):
			r += get_number(b["degree_coordinates"]["minutes"]["number"])/60.
		if b["degree_coordinates"].has_key("seconds"):
			r += get_number(b["degree_coordinates"]["seconds"]["number"])/3600.
		if b["degree_coordinates"].has_key("sign") and b["degree_coordinates"]["sign"]["TEXT"]=="-": r *= -1.

	return r

def parse_position(s):
	""" Takes a (utf8-encoded) string describing a position and returns a tuple of floats for latitude and longitude in degrees.
	Tries to be as tolerant as possible with input. Returns None if parsing doesn't succeed. """

	parse_tree = position_parser.parse("position", s)
	if parse_tree==None: return None

	lat_sign = +1.
	if parse_tree.has_key("direction_ns") and parse_tree["direction_ns"]["TEXT"] in ("S","s"): lat_sign = -1.

	lon_sign = +1.
	if parse_tree.has_key("direction_ew") and parse_tree["direction_ew"]["TEXT"] in ("W","w"): lon_sign = -1.

	lat = lat_sign*get_coordinate(parse_tree["coordinates_ns"])
	lon = lon_sign*get_coordinate(parse_tree["coordinates_ew"])

	return lat, lon
