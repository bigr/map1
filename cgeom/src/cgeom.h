#ifndef __CGEOM__H__
#define __CGEOM__H__

#include <stdint.h>

#pragma pack(push)
#pragma pack(1)
typedef struct {
	union {
		uint64_t data;
		struct {
			int32_t x;
			int32_t y;
		} coords;
	}
} *CGeom_Point;
#pragma pack(pop)

#define CGEOM_TYPE_POINT 1
#define CGEOM_TYPE_LINESTRING 2

typedef struct {
	unsigned int size;
	unsigned int _maxsize;
	uint8_t *data	
} *CGeom_Linestring;

void cgeom_point_new(Cgeom_Linestring** ppPoint);
void cgeom_point_delete(Cgeom_Linestring* pPoint);

inline void cgeom_point_fromD(Cgeom_Point* pPoint, double lon, double lat) {
	pPoint->coords.x = (int32_t)lon*1E+07;
	pPoint->coords.y = (int32_t)lat*1E+07;
}

inline void cgeom_point_fromI(Cgeom_Point* pPoint, int32_t lon, int32_t lat) {
	pPoint->coords.x = lon;
	pPoint->coords.y = lat;
}

void cgeom_linestring_new(Cgeom_Linestring** ppLinestring);
void cgeom_linestring_realloc(Cgeom_Linestring* ppLinestring);
void cgeom_linestring_delete(Cgeom_Linestring* pLinestring);

inline unsigned int cgeom_linestring_clean(Cgeom_Linestring* pLinestring) {	
	pLinestring->size = 0;
}

inline unsigned int cgeom_linestring_init(Cgeom_Linestring* pLinestring) {
	pLinestring->data[0] = CGEOM_TYPE_LINESTRING;
	cgeom_linestring_clean(pLinestring);
}

cgeom_linestring_append(Cgeom_Linestring* pLinestring, Cgeom_Point* pPoint) {
	++pLinestring->size;
	if ( pLinestring->size > pLinestring->_maxsize )
		cgeom_linestring_realloc(pLinestring);
	
	(*uint64_t)(pLinestring->data + 1)[pLinestring->size-1] = pPoint->data;		
}



#endif //__CGEOM_H__
