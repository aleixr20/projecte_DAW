let show = true;
let toggleMenu;

window.onload = function() {

    /*
    let burger = document.getElementById("hamburgesa").addEventListener("click", function() {
        let menu_lateral = document.getElementsByClassName("primary-menu")
        let shadow = document.getElementById("fade");
        let links1 = document.getElementsByClassName("menu-link-visible");
        let links2 = document.getElementsByClassName("menu-link-hidden");
        for (i = 0; i < links2.length; i++) {
            // links.push(links2[i])
        }

        let icons = document.getElementsByClassName("menu-icon");

        if (show == true) {
            menu_lateral[0].style.width = "80%";
            menu_lateral[0].style.backgroundColor = "rgba(100, 100, 100, 0.1)";
            shadow.style.backgroundColor = "#fff";
            shadow.style.zIndex = 1;
            toggleMenu = setTimeout(hideMenu(icons), 2000);
            toggleMenu = setTimeout(showMenu(links1), 2000);
            toggleMenu = setTimeout(showMenu(links2), 2000);

            show = false;
        } else {
            //menu_lateral[0].style.width = "";
            menu_lateral[0].style.backgroundColor = "transparent";
            shadow.style.backgroundColor = "transparent";
            shadow.style.zIndex = -1;
            if (window.screen.availWidth < 576) {
                menu_lateral[0].style.width = "4.5em";
                toggleMenu = setTimeout(hideMenu(links1), 2000);
                toggleMenu = setTimeout(hideMenu(links2), 2000);
                toggleMenu = setTimeout(showMenu(icons), 2000);
            } else {
                menu_lateral[0].style.width = "16vw";
            }
            show = true;
        }
    });
    */

    if (this.document.URL == "http://localhost:8000/new") {
        $('#article_categoria').children('option').click(function() {
            if ($(this).html() == 'afegir nova categoria') {
                $('#novaCategoria').show();
                $('#article_nova_categoria').attr("required", "required");

            } else {
                $('#novaCategoria').hide();
                $('#article_nova_categoria').val("").removeAttr("required");
            }
        });
    }
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