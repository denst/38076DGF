<?php defined('SYSPATH') or die('No direct script access.');

 function print_flex($array)
 {
     echo '<pre>';
     print_r($array);
     echo '</pre>';
 }

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
$whitelist = array('localhost', '127.0.0.1','dandiigo.loc');
if(in_array($_SERVER['HTTP_HOST'], $whitelist)){
    Kohana::init(array(
        'base_url'   => 'http://dandiigo.loc/',
        'index_file' => '',
        'profile' => TRUE,
        'caching' => TRUE,
        'errors' => TRUE,
    ));
} else {
    Kohana::init(array(
        'base_url'   => 'https://dandiigo.com/',
        'index_file' => ''
    ));
}

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

Cookie::$salt = '345987456098123';

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
         'profilertoolbar' => MODPATH.'profilertoolbar',
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('assets', '<dir>(/<file>)', array('file' => '.+', 'dir' => 
    '(laguadmin|css|files|img|js)'))
   ->defaults(array(
		'controller' => 'assets',
		'action'     => 'media',
		'file'       => NULL,
		'dir'       => NULL,
	));
// router for register admin
Route::set('register_admin', 'admin-registration')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'admin_registration'
	));

// router for register teacher
Route::set('register_teacher', 'teacher-registration')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'teacher_registration'
	));

// router for register student
Route::set('register_student', 'student-registration')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'student_registration'
	));

// router for move student
Route::set('move_student', 'classes/move-student')
	->defaults(array(
		'controller' => 'classes',
		'action'     => 'move_student'
	));

// router for change teacher for class
Route::set('change_teacher_class', 'classes/change-teacher')
	->defaults(array(
		'controller' => 'classes',
		'action'     => 'change_teacher'
	));

// router for thank you page
Route::set('thank_you_page', 'thankyou')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'thankyou'
	));

// router for admin
Route::set('admin', 'admin')
	->defaults(array(
		'controller' => 'admin',
		'action'     => 'index'
	));

// router for approve user
Route::set('approve_user', 'main/approve/<type>/<id>')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'approve'
	));


// router for edit subject
Route::set('edit_subject', 'subjects/edit/<id>')
	->defaults(array(
		'controller' => 'subjects',
		'action'     => 'edit'
	));

// router for delete subject
Route::set('delete_subject', 'subjects/delete/<id>')
	->defaults(array(
		'controller' => 'subjects',
		'action'     => 'delete'
	));

// router for list level
Route::set('list_level', 'levels/list(/<year>)')
	->defaults(array(
		'controller' => 'levels',
		'action'     => 'list'
	));

// router for edit level
Route::set('edit_level', 'levels/edit/<id>/<year>')
	->defaults(array(
		'controller' => 'levels',
		'action'     => 'edit'
	));

// router for edit level
Route::set('new_level', 'levels/new/<year>')
	->defaults(array(
		'controller' => 'levels', 
		'action'     => 'new'
	));

// router for auto assigned students
Route::set('auto_assigned', 'levels/auto-assigned/<id>/<year>')
	->defaults(array(
		'controller' => 'levels',
		'action'     => 'auto_assigned'
	));

// router for unassigned students
Route::set('unassigned_students', 'levels/unassigned-students/<id>/<year>')
	->defaults(array(
		'controller' => 'levels',
		'action'     => 'unassigned_students'
	));

// router for promoting detaining students
Route::set('promoting_detaining_students', 'levels/promoting-detaining/<type>/<student>')
	->defaults(array(
		'controller' => 'levels',
		'action'     => 'promoting_detaining'
	));

// router for delete level
Route::set('delete_level', 'levels/delete/<id>')
	->defaults(array(
		'controller' => 'levels',
		'action'     => 'delete'
	));

// router for view class
Route::set('view_class', 'classes/view/<id>')
	->defaults(array(
		'controller' => 'classes',
		'action'     => 'view'
	));

// router for edit student
Route::set('edit_student', 'students/edit/<id>')
	->defaults(array(
		'controller' => 'students',
		'action'     => 'edit'
	));

// router for edit teacher
Route::set('edit_teacher', 'teachers/edit/<id>')
	->defaults(array(
		'controller' => 'teachers',
		'action'     => 'edit'
	));

// router for associate teacher subject
Route::set('associate_teacher_subject', 'teachers/associate-subject')
	->defaults(array(
		'controller' => 'teachers',
		'action'     => 'associate_subject'
	));

// router for delete teacher subject
Route::set('delete_teacher_subject', 'teachers/delete-subject/<teacher>/<subject>')
	->defaults(array(
		'controller' => 'teachers',
		'action'     => 'delete_subject'
	));

// router for delete subject from class
Route::set('delete_subject_class', 'classes/delete-subject/<subject>/<class>')
	->defaults(array(
		'controller' => 'classes',
		'action'     => 'delete_subject'
	));

// router for delete student from class
Route::set('delete_student_class', 'classes/delete-student/<student>/<class>')
	->defaults(array(
		'controller' => 'classes',
		'action'     => 'delete_student'
	));

// router for add subject class
Route::set('add_subject_class', 'classes/add-subject')
	->defaults(array(
		'controller' => 'classes',
		'action'     => 'add_subject'
	));

// router for change scheme subject
Route::set('change_scheme_subject', 'subjects/change-scheme')
	->defaults(array(
		'controller' => 'subjects',
		'action'     => 'change_scheme'
	));

// router for change teacher subject
Route::set('change_teacher_subject', 'subjects/change-teacher')
	->defaults(array(
		'controller' => 'subjects',
		'action'     => 'change_teacher'
	));

// router for edit admin
Route::set('edit_admin', 'admin/edit/<id>')
	->defaults(array(
		'controller' => 'admin',
		'action'     => 'edit'
	));

// router for financial records
Route::set('financial_records', 'financial-records/list/<student>(/<year>)')
	->defaults(array(
		'controller' => 'financialrecords',
		'action'     => 'list'
	));

// router for financial records
Route::set('financial_paid', 'financial-records/paid/<student>/<period>/<order>/<year>/<paid>')
	->defaults(array(
		'controller' => 'financialrecords', 
		'action'     => 'paid'
	));

// router for paid for year
Route::set('paid_for_year', 'financial-records/finish-payment')
	->defaults(array(
		'controller' => 'financialrecords', 
		'action'     => 'finish_payment'
	));

// router for academic records
Route::set('academic_records', 'academic-records/list/<student>(/<year>)')
	->defaults(array(
		'controller' => 'academicrecords',
		'action'     => 'list'
	));

// router for create new academic record
Route::set('new_academic_record', 'academic-records/new/<student>/<subject>')
	->defaults(array(
		'controller' => 'academicrecords',
		'action'     => 'new'
	));

// router for delete academic record
Route::set('delete_academic_record', 'academic-records/delete/<id>/<student>/<year>')
	->defaults(array(
		'controller' => 'academicrecords',
		'action'     => 'delete'
	));


// router for change total academic record
Route::set('change_total_academic_record', 'academic-records/change-total/<student_id>/<year_id>/<class>/<period>(/<id>)')
	->defaults(array(
		'controller' => 'academicrecords',
		'action'     => 'change_total'
	));


// router for achievement records
Route::set('achievement_records', 'achievement-records/list/<student>(/<year>)')
	->defaults(array(
		'controller' => 'achievementrecords',
		'action'     => 'list'
	));

// router for create new academic record
Route::set('new_achievement_record', 'achievement-records/new/<student>')
	->defaults(array(
		'controller' => 'achievementrecords',
		'action'     => 'new'
	));

// router for edit achievement record
Route::set('edit_achievement_record', 'achievement-records/edit/<id>/<student>/<year>')
	->defaults(array(
		'controller' => 'achievementrecords',
		'action'     => 'edit'
	));

// router for delete achievement record
Route::set('delete_achievement_record', 'achievement-records/delete/<id>/<student>/<year>')
	->defaults(array(
		'controller' => 'achievementrecords',
		'action'     => 'delete'
	));

// router for disciplinary records
Route::set('disciplinary_records', 'disciplinary-records/list/<student>(/<year>)')
	->defaults(array(
		'controller' => 'disciplinaryrecords',
		'action'     => 'list'
	));

// router for create new disciplinary record
Route::set('new_disciplinary_record', 'disciplinary-records/new/<student>')
	->defaults(array(
		'controller' => 'disciplinaryrecords',
		'action'     => 'new'
	));

// router for edit disciplinary record
Route::set('edit_disciplinary_record', 'disciplinary-records/edit/<id>/<student>/<year>')
	->defaults(array(
		'controller' => 'disciplinaryrecords',
		'action'     => 'edit'
	));

// router for delete disciplinary record
Route::set('delete_disciplinary_record', 'disciplinary-records/delete/<id>/<student>/<year>')
	->defaults(array(
		'controller' => 'disciplinaryrecords',
		'action'     => 'delete'
	));


// router for achievement teacher records
Route::set('achievement_teacher_records', 'achievement-teacher-records/list/<teacher>(/<year>)')
	->defaults(array(
		'controller' => 'achievementteacherrecords',
		'action'     => 'list'
	));

// router for create new academic teacher record
Route::set('new_achievement_teacher_record', 'achievement-teacher-records/new/<teacher>')
	->defaults(array(
		'controller' => 'achievementteacherrecords',
		'action'     => 'new'
	));

// router for edit achievement teacher record
Route::set('edit_achievement_teacher_record', 'achievement-teacher-records/edit/<id>/<teacher>/<year>')
	->defaults(array(
		'controller' => 'achievementteacherrecords',
		'action'     => 'edit'
	));

// router for delete achievement teacher record
Route::set('delete_achievement_teacher_record', 'achievement-teacher-records/delete/<id>/<teacher>/<year>')
	->defaults(array(
		'controller' => 'achievementteacherrecords',
		'action'     => 'delete'
	));

// router for disciplinary teacher records
Route::set('disciplinary_teacher_records', 'disciplinary-teacher-records/list/<teacher>(/<year>)')
	->defaults(array(
		'controller' => 'disciplinaryteacherrecords',
		'action'     => 'list'
	));

// router for create new disciplinary teacher teacher record
Route::set('new_disciplinary_teacher_record', 'disciplinary-teacher-records/new/<teacher>')
	->defaults(array(
		'controller' => 'disciplinaryteacherrecords',
		'action'     => 'new'
	));

// router for edit disciplinary teacher record
Route::set('edit_disciplinary_teacher_record', 'disciplinary-teacher-records/edit/<id>/<teacher>/<year>')
	->defaults(array(
		'controller' => 'disciplinaryteacherrecords',
		'action'     => 'edit'
	));

// router for delete disciplinary teacher record
Route::set('delete_disciplinary_teacher_record', 'disciplinary-teacher-records/delete/<id>/<teacher>/<year>')
	->defaults(array(
		'controller' => 'disciplinaryteacherrecords',
		'action'     => 'delete'
	));


// router for change password
Route::set('change_password', 'change-password')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'change_password'
	));

// router for academic period
Route::set('academic_period', 'academic-period')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'academic_period'
	));

// default router
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'index',
	));