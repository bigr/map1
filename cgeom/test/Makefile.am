INCLUDES  = @CHECK_CFLAGS@
AUTOMAKE_OPTIONS = foreign
if HAVE_CHECK
TESTS = check_cgeom
else
TESTS =
endif
check_PROGRAMS = check_cgeom
check_o5mreader_SOURCES = check_cgeom.c $(top_builddir)/src/cgeom.h
check_o5mreader_CFLAGS = @CHECK_CFLAGS@
check_o5mreader_LDADD = $(top_builddir)/src/libcgeom.la @CHECK_LIBS@
CLEANFILES = check_cgeom.log
