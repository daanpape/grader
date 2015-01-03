// View model for the courses page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AccountTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AccountTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.firstname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.email = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Email");}, gvm);
    gvm.memberSince = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MemberSince");}, gvm);
    gvm.myProjects = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MyProjects");}, gvm);
}

function initPage() {
    // Fetch userdata
    $.getJSON('/api/currentuser', function(data) {
        $('#firstname').html(data.firstname);
        $('#lastname').html(data.lastname);
        $('#email').html(data.username);
        $('#member_since').html(data.created);
        $('#avatar').attr("src", '/' + data.avatar);
    });
    
    $('#edit-avatar').click(function(){
        showUploadModal(function(src, id){    
            // Save new picture in database
            $.ajax({
               type: "POST",
               url: '/api/account/avatar',
               data: "pictureid="+id,
               success: function(){
                   $('#avatar').attr("src", src);
               }
            });
        });
    })
}