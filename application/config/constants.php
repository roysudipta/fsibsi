<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
 * Custom Declarations
 * NAMING Convention - ALL METHODS, PAGES, VARIABLE SHOULD CONSISTS OF MODULE-NAME_METHOD-NAME / MODULE-NAME_PAGE-NAME
 */

/*
 * SITES
 */
define('CONST_FSI_SHORT', 'fsi');
define('CONST_BSI_SHORT', 'bsi');

define('CONST_FSI_LOGO', 'fsi.png');
define('CONST_BSI_LOGO', 'bsi.png');

define('CONST_FSI_LONG', 'Formula Students India');
define('CONST_FSI_LINK', 'http://fsi-bsi.in/');
//define('CONST_FSI_LINK', 'http://formulastudent.in/');

define('CONST_BSI_LONG', 'Baja Students India');
define('CONST_BSI_LINK', 'http://fsi-bsi.co.in/');
//define('CONST_BSI_LINK', 'http://bajastudent.in/');

define('CONST_APP_TITLE', 'FSI & BSI Portal');
define('CONST_APP_SITE_TITLE', 'FSI-BSI.in');
define('CONST_APP_SITE_LINK', 'http://fsi-bsi.com/');

define('CONST_COPYRIGHT_TITLE', 'DeltaInc');

define('CONST_COPYRIGHT_LINK', 'http://www.deltainc.net.in/');
define('CONST_DEVELOPER_NAME', 'Webee IT Services');
define('CONST_DEVELOPER_LINK', 'http://www.webee.co.in/');

/*
 * MESSAGE - CUSTOME MESSAGES FOR _lang FILE
 * LIST OF KEYS LISTED IN LANG FILE
 */
define('MSG_SCS_LOGIN', 'msg_login');
define('MSG_ERR_LOGIN', 'msg_login_fail');

define('MSG_SCS_SAVE_SUCCESS', 'msg_save');
define('MSG_SCS_UPDATE_SUCCESS', 'msg_update');
define('MSG_ERR_SAVE_FAIL', 'msg_save_fail');
define('MSG_ERR_UPDATE_FAIL', 'msg_update_fail');
define('MSG_ERR_AJAX_CALL_FAIL', 'msg_ajax_data_fail');
define('MSG_ERR_NO_DATA', 'msg_no_data');
define('MSG_ERR_RESTRICTED_ACCESSES', 'msg_restricted_access');

define('MSG_SCS_DELETED_SUCCESS', 'msg_delete');
define('MSG_SCS_DELETED_FAIL', 'msg_delete_fail');
define('MSG_SCS_ADD_TEAM', 'team_add_success');
define('MSG_SCS_CHANGE_STATUS', 'msg_change_status');

/*
 * USER TYPE
 */
define('CONST_USER_DEVELOPER', '1');
define('CONST_USER_ADMIN', '2');
define('CONST_USER_OFFICIAL', '3');
define('CONST_USER_CAPTAIN', '4');
define('CONST_USER_VICECAPTAIN', '5');
define('CONST_USER_TEAMMEMBER', '6');
define('CONST_USER_FACULTY', '7');
define('CONST_ACTIVATE', '1');
define('CONST_DEACTIVATE', '0');
define('CONST_VERIFICATION_ACTIVATE', '1');
define('CONST_VERIFICATION_DEACTIVATE', '0');

define('CONST_PR_NEWS', '0');
define('CONST_PR_ACHIEVEMENT', '1');
define('CONST_PR_PRESS_RELEASE', '2');
define('CONST_PR_EVENT', '3');
define('CONST_PR_NOTIFICATION', '1');

define('CONST_PR_NEWS_TEXT', 'News');
define('CONST_PR_ACHIEVEMENT_TEXT', 'Achievements');
define('CONST_PR_PRESS_RELEASE_TEXT', 'Press Release');
define('CONST_PR_EVENT_TEXT', 'Events');


define('CONST_GALLERY_TYPE_ALBUM', '0');
define('CONST_GALLERY_TYPE_PHOTO', '1');
define('CONST_ISSUE_MAX_RESOLVE_DAY', '365');
define('CONST_MAX_FILE_UPLOAD_SIZE', '10240');
define('CONST_ALLOWED_EXTENSIONS', 'jpg|JPG|png|PNG|gif|GIF');

define('USER_PROFILE_COVER_IMAGE_WIDTH_MAX', '1000');
define('USER_PROFILE_COVER_IMAGE_HEIGHT_MAX', '500');
define('USER_PROFILE_COVER_IMAGE_WIDTH_MIN', '400');
define('USER_PROFILE_COVER_IMAGE_HEIGHT_MIN', '200');

define('USER_PROFILE_IMAGE_WIDTH_MAX', '420');
define('USER_PROFILE_IMAGE_HEIGHT_MAX', '310');
define('USER_PROFILE_IMAGE_WIDTH_MIN', '50');
define('USER_PROFILE_IMAGE_HEIGHT_MIN', '20');

define('USER_TEAM_LOGO_WIDTH_MAX', '1000');
define('USER_TEAM_LOGO_HEIGHT_MAX', '500');
define('USER_TEAM_LOGO_WIDTH_MIN', '10');
define('USER_TEAM_LOGO_HEIGHT_MIN', '10');

define('USER_GALLERY_IMAGE_WIDTH_MAX', '1000');
define('USER_GALLERY_IMAGE_HEIGHT_MAX', '500');
define('USER_GALLERY_IMAGE_WIDTH_MIN', '10');
define('USER_GALLERY_IMAGE_HEIGHT_MIN', '10');

define('USER_NEWS_IMAGE_WIDTH_MAX', '420');
define('USER_NEWS_IMAGE_HEIGHT_MAX', '310');
define('USER_NEWS_IMAGE_WIDTH_MIN', '50');
define('USER_NEWS_IMAGE_HEIGHT_MIN', '20');

define('CONST_PRIORITY_LOW', '1');
define('CONST_PRIORITY_MEDIUM', '2');
define('CONST_PRIORITY_HIGH', '3');
define('CONST_PRIORITY_URGENT', '4');

//define('CONST_PR_NEWS','0');
/*
 * DATE FORMAT
 */
define('CONST_DATE_FORMAT_DMY', 'd/m/Y');
define('CONST_DATETIME_FORMAT_DMYHIS', 'd/m/Y h:i:s');
define('CONST_DATE_FORMAT_YMD', 'Y-m-d');



/*
 * PATHS
 */

define('CONST_PATH_FRONT', 'front/');
define('CONST_PATH_ADMIN', 'admin/');
define('CONST_PATH_COMMON', 'common/');
define('CONST_PATH_ERROR', 'errors/');

define('CONST_PATH_MEDIA', 'media/');
define('CONST_PATH_DEMO_IMAGE', CONST_PATH_MEDIA . 'demo_picture/');
define('CONST_PATH_LOGO', CONST_PATH_MEDIA . 'logo/');
define('CONST_PATH_PROFILE_IMAGE', CONST_PATH_MEDIA . 'profiles/profile_picture/');
define('CONST_PATH_PROFILE_COVER_IMAGE', CONST_PATH_MEDIA . 'profiles/cover_picture/');
define('CONST_PATH_TEAM_LOGO', CONST_PATH_MEDIA . 'team/');
define('CONST_PATH_GALLERY', CONST_PATH_MEDIA . 'gallery/');
define('CONST_PATH_NEWS_IMAGE', CONST_PATH_MEDIA . 'news/');


/*
 * THEME - DIR Structure
 */
define('CONST_PATH_ASSETS', 'assets/');
define('CONST_PATH_ASSETS_ADMIN', CONST_PATH_ASSETS . 'admin/');
define('CONST_PATH_ASSETS_ADMIN_PLUGINS', CONST_PATH_ASSETS_ADMIN . 'global/plugins/');

define('CONST_PATH_ASSETS_FRONT', CONST_PATH_ASSETS . CONST_PATH_FRONT);
define('CONST_PATH_ASSETS_FRONT_SCRIPTS', CONST_PATH_ASSETS_FRONT . 'scripts/');
define('CONST_PATH_ASSETS_FRONT_CSS', CONST_PATH_ASSETS_FRONT . 'css/');
define('CONST_PATH_ASSETS_FRONT_IMAGES', CONST_PATH_ASSETS_FRONT . 'images/');

/*
 * VIEW - DIR Structure
 */

define('CONST_PATH_ADMIN_CMS', CONST_PATH_ADMIN . 'cms/');
define('CONST_PATH_ADMIN_COMMON', CONST_PATH_ADMIN . 'common/');
define('CONST_PATH_ADMIN_COLLEGE', CONST_PATH_ADMIN . 'college/');
define('CONST_PATH_ADMIN_TEAM', CONST_PATH_ADMIN . 'team/');
define('CONST_PATH_ADMIN_DASHBOARD', CONST_PATH_ADMIN . 'dashboard/');
define('CONST_PATH_ADMIN_EVENTS', CONST_PATH_ADMIN . 'event/');
define('CONST_PATH_ADMIN_GALLERY', CONST_PATH_ADMIN . 'gallery/');
define('CONST_PATH_ADMIN_INVOICE', CONST_PATH_ADMIN . 'invoice/');
define('CONST_PATH_ADMIN_NEWS', CONST_PATH_ADMIN . 'news/');
define('CONST_PATH_ADMIN_NOTIFICATION', CONST_PATH_ADMIN . 'notification/');
define('CONST_PATH_ADMIN_QUIZ', CONST_PATH_ADMIN . 'quiz/');
define('CONST_PATH_ADMIN_SUBMISSION', CONST_PATH_ADMIN . 'submission/');
define('CONST_PATH_ADMIN_TICKETING', CONST_PATH_ADMIN . 'ticketing/');
define('CONST_PATH_ADMIN_USERS', CONST_PATH_ADMIN . 'user/');


define('CONST_PATH_FRONT_COMMON', CONST_PATH_FRONT . 'common/');
define('CONST_PATH_FRONT_PROFILE', CONST_PATH_FRONT . 'profile/');
define('CONST_PATH_FRONT_REGISTRATION', CONST_PATH_FRONT . 'registration/');
define('CONST_PATH_FRONT_SUBMISSION', CONST_PATH_FRONT . 'submission/');
define('CONST_PATH_FRONT_TICKETING', CONST_PATH_FRONT . 'ticketing/');
define('CONST_PATH_FRONT_DASHBOARD', CONST_PATH_FRONT . 'dashboard/');

/*
 * CONTROLLERS
 */
define('CONTROLLER_AUTH', 'auth/');
define('CONTROLLER_INDEX', 'index/');
define('CONTROLLER_REGISTRATION', 'registration');
define('CONTROLLER_ISSUES_MANAGEMENT', 'issues/');


define('CONTROLLER_ADMIN_DASHBOARD', CONST_PATH_ADMIN . 'dashboard/');
define('CONTROLLER_ADMIN_COLLEGE', CONST_PATH_ADMIN . 'colleges/');
define('CONTROLLER_ADMIN_TEAM', CONST_PATH_ADMIN . 'teams/');
define('CONTROLLER_ADMIN_EVENT', CONST_PATH_ADMIN . 'event/');
define('CONTROLLER_ADMIN_USER', CONST_PATH_ADMIN . 'users/');
define('CONTROLLER_ADMIN_GALLERY', CONST_PATH_ADMIN . 'gallery/');
define('CONTROLLER_ADMIN_INVOICE', CONST_PATH_ADMIN . 'invoice/');
define('CONTROLLER_ADMIN_NOTIFICATION', CONST_PATH_ADMIN . 'notification/');
define('CONTROLLER_ADMIN_NEWS', CONST_PATH_ADMIN . 'news/');
define('CONTROLLER_ADMIN_QUIZ', CONST_PATH_ADMIN . 'quiz/');
define('CONTROLLER_ADMIN_SUBMISSION', CONST_PATH_ADMIN . 'submission/');
define('CONTROLLER_ADMIN_TICKETING', CONST_PATH_ADMIN . 'ticketing/');
define('CONTROLLER_ADMIN_CMS', CONST_PATH_ADMIN . 'cms/');

define('CONTROLLER_FRONT_DASHBOARD_CAPTAIN', 'captain_dashboard/');

/*
 * FUNCTIONS
 */

define('FN_LOGIN', 'login');
define('FN_LOGOUT', 'logout');
define('FN_REGISTRATION', 'registration');
define('FN_USER_SET_COVER_PICTURE', CONTROLLER_FRONT_DASHBOARD_CAPTAIN . 'set_cover_picture');
define('FN_USER_SET_PROFILE_PICTURE', CONTROLLER_FRONT_DASHBOARD_CAPTAIN . 'set_profile_picture');
define('FN_USER_SET_TEAM_LOGO', CONTROLLER_FRONT_DASHBOARD_CAPTAIN . 'set_team_logo');
define('FN_USER_ACTIVATION', CONTROLLER_AUTH . 'userActivation');
define('FN_CHANGE_PASSWORD', CONTROLLER_AUTH . 'change_password');
define('FN_SET_TEAM_PASSWORD', CONTROLLER_FRONT_DASHBOARD_CAPTAIN . 'set_password');
define('FN_ADMIN_DASHBOARD', CONTROLLER_ADMIN_DASHBOARD);
define('FN_CAPTAIN_DASHBOARD', CONTROLLER_FRONT_DASHBOARD_CAPTAIN);
define('FN_OFFICIAL_DASHBOARD', CONTROLLER_ADMIN_DASHBOARD . 'aaa');
define('FN_USER_DASHBOARD', CONTROLLER_ADMIN_DASHBOARD . 'aaaa');

define('FN_LIST_COLLEGES', CONTROLLER_ADMIN_COLLEGE . 'listColleges');

define('FN_LIST_TEAMS', CONTROLLER_ADMIN_TEAM . 'listTeams');

define('FN_LIST_USER_ADMIN', CONTROLLER_ADMIN_USER . 'admins');
define('FN_LIST_USER_OFFICIAL', CONTROLLER_ADMIN_USER . 'officials');
define('FN_LIST_USER_TEAM', CONTROLLER_ADMIN_USER . 'teams');

define('FN_LIST_INVOICE_SETTINGS', CONTROLLER_ADMIN_INVOICE . 'listSettings');
define('FN_LIST_INVOICE_INVOICES', CONTROLLER_ADMIN_INVOICE . 'listInvoices');

define('FN_LIST_EVENTS', CONTROLLER_ADMIN_EVENT);

define('FN_LIST_PAGES', CONTROLLER_ADMIN_CMS);

define('FN_LIST_NEWS', CONTROLLER_ADMIN_NEWS);

define('FN_LIST_FILE_TYPES', CONTROLLER_ADMIN_SUBMISSION . 'FileTypes');

define('FN_LIST_GALLERY', CONTROLLER_ADMIN_GALLERY);
define('FN_LIST_TICKET_CATEGORY', CONTROLLER_ADMIN_TICKETING . 'ticket_category');
define('FN_LIST_OPEN_TICKET', CONTROLLER_ADMIN_TICKETING . 'open_ticket_listing');
define('FN_LIST_CLOSED_TICKET', CONTROLLER_ADMIN_TICKETING . 'closed_ticket_listing');
define('FN_LIST_TICKET_REPLY', CONTROLLER_ADMIN_TICKETING . 'ticket_reply');


/* 
 * Front Function 
 */

define('FN_LIST_REPORT_TOPICS', CONTROLLER_ISSUES_MANAGEMENT );
define('FN_ISSUE_CATEGORY', CONTROLLER_ISSUES_MANAGEMENT . 'category/');
define('FN_ISSUE_TICKET', CONTROLLER_ISSUES_MANAGEMENT . 'ticket/');

/*
 * FUNCTIONS - AJAX CALLS
 */

define('FN_USER_CHANGE_ADDRESS_DETAILS', FN_CAPTAIN_DASHBOARD . 'change_user_address');
define('FN_USER_CHANGE_TEAM_DETAILS', FN_CAPTAIN_DASHBOARD . 'change_team_details');
define('FN_USER_CHANGE_DETAILS', FN_CAPTAIN_DASHBOARD . 'change_user_details');
define('FN_TEAM_CAR_SELECTION', FN_CAPTAIN_DASHBOARD . 'checkCarNoExisting');
define('FN_DELETE_TEAM_MEMBER', FN_CAPTAIN_DASHBOARD . 'delete_team_member');
define('FN_TEAM_DETAILS_SET', FN_CAPTAIN_DASHBOARD . 'set_team_details');
define('FN_USER_AUTHENTICATE', CONTROLLER_AUTH . 'authenticate_user');
define('FN_USER_UNIQUE_TEAM', CONTROLLER_AUTH . 'isUniqueTeam');
define('FN_USER_UNIQUE_TEAM_FOR_EDIT', CONTROLLER_AUTH . 'isUniqueTeamForEdit');
define('FN_USER_FORM_REGISTRATION', CONTROLLER_AUTH . 'FormRegistration');
define('FN_USER_FORGOT_EMAIL', CONTROLLER_AUTH . 'forgot_email');
define('FN_USER_RECOVER_CREDENTIAl', CONTROLLER_AUTH . 'recoverCredential');
define('FN_USER_CHANGE_PASSWORD', CONTROLLER_AUTH . 'changePasswordSubmit');
define('FN_USER_ADD_MEMBER', FN_CAPTAIN_DASHBOARD . 'add_member');
define('FN_EDIT_CAPTAIN_AND_TEAM_DETAILS', FN_CAPTAIN_DASHBOARD . 'edit_captain_and_team_details');

define('FN_COLLEGE_GET_DETAILS', CONTROLLER_ADMIN_COLLEGE . 'getDetails/');
define('FN_COLLEGE_SAVE_DETAILS', CONTROLLER_ADMIN_COLLEGE . 'collegeDetails');
define('FN_COLLEGE_DELETE_DETAILS', CONTROLLER_ADMIN_COLLEGE . 'deleteDetails/');

define('FN_INVOICE_SETTINGS_GET_DETAILS', CONTROLLER_ADMIN_INVOICE . 'getSettingDetails/');
define('FN_INVOICE_SETTINGS_SAVE_DETAILS', CONTROLLER_ADMIN_INVOICE . 'saveSettingDetails');
define('FN_INVOICE_INVOICES_GET_DETAILS', CONTROLLER_ADMIN_INVOICE . 'getInvoiceDetails/');
define('FN_INVOICE_INVOICES_SAVE_DETAILS', CONTROLLER_ADMIN_INVOICE . 'saveInvoiceDetails');
define('FN_INVOICE_INVOICES_PRINT', CONTROLLER_ADMIN_INVOICE . 'printInvoice/');


define('FN_USER_GET_DETAILS', CONTROLLER_ADMIN_USER . 'getDetails/');
define('FN_USER_SAVE_DETAILS', CONTROLLER_ADMIN_USER . 'saveDetails');
define('FN_USER_DELETE_DETAILS', CONTROLLER_ADMIN_USER . 'deleteDetails/');
define('FN_USER_CHANGE_STATUS', CONTROLLER_ADMIN_USER . 'changeStatus/');

define('FN_EVENT_GET_DETAILS', CONTROLLER_ADMIN_COLLEGE . 'getDetails/');
define('FN_EVENT_SAVE_DETAILS', CONTROLLER_ADMIN_COLLEGE . 'saveDetails');
define('FN_EVENT_DELETE_DETAILS', CONTROLLER_ADMIN_COLLEGE . 'deleteDetails/');

define('FN_GALLERY_ALBUMS', CONTROLLER_ADMIN_GALLERY . 'get_child_albums/');
define('FN_GALLERY_CREATE_NEW_ALBUM', CONTROLLER_ADMIN_GALLERY . 'create_new_album/');
define('FN_GALLERY_DELETE_ALBUM', CONTROLLER_ADMIN_GALLERY . 'delete_album/');
define('FN_GALLERY_DELETE_IMAGE', CONTROLLER_ADMIN_GALLERY . 'delete_photo/');
define('FN_GALLERY_IMAGE_UPLOAD', CONTROLLER_ADMIN_GALLERY . 'upload_photo/');
define('FN_GALLERY_CHANGE_IMAGE_ORDER', CONTROLLER_ADMIN_GALLERY . 'change_image_order/');
define('FN_NEWS_GET_DETAILS', CONST_PATH_ADMIN_NEWS . 'getDetails/');
define('FN_NEWS_SAVE_DETAILS', CONST_PATH_ADMIN_NEWS . 'saveDetails/');
define('FN_NEWS_DELETE_DETAILS', CONST_PATH_ADMIN_NEWS . 'deleteDetails/');


define('FN_TICKET_CATEGORY_GET_DETAILS', CONST_PATH_ADMIN_TICKETING . 'getDetails/');
define('FN_TICKET_CATEGORY_SAVE_DETAILS', CONST_PATH_ADMIN_TICKETING . 'saveDetails/');
define('FN_TICKET_CATEGORY_DELETE_DETAILS', CONST_PATH_ADMIN_TICKETING . 'deleteDetails/');
define('FN_TICKET_CATEGORY_STATUS_UPDATE', CONST_PATH_ADMIN_TICKETING . 'updateStatus/');
define('FN_TICKET_GET_DETAILS', CONST_PATH_ADMIN_TICKETING . 'ticketGetDetails/');
define('FN_TICKET_STATUS_UPDATE', CONST_PATH_ADMIN_TICKETING . 'updateTicketStatus/');
define('FN_TICKET_SAVE_DETAILS', CONST_PATH_ADMIN_TICKETING . 'saveTicketDetails/');
define('FN_TICKET_DELETE_DETAILS', CONST_PATH_ADMIN_TICKETING . 'deleteTicketDetails/');
define('FN_TICKET_REPLY_DELETE_DETAILS', CONST_PATH_ADMIN_TICKETING . 'deleteTicketReplyDetails/');
define('FN_POST_REPLY', CONST_PATH_ADMIN_TICKETING . 'post_a_reply/');
define('FN_FILE_TYPES', CONST_PATH_ADMIN_SUBMISSION . 'GetFileType/');
define('FN_FILE_TYPE_SAVE_DETAILS', CONST_PATH_ADMIN_SUBMISSION . 'saveDetails/');
define('FN_FILE_TYPE_STATUS_UPDATE', CONST_PATH_ADMIN_SUBMISSION . 'updateStatus/');
define('FN_FILE_TYPE_DELETE_DETAILS', CONST_PATH_ADMIN_SUBMISSION . 'deleteDetails/');
define('FN_FATCH_CATEGORIES_BY_EVENT_ID', CONST_PATH_ADMIN_SUBMISSION . 'fatchCategory/');
define('FN_FRONT_POST_REPLY', CONTROLLER_ISSUES_MANAGEMENT . 'post_a_reply/');
define('FN_FRONT_REPOST_AN_ISSUE', CONTROLLER_ISSUES_MANAGEMENT . 'repost_an_issue/');

/*
 * PAGES
 */

define('PAGE_RESCRICTED', CONST_PATH_ERROR . 'view_restricted_access');

/*
 * PAGES - ADMIN - COMMON
 */
define('PAGE_ADMIN_HEADER_META', CONST_PATH_ADMIN_COMMON . 'view_header_meta');
define('PAGE_ADMIN_HEADER_ASSETS', CONST_PATH_ADMIN_COMMON . 'view_header_assets');
define('PAGE_ADMIN_BODY_TOP_BAR', CONST_PATH_ADMIN_COMMON . 'view_body_top_bar');
define('PAGE_ADMIN_BODY_MENU', CONST_PATH_ADMIN_COMMON . 'view_body_menu');
define('PAGE_ADMIN_BODY_MAIN', CONST_PATH_ADMIN_COMMON . 'view_body_main');
define('PAGE_ADMIN_FOOTER', CONST_PATH_ADMIN_COMMON . 'view_footer');
define('PAGE_ADMIN_SCRIPT', CONST_PATH_ADMIN_COMMON . 'view_script');

/*
 * PAGES - ADMIN - CMS
 */
define('PAGE_ADMIN_CMS_ARTICLE_LIST', CONST_PATH_ADMIN_CMS . 'view_articles');

/*
 * PAGES - ADMIN - DASHBOARD
 */
define('PAGE_ADMIN_DASHBOARD_STATS', CONST_PATH_ADMIN_DASHBOARD . 'view_dashboard_statistics');

/*
 * PAGES - ADMIN - COLLEGES
 */
define('PAGE_ADMIN_COLLEGES', CONST_PATH_ADMIN_COLLEGE . 'view_colleges');
/*
 * PAGES - ADMIN - TEAMS
 */
define('PAGE_ADMIN_TEAMS', CONST_PATH_ADMIN_TEAM . 'view_teams');
/*
 * PAGES - ADMIN - EVENT
 */
define('PAGE_ADMIN_EVENTS', CONST_PATH_ADMIN_EVENTS . 'view_events');
/*
 * PAGES - ADMIN - GALLERY
 */
define('PAGE_ADMIN_GALLERY', CONST_PATH_ADMIN_GALLERY . 'view_gallery');
define('PAGE_ADMIN_GALLERY_FILE_LISTING', CONST_PATH_ADMIN_GALLERY . 'view_gallery_file_listing');
/*
 * PAGES - ADMIN - INVOICE
 */
define('PAGE_ADMIN_INVOICE_SETTINGS', CONST_PATH_ADMIN_INVOICE . 'view_invoice_settings');
define('PAGE_ADMIN_INVOICE_INVOICES', CONST_PATH_ADMIN_INVOICE . 'view_invoices');
/*
 * PAGES - ADMIN - NEWS
 */

define('PAGE_ADMIN_NEWS', CONST_PATH_ADMIN_NEWS . 'view_news');


/*
 * PAGES - ADMIN - NOTIFICATION
 */

/*
 * PAGES - ADMIN - QUIZ
 */

/*
 * PAGES - ADMIN - SUBMISSION
 */
define('PAGE_ADMIN_FILE_TYPES', CONST_PATH_ADMIN_SUBMISSION . 'view_file_types');
/*
 * PAGES - ADMIN - TICKETING
 */
define('PAGE_ADMIN_TICKET_CATEGORY', CONST_PATH_ADMIN_TICKETING . 'view_ticket_category');
define('PAGE_ADMIN_OPEN_TICKET_LISTING', CONST_PATH_ADMIN_TICKETING . 'view_open_ticket_listing');
define('PAGE_ADMIN_CLOSED_TICKET_LISTING', CONST_PATH_ADMIN_TICKETING . 'view_closed_ticket_listing');
define('PAGE_ADMIN_TICKET_REPLY_LISTING', CONST_PATH_ADMIN_TICKETING . 'view_ticket_reply_listing');
define('PAGE_ADMIN_TICKET_ISSUE_ASSIGNMENT', CONST_PATH_ADMIN_TICKETING . 'view_email_template_issue_assignment');
define('PAGE_ADMIN_REPLY_CONTENT_APPEND', CONST_PATH_ADMIN_TICKETING . 'view_reply_content_append');
/*
 * PAGES - ADMIN - USER
 */
define('PAGE_ADMIN_USERS_ADMIN', CONST_PATH_ADMIN_USERS . 'view_user_admin');
define('PAGE_ADMIN_USERS_OFFICIAL', CONST_PATH_ADMIN_USERS . 'view_user_official');
define('PAGE_ADMIN_USERS_TEAM', CONST_PATH_ADMIN_USERS . 'view_user_team');

/*
 * PAGES - FRONT - COMMON
 */
define('PAGE_FRONT_HEAD', CONST_PATH_FRONT_COMMON . 'view_head');
define('PAGE_FRONT_HEADER', CONST_PATH_FRONT_COMMON . 'view_header');
define('PAGE_FRONT_HEADER_MENU', CONST_PATH_FRONT_COMMON . 'view_header_menu');
define('PAGE_FRONT_BODY_MAIN', CONST_PATH_FRONT_COMMON . 'view_main');
define('PAGE_FRONT_FOOTER', CONST_PATH_FRONT_COMMON . 'view_footer');
define('PAGE_FRONT_SCRIPT', CONST_PATH_FRONT_COMMON . 'view_script');
define('PAGE_FRONT_COMMON_SCRIPTS', CONST_PATH_FRONT_COMMON . 'view_scripts');
/*
 * PAGES - FRONT - AUTH
 */
define('PAGE_FRONT_HOME', CONST_PATH_FRONT . 'view_home');
define('PAGE_FRONT_AUTH_LOGIN', 'view_login');
define('PAGE_FRONT_AUTH_REGISTRATION', CONST_PATH_FRONT_REGISTRATION . 'view_registration');
define('PAGE_FRONT_AUTH_CHANGE_PASSWORD', CONST_PATH_FRONT_REGISTRATION . 'view_change_password');

define('PAGE_TEMPLATE_EMAIL_CONFIRMATION', CONST_PATH_FRONT_COMMON . 'view_email_template_reg_conf');
define('PAGE_TEMPLATE_PASSWORD_CHANGE', CONST_PATH_FRONT_COMMON . 'reset_password_template');
define('PAGE_TEMPLATE_TEAM_MAIL_ACTIVATION', CONST_PATH_FRONT_COMMON . 'set_password_for_team');
define('PAGE_FRONT_AUTH_EMAIL_VERIFICATION', CONST_PATH_FRONT_REGISTRATION . 'view_email_verification');
define('PAGE_FRONT_DASHBOARD_CAPTAIN', CONST_PATH_FRONT_DASHBOARD . 'view_dashboard_captain');
define('PAGE_FRONT_AUTH_FORGOT_CREDENTIAL', CONST_PATH_FRONT_REGISTRATION . 'view_forgot_credential');
define('PAGE_FRONT_AUTH_SET_PASSWORD', CONST_PATH_FRONT_REGISTRATION . 'view_set_password');

/*
 * PAGES - FRONT - ISSUES
 */
define('PAGE_FRONT_ISSUE_TOPIC', CONST_PATH_FRONT_TICKETING . 'view_issue_topics');
define('PAGE_FRONT_ISSUE_DETAILS', CONST_PATH_FRONT_TICKETING . 'view_issue_listing_under_category');
define('PAGE_FRONT_ISSUE_REPLY_DETAILS', CONST_PATH_FRONT_TICKETING . 'view_replies_listing_under_ticket');
define('PAGE_FRONT_TICKET_ISSUE_ASSIGNMENT', CONST_PATH_FRONT_TICKETING . 'view_email_template_issue_assignment');
define('PAGE_FRONT_REPLY_CONTENT_APPEND', CONST_PATH_FRONT_TICKETING . 'view_reply_content_append');
define('PAGE_FRONT_TICKET_CONTENT_APPEND', CONST_PATH_FRONT_TICKETING . 'view_ticket_content_append');
