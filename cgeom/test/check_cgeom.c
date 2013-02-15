#include <check.h>
#include <stdlib.h>
#include "../src/cgeom.h"


START_TEST (check_cgeom) {
	
}
END_TEST



Suite *o5mreader_suite (void) {
	Suite *s = suite_create ("CGeom");
	TCase *tc_core = tcase_create ("Core");	
	tcase_add_test (tc_core, check_cgeom);		
	suite_add_tcase (s, tc_core);

	return s;
}

main (void) {

	int number_failed;
	Suite *s = o5mreader_suite ();
	SRunner *sr = srunner_create (s);
	srunner_run_all (sr, CK_NORMAL);
	number_failed = srunner_ntests_failed (sr);
	srunner_free (sr);
	return (number_failed == 0) ? EXIT_SUCCESS : EXIT_FAILURE;
 }
