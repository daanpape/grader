// Page wide variables  
var viewModel = null;
/**
 * The system global viewmodel
 * @returns {GlobalViewModel}
 */
function GlobalViewModel()
{
    // Application settings
    this.lang = ko.observable("en");

    this.i18n = new topener.i18n();

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

/*
 * Global extensions
 */
if (typeof String.prototype.startsWith != 'function') {
  // see below for better implementation!
  String.prototype.startsWith = function (str){
    return this.indexOf(str) == 0;
  };
}