let menuVisibilityStatus = false;
let toggleMenu;
let contrast = true


window.onload = function() {

    let menu_lateral = document.getElementsByClassName("primary-menu")
    let shadow = document.getElementById("fade");
    let menulinks = document.getElementsByClassName("menu-link");
    let menu_usuari = document.getElementsByClassName("menu-user");

    document.getElementById("hamburgesa").addEventListener("click", function() {


        if (menuVisibilityStatus == false) {
            showMenu();
        } else {
            hideMenu();
        }
    });

    function showMenu() {
        menu_usuari[0].style.bottom = "75%"
        menu_lateral[0].style.width = "80%";
        menu_lateral[0].style.backgroundColor = "rgba(100, 100, 100, 0.1)";
        shadow.style.backgroundColor = "#fff";
        shadow.style.zIndex = 1;
        shadow.addEventListener("click", hideMenu);

        for (i = 0; i < menulinks.length; i++) {
            menulinks[i].style.opacity = "1";
            menulinks[i].style.zIndex = "+5";
            menulinks[i].addEventListener("click", hideMenu);
        }

        menuVisibilityStatus = true;
    }

    function hideMenu() {
        menu_usuari[0].style.bottom = "30%"
        menu_lateral[0].style.backgroundColor = "transparent";
        shadow.style.backgroundColor = "transparent";
        shadow.style.zIndex = -1;
        shadow.removeEventListener("click", function() {});

        if (window.screen.availWidth < 576) {
            menu_lateral[0].style.width = "3em";
            for (i = 0; i < menulinks.length; i++) {
                menulinks[i].style.opacity = "0";
                menulinks[i].style.zIndex = "-5";
                menulinks[i].removeEventListener("click", function() {});

            }
        } else {
            menu_lateral[0].style.width = "16vw";
        }
        menuVisibilityStatus = false;
    }

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

    $('#contrast').click(function() {
        if (contrast == false) {
            $(this).html('<i class="menu-icon fa fa-toggle-off"></i>');
            $('body').css({ 'color': '#666', 'background-color': '#fff' })

            contrast = true;
        } else {
            $(this).html('<i class="menu-icon fa fa-toggle-on"></i>')
            $('body').css({ 'color': '#999', 'background-color': '#333' })

            contrast = false;
        }
    });
}



window.onscroll = function() {

    //Capturar numero de seccions que te la pàgina
    let sections = document.getElementsByClassName("scrollable")
        //Capturar els links que hi ha al menu
    let links = document.getElementsByClassName("menu-link")

    let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    //this.console.log(winScroll)
    let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    let section_H = (height - 40) / (sections.length - 1)

    for (i = 1; i <= sections.length; i++) {
        if ((winScroll > (section_H * (i - 1))) && (winScroll < (section_H * i))) {
            let current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            links[i - 1].className += " active";
        }
    }

    let menuUserPositions = (height / 43); // =69 saltos winScroll
    let menuUser = document.getElementsByClassName('menu-user')

    for (i = 1; i <= 43; i++) {
        if ((winScroll > (menuUserPositions * (i - 1))) && (winScroll < (menuUserPositions * i))) {
            menuUser[0].style.bottom = (30 + i) + "%"

        }
    }


}