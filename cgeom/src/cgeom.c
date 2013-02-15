#include "cgeom.h"

void cgeom_point_new(Cgeom_Point** ppPoint) {
	*ppPoint = malloc(sizeof(ppPoint));
}

void cgeom_point_delete(Cgeom_Point* pPoint) {
	free(pPoint);
}

void cgeom_linestring_new(Cgeom_Linestring** ppLinestring) {
	*ppLinestring = malloc(sizeof(Cgeom_Linestring), unsigned int initsize);
	*ppLinestring->size = 0;
	*ppLinestring->_maxsize = initsize;
	*ppLinestring->data = malloc(8*(*ppLinestring->_maxsize)+1);
	
}

void cgeom_linestring_realloc(Cgeom_Linestring* pLinestring) {
	pLinestring->data = realloc(8*(pLinestring->size)+1);
	pLinestring->_maxsize = pLinestring->size;
}

void cgeom_linestring_delete(Cgeom_Linestring* pLinestring) {
	 free(pLinestring->data);
	 free(pLinestring);
}


