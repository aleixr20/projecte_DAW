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
        articleInputs: []

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

            //Aqui esta el error. 
            if (localStorage.getItem("darkMode") == null) {
                data.darkMode = false
            } else if (localStorage.getItem("darkMode") == "true") {
                data.darkMode = true;
            } else if (localStorage.getItem("darkMode") == "false") {
                data.darkMode = false;
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
            data.articleForm.titol = document.getElementById('article_titol').parentNode
            data.articleForm.subtitol = document.getElementById('article_subtitol').parentNode
            data.articleForm.categoria = document.getElementById('article_categoria').parentNode
            data.articleForm.novaCategoria = document.getElementById('article_nova_categoria').parentNode
            data.articleForm.contingut = document.getElementById('article_contingut').parentNode
            data.articleForm.metaTags = document.getElementById('article_meta_tag').parentNode
            data.articleForm.metaDescription = document.getElementById('article_meta_description').parentNode
                // data.articleInputs = document.getElementsByClassName('form-group')
                // titol = document.getElementById('article_titol').parentNode
        }

    };

    var controller = {
        init: function() {
            model.init();
            view.init(data.darkMode);

            if (document.URL == "http://localhost:8000/new") {
                model.loadArticleForm();
                //view.validateFormArticles(data.articleForm)
                view.listenFormInputs(data.articleForm)
            }
            if (document.URL == "http://localhost:8000/user/profile/edit") {
                //model.loadArticleForm();
                //view.validateFormArticles(data.articleForm)
                //view.listenFormInputs(data.articleForm)
                view.changeFileInput();
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

        listenFormInputs(Obj) {
            //Dels elements del formulari, especificar la accio del Listener
            view.validateFormArticles(Obj.titol, 10, 50)
            view.validateFormArticles(Obj.subtitol, 50, 200)
            view.validateFormArticles(Obj.metaTags, 0, 100)
            view.validateFormArticles(Obj.metaDescription, 100, 160)

            //Afegir listener de nova Categoria

        },
        validateFormArticles: function(Obj, min, max) {
            //Quan entri al Input, mostrar Ajuda i Errors
            Obj.getElementsByTagName('input')[0].addEventListener("focusin", (function() {
                return function() {
                    Obj.getElementsByClassName('help-text')[0].style.display = 'block'
                    Obj.getElementsByClassName('form-error-text')[0].style.display = 'block'
                }
            })());
            //Quan surti del Input, amagar Ajuda i Errors
            Obj.getElementsByTagName('input')[0].addEventListener("focusout", (function() {
                return function() {
                    Obj.getElementsByClassName('help-text')[0].style.display = 'none'
                    Obj.getElementsByClassName('form-error-text')[0].style.display = 'none'
                }
            })());
            //Mentres escrigui -> eventListener per actualitzar Error
            Obj.getElementsByTagName('input')[0].addEventListener("keyup", (function() {
                return function() {
                    view.validateLength(Obj, min, max);
                }
            })());
        },

        validateLength: function(inputObj, min, max) {
            //Capturar l'objecte input i error
            let input = inputObj.getElementsByTagName('input')[0]
            let error = inputObj.getElementsByClassName('form-error-text')[0]
            error.innerHTML = `Actualmente ${input.value.length} carácteres)`

            //Si el tamany es mes petit o mes gran dels especificats
            if (input.value.length < min || input.value.length > max) {
                error.style.color = 'tomato'
                input.style.border = '1px solid red'
            } else {
                error.style.color = '#999'
                input.style.border = '1px solid #ced4da'
                console.info(inputObj.value, 'CAMPO CORRECTO')
            }
        },

        changeFileInput: function() {
            let f = document.getElementById('user_imatge')
            f.addEventListener("change", (function() {
                return function() {
                    let fileName = f.value;
                    fileName = fileName.split("\\");
                    //fileName = fileName.split("");
                    fileName = fileName[fileName.length - 1]

                    document.getElementsByClassName('custom-file-label')[0].innerHTML = fileName
                    console.log(fileName)

                }
            })());
        }


    };
    controller.init();
}

window.onscroll = function() {

    //GESTIONAR QUE QUNA NO ESTIGUEM AL HOME NO ES CANVIIN ELS COLORS DEL MENU LATERAL
    // let homeURLs = this.document.getElementsByClassName('scrollable')[0].getElementsByClassName('menu-link');

    // for (let i=0; i<homeURLs.length;i++){
    //     if
    // }


    if (document.URL == "http://localhost:8000/user/profile/edit") {}
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