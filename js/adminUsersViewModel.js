function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserTitle");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);
    gvm.userActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);
}

function fetchUsersData()
{
    $.getJSON("/api//" + projectid + "/" + studentid, function(data)
    {
        $.each(viewModel.competences(), function(i,item){
            $.each(item.subcompetences(), function(i, subcomp)
            {
                $.each(subcomp.indicators(),function(i,indic)
                {
                    for(var i = 0; i < data.length; i++) {
                        if (indic.id() == data[i].indicator) {
                            indic.score(data[i].score);
                            indic.scoreid(data[i].id);
                        }
                    }
                });
            });
        });
    });
}