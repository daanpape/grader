// Page wide variables  
var viewModel = null;

// Instantiate localisation 
var i18n = new I18n({
    directory: "locales",
    locale: document.documentElement.lang,
    extension: ".json"
});

/**
 * Change the UI locale
 * @param {string} locale - the new locale in two letters
 * @returns {boolean} returns false to prevent event propagation
 */
function setLang(locale) {
    viewModel.setLocale(locale);
    
    // Close navbar when open
    $(".navbar-collapse").stop().css({ 'height': '1px' }).removeClass('in').addClass("collapse");
    $(".navbar-toggle").stop().removeClass('collapsed');
    return false;
}

/**
 * The system global viewmodel
 * @returns {GlobalViewModel}
 */
function GlobalViewModel()
{
    // Application settings
    this.lang = ko.observable("en");
    this.app = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("AppName");}, this);
        
    // I18N bindings
    this.loginModalTitle = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("LoginModalTitle");}, this);
    this.homeBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("HomeButton");}, this);
    this.assessBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("AssessButton");}, this);
    this.structureBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("StructureButton");}, this);
    this.forgotPswdBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("ForgotPassword");}, this);
    this.notMemberBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("NotMemberYetBtn");}, this);
    this.loginBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("LoginBtn");}, this);
    this.logoutBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("LogoutBtn")}, this);
    this.email = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("Email");}, this);
    this.password = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("Password");}, this);
    this.coursesbtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("CourseButton")}, this);
    this.projecttypeBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("ProjecttypesButton");}, this); 
    this.yesNoModaltitle = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("YesNoModaltitle");}, this);
    this.yesNoModalBody = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("YesNoModalBody");}, this);
    this.yes = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("Yes");}, this); 
    this.no = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("No");}, this); 

    /**
     * Change the UI locale
     * @param {string} locale - the new UI locale
     */
    this.setLocale = function(locale) {
        this.lang(locale);
        i18n.setLocale(this.lang());
    };
    
    // Instantiate page viewmodel
    pageViewModel(this);
}

/**
 * Page initialisation function
 */
$('document').ready(function(){
    // Activate knockout framework
    viewModel = new GlobalViewModel();
    ko.applyBindings(viewModel, document.getElementById("htmldoc"));

    // Execute page specific initialisation if present
    if(typeof initPage == 'function'){
        initPage();
    }
});