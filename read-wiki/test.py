#!/usr/bin/env python
# -*- coding: utf-8 -*-
import re
import sys
from string import replace 


infobox_pattern = re.compile(ur"{{(?:i|I)nfobox[\s-]*([^\|]+)\|[^}]*}}");
#ele_pattern = re.compile(ur"\|/s*vrchol/s*=/s*([0..9]+)");

ele_pattern = re.compile(ur"\| (?:vrchol|k.{2}ta) = ([0-9\s]+)");
population_pattern = re.compile(ur"\| (?:obyvatel.{2}) = ([0-9\s]+)");
status_pattern = re.compile(ur"\| (?:status) = ([^\s]+)");
name_pattern = re.compile(ur"(?:\|)? (?:n.{2}zev) = (.+)");


text = sys.stdin.read()

text = replace(text,'&nbsp;',' ')

infobox = infobox_pattern.search(text)
infobox = infobox.group(1).strip() if infobox else None

ele = ele_pattern.search(text)
ele = int(re.sub("[^0-9]",'',ele.group(1))) if ele else None

population = population_pattern.search(text)
population = int(re.sub("[^0-9]",'',population.group(1))) if population else None

status = status_pattern.search(text)
status = status.group(1).strip() if status else None

name = name_pattern.search(text)
name = name.group(1).strip() if name else None

print infobox
print ele
print population
print status
print name

