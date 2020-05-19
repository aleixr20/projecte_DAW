//Variables per a la gestió del menu toggle
let menuVisibilityStatus = false;
let toggleMenu;

//Variables per al Dark Mode
let contrast = true



//Al cargar la pàgina
window.onload = function() {

    //Obtenir elements del DOM que han de cmabiar amb el Toggle Menu
    const shadow = document.getElementById("fade")
    const menu_lateral = (document.getElementsByClassName("primary-menu"))[0]
    const menu_usuari = document.getElementsByClassName("menu-user")[0];
    const menulinks = document.getElementsByClassName("menu-link");

    //Obtenir l'element hamburguesa i assignar un Event Listener
    document.getElementById("hamburgesa").addEventListener("click", function() {

        if (menuVisibilityStatus == false) {
            showMenu();
        } else {
            hideMenu();
        }
    });

    //Funcio per a desplegar i mostrar elements el menu
    function showMenu() {
        shadow.style.backgroundColor = "#fff";
        shadow.style.zIndex = 1;
        shadow.addEventListener("click", hideMenu);

        menu_usuari[0].style.bottom = "75%"
        menu_lateral[0].style.width = "80%";
        menu_lateral[0].style.backgroundColor = "rgba(100, 100, 100, 0.1)";

        for (i = 0; i < menulinks.length; i++) {
            menulinks[i].style.opacity = "1";
            menulinks[i].style.visibility = "visible";
            menulinks[i].addEventListener("click", hideMenu);
        }
        menuVisibilityStatus = true;
    }

    //Funcio per a ocular el menu desplegat
    function hideMenu() {
        shadow.style.backgroundColor = "transparent";
        shadow.style.zIndex = -1;
        shadow.removeEventListener("click", function() {});

        menu_usuari[0].style.bottom = "30%"
        menu_lateral[0].style.backgroundColor = "transparent";
        if (window.screen.availWidth < 576) {
            menu_lateral[0].style.width = "3em";
            for (i = 0; i < menulinks.length; i++) {
                menulinks[i].style.opacity = "0";
                menulinks[i].style.visibility = "hidden";
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

        //Validar contingut inputs
        // $('#article_titol').change(console.log('hola'));
        // $('#article_titol').change(console.log($(this).html()));

        $('#article_titol').change(function() {
            inputLength($(this), 25, 100, null);
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

function validarForArticle() {

}

function validarInputLength(inputObj, min, max, missatge_error) {
    console.log(inputObj)
    if (inputObj.val().length < min || inputObj.val().length > max) {
        inputObj.css({ 'border': '1px solid red', 'box-shadow': '0 0 0 .2rem rgba(255, 0 , 0, .25)' })
        $('#articleSubmit').hide()

    } else {
        inputObj.css({ 'border': '1px solid #ced4da', 'box-shadow': 'unset' })
        $('#articleSubmit').show()

    }

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

    let menuUserPositions = (height / 37); // =69 saltos winScroll
    let menuUser = document.getElementsByClassName('menu-user')

    for (i = 1; i <= 38; i++) {
        if ((winScroll > (menuUserPositions * (i - 1))) && (winScroll < (menuUserPositions * i))) {
            menuUser[0].style.bottom = (35 + i) + "%"

        }
    }


}