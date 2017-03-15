function fillHeader(index, icon) {
    // add home icon
    var headerString = "<a href='" + index + "'>";
    headerString += "<div id='homeButton'>";
    headerString += "<img src='" + icon + "'/>";
    headerString += "</div>";
    headerString += "</a>";

    // add title
    headerString += "<h1>Davis Online Real Estate</h1>";

    document.getElementById("header").innerHTML = headerString;
}

function getHouseImages(from, to, first, last) {
    for(var i=first; i<=last; i++) {
        document.getElementById(to).innerHTML += "<img src='" + from + i + ".jpg'/>";
    }
}

function fillFooter() {
    var footerString = "<h4>Copyright \u00A9 2015 Matthew Davis</h4>";
    footerString += "<h4>ml.davis195@gmail.com</h4>";
    document.getElementById("footer").innerHTML = footerString;
}

function buildTemplate() {
    fillHeader("../index.php", "../ORE_Images/Icons/home_icon.png");
    getHouseImages("../ORE_Images/Houses/", "leftPanel", 1, 6);
    getHouseImages("../ORE_Images/Houses/", "rightPanel", 7, 12);
    fillFooter();
}

function buildNavPanel() {
    var tabs = {
        "Matches.php" : "View Your Matches",
        "UserProfile.php" : "Edit Search Preferences",
        "EditProperties.php" : "Edit Your Properties",
        "Logout.php" : "Logout"
    };
    var numberOfTabs = Object.keys(tabs).length;
    var tabWidth = Math.floor(970/numberOfTabs) - numberOfTabs;
    for (var tab in tabs) {
        document.write("<a href=" + tab + ">");
        document.write("<div class=navTab style=width:" + tabWidth + "px><h4>" + tabs[tab] + "</h4></div>");
        document.write("</a>");
    }
}

function populateSelect(start, end, incrementBy) {
    for (var i=start; i<=end; i+=incrementBy) {
        document.write("<option value=" + i + ">" + i + "</option>\n");
    }
}

function selectDefault(id, value) {
    var target = document.getElementById(id);
    for (var i=0; i<target.length; i++) {
        if (target.options[i].value == value) {
            target.selectedIndex = i;
            return;
        }
    }
}

function selectYesOrNo() {
    document.write("<option value='Any'>Any</option>");
    document.write("<option value='Yes'>Yes</option>");
    document.write("<option value='No'>No</option>");
}
