var topener = topener || {};
topener.lang = topener.lang || {};

/*
 * Some rules to play by:
 * - Prefix global language snippets with g_
 *   Global language snippets are those that are being used on multiple pages
 *   and are mostly generic. For example:
 *   g_submit: "Submit"
 *   g_cancel: "Cancel"
 * - Prefix page specific snippets with <namepage>_
 *   For example:
 *   edituser_firstname: "Firstname"
 *   projects_selectcourse: "Select course"
 */

topener.lang.en = {
    "hello"                 : "Hello!",
    "hello_name"            : "Hello %name%",
    "change_lang"           : "Set Language to %lang%",
    "g_projects"            : "Projects",
    "g_home"                : "Home",
    "g_assess"              : "Assess",
    "g_language"            : "Language",
    "g_login"               : "Login",
    "g_logout"              : "Logout"
};
