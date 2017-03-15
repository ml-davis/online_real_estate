// builds default layout of page
function buildTemplate() {
    buildHeader();
    loadHouseImages("leftPanel", 1, 6);
    loadHouseImages("rightPanel", 7, 12);
    buildFooter();
}

// creates header
function buildHeader() {
    var link = document.createElement("a");
    link.href = "../../Index.php";
    var div = document.createElement("div");
    div.setAttribute("id", "homeButton");
    var image = document.createElement("img");
    image.setAttribute("src", "../../Images/Icons/home_icon.png");
    image.setAttribute("height", "60");
    image.setAttribute("width", "60");

    div.appendChild(image);
    link.appendChild(div);
    document.getElementById("header").appendChild(link);

    var header = document.createElement("h1");
    header.appendChild(document.createTextNode("Davis Online Real Estate"));
    document.getElementById("header").appendChild(header);
}

// places images of houses on side panels of web page
function loadHouseImages(target, start, finish) {
    for (var i = start; i <= finish; i++) {
        var image = document.createElement("img");
        //image.setAttribute("src", "../../Images/Houses/" + i + ".jpg");
        image.setAttribute("src", "/var/www/html/Projects/OnlineRealEstate/Images/Houses/" + i + ".jpg");
        document.getElementById(target).appendChild(image);
    }
}

// builds footer with copyright message on bottom of page
function buildFooter() {
    var copyright = document.createElement("h4");
    copyright.appendChild(document.createTextNode("Copyright \u00A9 2015 Matthew Davis"));
    var email = document.createElement("h4");
    email.appendChild(document.createTextNode("ml.davis195@gmail.com"));
    document.getElementById("footer").appendChild(copyright);
    document.getElementById("footer").appendChild(email);
}

// build navigation panel to move navigate website
function buildNavPanel(id, userType) {
    // TODO make logout destroy session
    if(userType == 'owner') {
        var profile = goTo("OwnerProfile", id);
        var preferences = goTo("OwnerPreferences", id);
    }
    else if(userType == 'tenant') {
        profile = goTo("TenantProfile", id);
        preferences = goTo("TenantPreferences", id);
    }

    buildNavTab("option0", "Browse", goTo("BrowseListings", id));
    buildNavTab("option1", "Edit Profile", profile);
    buildNavTab("option2", "Preferences", preferences);
    buildNavTab("option3", "Logout", goTo("LoginPage"), 0);
}

function goTo(page, id) {
    if(id > 0)
        return "../Pages/"+page+".php?id="+id;
    else
        return "../Pages/"+page+".php";
}

// builds individual navigation tabs
function buildNavTab(id, title, location) {
    var link = document.createElement("a");
    link.setAttribute("class", "navLink");
    link.href = location;

    var div = document.createElement("div");
    div.setAttribute("id", id);
    div.setAttribute("class", "navTab");

    var text = document.createElement("h3");
    text.appendChild(document.createTextNode(title));

    div.appendChild(text);
    link.appendChild(div);
    document.getElementById("navPanel").appendChild(link);
}

// fills input type select with numbered options from 'start' to 'end' inclusive
function populateSelect(location, start, end, defaultValue) {
    var target = document.getElementById(location);
    for(var i = start; i <= end; i++) {
        var option = document.createElement("option");
        option.appendChild(document.createTextNode(i+""));
        target.appendChild(option);
        target.value = defaultValue;
    }
}

// ensures all of the user's registration fields follow the specified criteria
function validateRegistration() {
    if (errorInField("firstName", /^[a-zA-Z\-]+$/, "First name must contain only letters or dashes.") ||
        errorInField("lastName", /^[a-zA-Z\-]+$/, "Last name must contain only letters or dashes.") ||
        errorInField("phoneNumber", /^\(\d\d\d\)\d\d\d\-\d\d\d\d$/, "Phone number must be in format (XXX)XXX-XXXX") ||
        errorInField("email", /^(?=.*[@])(?=.*[\.]).+$/, "Email must contain an @ symbol and at least one '.'") ||
        errorInField("loginName", /^[a-zA-Z0-9]{6,}$/, "Login name must only contain letters or numbers and be at " +
        "least 6 characters long.") ||
        errorInField("password", /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/, "Password must contain at least one lower " +
        "case letter, at least one upper case letter, and at least one number.")) {
        return false;
    }

    else if (!stringsMatch("password", "passwordConfirmation")) {
        window.alert("Your passwords don't match!");
        return false;
    }

    else if (!document.getElementById("tenant").checked && !document.getElementById("owner").checked) {
        window.alert("Please select if you wish to be a property owner or a tenant.");
        return false;
    }

    return true;
}

// used in validateRegistration() to reduce repetitive code
function errorInField(fieldName, regex, criteria) {
    var field = document.getElementById(fieldName).value;
    if (!regex.test(field)) {
        window.alert("There is a problem with one of your fields. Please use the following criteria:\n\n" + criteria);
        return true;
    }
    return false;
}

// returns true if fields hold the same value, returns false otherwise
function stringsMatch(field1, field2) {
    var str1 = document.getElementById(field1).value;
    var str2 = document.getElementById(field2).value;

    return str1 == str2;
}

// verify that a given message has less than 'maxLength' number of words
function verifyMessage(messageLocation, maxLength) {
    var message = document.getElementById(messageLocation).value;
    var array = message.split(" ");
    if (array.length > maxLength) {
        window.alert("Your alert message can only contain " + maxLength + " words");
        return false;
    }
    else
        return true;
}

function submitForms(form1, form2) {
    document.getElementById(form1).submit();
    document.getElementById(form2).submit();
}

function buildPropertyPanel(key, title) {
    document.write('<a class="propertyLink" href = ViewProperty.php?key='+key+'>');
    document.write('<div class="propertyButton">');
    document.write('<h2>'+title+'</h2>');
    document.write('</div>');
    document.write('</a>');
}

