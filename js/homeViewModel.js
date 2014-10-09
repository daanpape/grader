// Page wide variables  
var viewModel = null;
var i18n = null;

// View model for the index page
function ViewModel() {
	// Global settings
	this.lang = ko.observable(document.documentElement.lang);
	
	
	// Global i18n bindings
	this.loginModalTitle = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("LoginModalTitle")}, this);
	this.homeBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("HomeButton")}, this);
	this.assessBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("AssessButton")}, this);
	this.settingsBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("SettingsButton")}, this);
	this.forgotPswdBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("ForgotPassword")}, this);
	this.loginBtn = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("LoginBtn")}, this);
	this.username = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("Username")}, this);
	this.password = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("Password")}, this);
	
	// Page specific i18n bindings
	this.title = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("ProjectName") + ' - ' + i18n.__("HomeTitle")}, this);
	this.projectname = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("ProjectName")}, this);
	this.homeManual = ko.computed(function(){i18n.setLocale(this.lang()); return i18n.__("HomeManual")}, this);
	
	/**
	 * Change the UI locale
	 * @locale: the new UI locale
	 */
	this.setLocale = function(locale) {
		this.lang(locale);
		i18n.setLocale(this.lang());
	}
}

$('document').ready(function(){
	
	// Instantiate internationalisation
	i18n = new I18n({
		directory: "/locales",
		locale: document.documentElement.lang,
		extension: ".json"
	});
	
	// Activate knockout framework
	viewModel = new ViewModel();
	ko.applyBindings(viewModel, document.getElementById("htmldoc"));
});

/* Set the site language */
function setLang(locale) {
	viewModel.setLocale(locale);
	/* Close navbar when open */
	$(".navbar-collapse").stop().css({ 'height': '1px' }).removeClass('in').addClass("collapse");
	$(".navbar-toggle").stop().removeClass('collapsed');
	return false;
}

/* Attach mailform handler */
$('document').ready(function(){
	$('#contact').submit(function(e){
		e.preventDefault();
		
		// Submit the form
		$.ajax({
			type: "POST",
			data: $('form#contactform').serialize(),
			cache: false,
			url: 'mail.php',
			dataType: 'json',
			success: function(data){
				if(data) {
					$('#oksenticon').show();
					setTimeout(function() { alert(i18n.__("MailSucces")); }, 1);
					$('form#contactform')[0].reset();
					setTimeout($('#oksenticon').fadeOut(250), 3000);
				} else {
					alert(i18n.__("MailError"));
				}
			},
			error: function(data){
				alert(i18n.__("MailError"));
			}
		});
	});
});
