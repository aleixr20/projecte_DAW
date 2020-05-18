//Variables per a la gestió del menu toggle
// let menuVisibilityStatus = false;
// let toggleMenu;

//Variables per al Dark Mode
// let contrast = true

//Al cargar la pàgina
window.onload = function() {

    var data = {

        menuVisibilityStatus: false,
        DOM: {
            shadow: null,
            navbar: null,
            userMenu: null,
            menuLinks: null,
        },
        darkMode: null,
        articleForm: {
            // titol: null,
            // subtitol: null,
            // categoria: null,
            // novaCategoria: null,
            // contingut: null,
            // metaTags: null,
            // metaDescription: null,
        },

    };

    var model = {
        init: function() {
            model.loadDOMdata();
            model.loadLocalStorage();
        },
        loadDOMdata: function() {
            data.DOM.shadow = document.getElementById("fade");
            data.DOM.navbar = (document.getElementsByClassName("primary-menu"))[0];
            data.DOM.userMenu = document.getElementsByClassName("menu-user")[0];
            data.DOM.menuLinks = document.getElementsByClassName("menu-link");
        },
        loadLocalStorage: function() {
            if (localStorage.getItem("darkMode") != null) {
                data.darkMode = localStorage.getItem("darkMode")
            } else {
                data.darkMode = false
            }

        },
        toggleDarkMode: function() {
            if (data.darkMode == false) {
                localStorage.setItem("darkMode", true);
                data.darkMode = true;
                console.info('dark in localStorage is', localStorage.getItem("darkMode"))
                return true;
            } else {
                localStorage.setItem("darkMode", false);
                data.darkMode = false;
                console.info('dark in localStorage is', localStorage.getItem("darkMode"))
                return false;
            }
        },
        loadArticleForm: function() {
            data.articleForm.titol = document.forms['article']['article_titol'];
            data.articleForm.subtitol = document.forms['article']['article_subtitol'];
            data.articleForm.categoria = document.forms['article']['article_categoria'];
            data.articleForm.novaCategoria = document.forms['article']['article_nova_categoria'];
            data.articleForm.contingut = document.forms['article']['article_contingut'];
            data.articleForm.metaTags = document.forms['article']['article_meta_tag'];
            data.articleForm.metaDescription = document.forms['article']['article_meta_description'];
        }

    };

    var controller = {
        init: function() {
            model.init();
            view.init(data.darkMode);

            if (document.URL == "http://localhost:8000/new") {
                model.loadArticleForm();
                view.validateFormArticles(data.articleForm)
            }
        },

        toggleMenu: function() {
            if (data.menuVisibilityStatus == false) {
                view.showMenu(data.DOM);
                data.menuVisibilityStatus = true;
            } else {
                view.hideMenu(data.DOM);
                data.menuVisibilityStatus = false;
            }
        },
        toggleContrast: function() {
            if (model.toggleDarkMode()) {
                view.lightsOff();
            } else {
                view.lightsOn();
            }
        }

    };

    var view = {
        init: function(boolean) {
            if (boolean) {
                view.lightsOff()
            }
            view.listenBurger();
            view.listenDarkMode();


        },
        //Metode per escolar quan mostrar/ocultar el menu
        listenBurger: function() {
            document.getElementById('hamburgesa').addEventListener('click', (function() {
                return function() {
                    controller.toggleMenu();
                }
            })());
        },
        listenDarkMode: function() {
            document.getElementById('dark-mode').addEventListener('click', (function() {
                return function() {
                    controller.toggleContrast();
                }
            })());
        },
        //Metode per mostrar el menu lateral
        showMenu: function(Obj) {
            Obj.shadow.style.backgroundColor = "#fff";
            Obj.shadow.style.zIndex = 1;
            Obj.shadow.addEventListener("click", (function() {
                return function() {
                    view.hideMenu(Obj);
                }
            })());
            Obj.userMenu.style.bottom = "75%"
            Obj.navbar.style.width = "80%";
            Obj.navbar.style.backgroundColor = "rgba(100, 100, 100, 0.1)";

            for (i = 0; i < Obj.menuLinks.length; i++) {
                Obj.menuLinks[i].style.opacity = "1";
                Obj.menuLinks[i].style.visibility = "visible";
                Obj.menuLinks[i].addEventListener("click", (function() {
                    return function() {
                        view.hideMenu(Obj);
                    }
                })());
            }
        },
        //Metode per ocultar el menu lateral
        hideMenu: function(Obj) {
            Obj.shadow.style.backgroundColor = "transparent";
            Obj.shadow.style.zIndex = -1;
            Obj.shadow.removeEventListener("click", function() {});

            Obj.userMenu.style.bottom = "30%"
            Obj.navbar.style.backgroundColor = "transparent";
            if (window.screen.availWidth < 576) {
                Obj.navbar.style.width = "3em";
                for (i = 0; i < Obj.menuLinks.length; i++) {
                    Obj.menuLinks[i].style.opacity = "0";
                    Obj.menuLinks[i].style.visibility = "hidden";
                    Obj.menuLinks[i].removeEventListener("click", function() {});
                }
            } else {
                Obj.navbar.style.width = "16vw";
            }
        },
        //Metode per apagar les llums
        lightsOff: function() {
            document.getElementById('dark-mode').innerHTML = '<i class="menu-icon fa fa-toggle-on"></i>'
            let body = document.getElementsByTagName('body')[0]
            body.style.color = '#999';
            body.style.backgroundColor = '#333';
        },
        //Metode per encendre les llums
        lightsOn: function() {
            document.getElementById('dark-mode').innerHTML = '<i class="menu-icon fa fa-toggle-off"></i>'
            let body = document.getElementsByTagName('body')[0]
            body.style.color = '#666';
            body.style.backgroundColor = '#fff';
        },
        validateFormArticles: function(Obj) {
            Obj.titol.addEventListener("focusout", (function() {
                return function() {
                    view.validateLength(Obj.titol, 10, 20, 'Error de tamanyo');
                }
            })());
            Obj.subtitol.addEventListener("focusout", (function() {
                return function() {
                    view.validateLength(Obj.titol, 10, 20, 'Error de tamanyo');
                }
            })());
            Obj.metaTags.addEventListener("focusout", (function() {
                return function() {
                    view.validateLength(Obj.titol, 10, 20, 'Error de tamanyo');
                }
            })());

        },

        validateLength: function(inputObj, min, max, errorMsg) {

            //Primer de tot esborrr els errors de pantalla (son molestos)
            let errors = document.getElementsByClassName('form-error')
            for (i = 0; i < errors.length; i++) {
                errors[i].remove()
            }
            inputObj.style.border = '1px solid #ced4da'

            if (inputObj.value.length < min) {
                let newNode = document.createElement("p");
                var nodeText = document.createTextNode(`${errorMsg}! El texto introducido no puede ser inferior a ${min} carácteres`);
                newNode.appendChild(nodeText);
                newNode.classList.add("form-error")
                newNode.setAttribute('id', 'error')
                inputObj.style.border = '1px solid red'
                inputObj.insertAdjacentElement("afterend", newNode);
            } else if (inputObj.value.length > max) {
                let newNode = document.createElement("p");
                var nodeText = document.createTextNode(`${errorMsg}! El texto introducido no puede ser superior a ${max} carácteres`);
                newNode.appendChild(nodeText);
                newNode.classList.add("form-error")
                newNode.setAttribute('id', 'error')
                inputObj.style.border = '1px solid red'
                inputObj.insertAdjacentElement("afterend", newNode);
            } else {

                console.info(inputObj.value, 'CAMPO CORRECTO')
            }

            // if (inputObj.val().length < min || inputObj.val().length > max) {
            //     inputObj.css({ 'border': '1px solid red', 'box-shadow': '0 0 0 .2rem rgba(255, 0 , 0, .25)' })
            //     $('#articleSubmit').hide()

            // } else {
            //     inputObj.css({ 'border': '1px solid #ced4da', 'box-shadow': 'unset' })
            //     $('#articleSubmit').show()

            // }

        }


    };
    controller.init();
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