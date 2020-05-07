var show = true;
var toggleMenu;

window.onload = function() {

    document.getElementById("hamburgesa").addEventListener("click", function() {
        let menu_lateral = document.getElementsByClassName("primary-menu")
        let shadow = document.getElementById("fade");
        let links = document.getElementsByClassName("menu-link");
        let icons = document.getElementsByClassName("menu-icon");

        if (show == true) {
            menu_lateral[0].style.width = "80%";
            menu_lateral[0].style.backgroundColor = "rgba(100, 100, 100, 0.1)";
            shadow.style.backgroundColor = "#fff";
            toggleMenu = setTimeout(hideMenu(icons), 2000);
            toggleMenu = setTimeout(showMenu(links), 2000);
            show = false;
        } else {
            menu_lateral[0].style.width = "";
            menu_lateral[0].style.backgroundColor = "transparent";
            shadow.style.backgroundColor = "transparent";
            if (window.screen.availWidth < 576) {
                toggleMenu = setTimeout(hideMenu(links), 2000);
                toggleMenu = setTimeout(showMenu(icons), 2000);
            }
            show = true;
        }
    });
}

function showMenu(elements) {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.display = "block";
        elements[i].style.color = "";
        clearTimeout(toggleMenu)
    }
}

function hideMenu(elements) {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
        elements[i].style.color = "#fff";
        clearTimeout(toggleMenu)
    }
}

window.onscroll = function() {

    let links = document.getElementById("menu").getElementsByClassName("menu-link-visible");

    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;

    let section_H = (height - 40) / (links.length - 1)
    let repeat = true;
    for (var i = 1; i <= links.length; i++) {
        if ((winScroll > (section_H * (i - 1))) && (winScroll < (section_H * i))) {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            links[i - 1].className += " active";
        }
    }

}