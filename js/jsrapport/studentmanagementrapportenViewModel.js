// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    
    function initPage() {
        $("#errormessage").hide();
        $('#addWorksheetBtn').click(function () {
            if (viewModel.currentCourseId === undefined || viewModel.currentCourseId === null) {
                $("#errormessage").show();
            } else {
                showNewWorksheetModal();
                $("#errormessage").hide();
            }
        });

        $.getJSON('/api/currentuser', function (data) {
            viewModel.userId = data.id;
            viewModel.updateCourseRapport();
        });
    }
}
