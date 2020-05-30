//Al cargar la pàgina
window.onload = function() {

    var data = {

        //path: 'https://www.b-nerd.cat',
        // path: 'https://localhost:8000',

        // path: 'http://labs.iam.cat/~a14alerevagu/b-nerd',

        menuVisibilityStatus: false,
        DOM: {
            shadow: null,
            navbar: null,
            userMenu: null,
            menuLinks: null,
        },
        darkMode: null,
        articleForm: {},
        registerForm: {},
        editProfileForm: {},
        fedbackText: [{
                icon: 'frown-o',
                color: 'tomato',
                info: 'Soy un programador Pro, vanidoso, y con ganas de criticar vuestro trabajo !',
                footer: '"Prescindible. Acabamos de finalizar nuestros estudios y con mucha humildad aceptamos nuestras limitaciones. La opinion de los minadores de moral, no nos interessa"'
            },
            {
                icon: 'meh-o',
                color: 'orange',
                info: 'Interesante, pero con matices. Se de lo que hablo y partes de vuestro apuntes contiene información incorrecta',
                footer: '"Tu opinion nos interesa. Somos nerds, ansiosos por ampliar conociminetos. Agradecemos mucho tu aportación"',

            }, {
                icon: 'smile-o',
                color: 'forestgreen',
                info: 'Guay! Este articulo me ha sido de mucha ayuda',
                footer: '"No te flipes, que somos simples aprendices....Pero gràcies. Es bueno saber que nuestros apuntes han sido utiles a otras personas"'

            }, {
                icon: 'rocket',
                color: 'royalblue',
                info: 'Felicidades, Buen trabajo. Os animo a seguir avançando!',
                footer: '"Gràcias por tu apoyo! Nos gusta la programción y toda aportación es bienvenida"'
            }
        ]
    };

    var model = {
        /**
         * Al carregar la pàgina, carregar dades esencials
         */
        init: function() {
            model.loadDOMdata();
            model.loadLocalStorage();
            // model.loadPath();
        },
        /**
         * Metode per carregar dades del DOM del menu
         */
        loadDOMdata: function() {
            data.DOM.shadow = document.getElementById("fade");
            data.DOM.navbar = (document.getElementsByClassName("primary-menu"))[0];
            data.DOM.userMenu = document.getElementsByClassName("menu-user")[0];
            data.DOM.menuLinks = document.getElementsByClassName("menu-link");
        },
        /**
         * Metode per carregar dades del localStorage sobre l'estat del dark mode
         */
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
        // loadPath: function() {

        //     let uri = document.Uri
        // },
        /**
         * Metode per canviar l'estat del darkMode
         * @return Estat actual del darkMode
         */
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
        /**
         * Metode per obtenir i carregar a data, els elements del DOM del formulari d'un article
         */
        loadArticleForm: function() {
            data.articleForm.titol = document.getElementById('article_titol').parentNode;
            data.articleForm.resum = document.getElementById('article_resum').parentNode;
            data.articleForm.categoria1 = document.getElementById('article_categoria1').parentNode;
            data.articleForm.novaCategoria = document.getElementById('article_nova_categoria').parentNode;
            data.articleForm.contingut = document.getElementById('article_contingut').parentNode;
            data.articleForm.metaTags = document.getElementById('article_meta_tag').parentNode;
            data.articleForm.metaDescription = document.getElementById('article_meta_description').parentNode;
            data.articleForm.categories = document.getElementById('article_categories');

            // Defineixo aquests elements perque els anteriros no em serveixen perque criden al pare, crec que alguns no son correctes
            // data.articleForm.selectorCategoria1 = document.getElementById('article_categoria1');
            // data.articleForm.selectorCategoria2 = document.getElementById('article_categoria2');
            // data.articleForm.selectorCategoria3 = document.getElementById('article_categoria3');
            //data.articleForm.novaCategoriaOption = document.getElementById('novaCategoria')
        },
        /**
         * Metode per obtenir i carregar a data, els elements del DOM del formulari de registre
         */
        loadRegisterForm: function() {
            data.registerForm.nom = document.getElementById('registration_form_nom').parentNode
            data.registerForm.cognom = document.getElementById('registration_form_cognom').parentNode
            data.registerForm.email = document.getElementById('registration_form_email').parentNode
            data.registerForm.nomUsuari = document.getElementById('registration_form_nom_usuari').parentNode
            data.registerForm.pass1 = document.getElementById('registration_form_plainPassword').parentNode
            data.registerForm.pass2 = document.getElementById('registration_form_pass2').parentNode
            data.registerForm.birthday = document.getElementById('registration_form_data_naixament').parentNode
        },
        /**
         * Metode per obtenir i carregar a data, els elements del DOM del formulari d'editar el perfil d'usuari
         */
        loadEditProfileForm: function() {
            data.editProfileForm.nom = document.getElementById('user_nom').parentNode
            data.editProfileForm.cognom = document.getElementById('user_cognom').parentNode
            data.editProfileForm.email = document.getElementById('user_email').parentNode
            data.editProfileForm.nomUsuari = document.getElementById('user_nom_usuari').parentNode
            data.editProfileForm.github = document.getElementById('user_github').parentNode
            data.editProfileForm.linkedin = document.getElementById('user_linkedin').parentNode
            data.editProfileForm.twitter = document.getElementById('user_twitter').parentNode
            data.editProfileForm.facebook = document.getElementById('user_facebook').parentNode
            data.editProfileForm.birthday = document.getElementById('user_data_naixament').parentNode
        }

    };

    var controller = {
        init: function() {
            model.init();
            view.init(data.darkMode);

            //Segons la pàgina en la que estiguem, gestionar el model i la vista

            //Si estem al formulari de registre
            if (document.URL.search("/user/register") > 0) {
                model.loadRegisterForm();
                view.listenRegisterFormInputs(data.registerForm)
            }

            //Si estem al formualari d'editar usuari
            if (document.URL.search("/user/profile/edit") > 0) {
                model.loadEditProfileForm();
                view.listenEditProfileFormInputs(data.editProfileForm);
            }

            //Si estem al formulari d'articles
            if (document.URL.search("/new") > 0 || document.URL.search("/article/editar/") > 0) {
                model.loadArticleForm();
                view.listenArticleFormInputs(data.articleForm)
            }

            //Si estem a la vista d'un article
            if ((document.URL.search("/post/")) > 0) {
                view.listenArticleFeedback()
            }

            //Si estem a la vista d'un admin
            if ((document.URL.search("/admin")) > 0) {
                view.adminMenu();
            }
        },
        /**
         * Metode per mostrar/ocultar el menu en mobils
         */
        toggleMenu: function() {
            if (data.menuVisibilityStatus == false) {
                view.showMenu(data.DOM);
                data.menuVisibilityStatus = true;
            } else {
                view.hideMenu(data.DOM);
                data.menuVisibilityStatus = false;
            }
        },
        /**
         * Metode per canviar els colors de contrast (darkMode)
         */
        toggleContrast: function() {
            if (model.toggleDarkMode()) {
                view.lightsOff();
            } else {
                view.lightsOn();
            }
        }
    };

    var view = {
        /**
         * Metode per iniciar la vista
         * @param {boolean} boolean Si el darkMode esta ON o OFF
         */
        init: function(boolean) {
            if (boolean) {
                view.lightsOff()
            }
            view.listenBurger(); //Activar el listener del menu
            view.listenDarkMode(); //Activar el listener del darkMode
        },
        /**
         * Metode per escolar quan mostrar/ocultar el menu
         */
        listenBurger: function() {
            document.getElementById('hamburgesa').addEventListener('click', (function() {
                return function() {
                    controller.toggleMenu();
                }
            })());
        },
        /**
         * Metode per desplegar el menu lateral
         * @param {HTMLElement} Obj Elements del DOM esencials (menu i fade)
         */
        showMenu: function(Obj) {
            if (data.darkMode) {
                Obj.shadow.style.backgroundColor = "#333";
            } else {
                Obj.shadow.style.backgroundColor = "#fff";
            }
            Obj.shadow.style.zIndex = 1;
            Obj.shadow.addEventListener("click", (function() {
                return function() {
                    view.hideMenu(Obj);
                }
            })());
            Obj.userMenu.style.bottom = "75%"
            Obj.navbar.style.width = "80%";
            if (data.darkMode) {
                Obj.navbar.style.backgroundColor = "#444)";
            } else {
                Obj.navbar.style.backgroundColor = "#ccc)";
            }

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
        /**
         * Metode per ocultar el menu lateral
         * @param {HTMLElement} Obj Elements del DOM esencials (menu i fade)
         */
        hideMenu: function(Obj) {
            Obj.shadow.style.backgroundColor = "transparent";
            Obj.shadow.style.zIndex = -1;
            Obj.shadow.removeEventListener("click", function() {});

            Obj.userMenu.style.bottom = "30%"
                //Obj.navbar.style.backgroundColor = "transparent";
            if (window.screen.availWidth < 576 || window.screen.orientation.type == "landscape-primary") {
                Obj.navbar.style.width = "3em";
                for (i = 0; i < Obj.menuLinks.length; i++) {
                    Obj.menuLinks[i].style.opacity = "0";
                    Obj.menuLinks[i].style.visibility = "hidden";
                    // Obj.menuLinks[i].removeEventListener("click", function() {});
                }
            } else {
                Obj.navbar.style.width = "16vw";
            }
        },
        /**
         * Metode per escoltar quan encendre/apagar les llums
         */
        listenDarkMode: function() {
            document.getElementById('dark-mode').addEventListener('click', (function() {
                return function() {
                    controller.toggleContrast();
                }
            })());
        },
        /**
         * Metode per apagar les llums
         */
        lightsOff: function() {
            document.getElementById('dark-mode').innerHTML = '<i class="menu-icon fa fa-toggle-on"></i>'
            let body = document.getElementsByTagName('body')[0]
            body.style.color = '#999';
            body.style.backgroundColor = '#333';
        },
        /**
         * Metode per encendre les llums
         */
        lightsOn: function() {
            document.getElementById('dark-mode').innerHTML = '<i class="menu-icon fa fa-toggle-off"></i>'
            let body = document.getElementsByTagName('body')[0]
            body.style.color = '#666';
            body.style.backgroundColor = '#fff';
        },
        /**
         * Metode per escoltar quan obrir modal FeedBack
         */
        listenArticleFeedback: function() {
            let feedbackIcons = document.getElementsByClassName('feedback-icons')
            for (let i = 0; i < feedbackIcons.length; i++) {
                feedbackIcons[i].addEventListener("click", (function() {
                    return function() {

                        let shadow = document.getElementById('fade')
                        let feedbackModal = document.getElementById('feedback-modal')
                        view.showFeedbackForm(shadow, feedbackModal, i)
                    }
                })());
            }
        },
        /**
         * Metode per mostrar el modal amb el formulari de comentaris
         * @param {HTMLDivElement} shadow El div fade que ha de mostrar-se de fondo
         * @param {HTMLDivElement} modal El modal que ha de mstrar-se davant el fade
         * @param {number} num El numero de la icona (rating) que s'ha clicat
         */
        showFeedbackForm: function(shadow, modal, num) {
            //Obtenir i alterar DOM del feedback-info segons el numero de la icona clickada
            let modalInfo = modal.getElementsByClassName('feedback-info')[0]
            modalInfo.innerHTML = `<i class="fa fa-${data.fedbackText[num].icon}" style="color:${data.fedbackText[num].color}"></i> ${data.fedbackText[num].info}`;
            modalInfo.style.color = data.fedbackText[num].color;

            //Obtenir el DOM del input del formulari
            let tipo = modal.getElementsByTagName('input')[0]

            if (tipo != undefined) { //Si l'input existeix, l'usuari encara no ha fet cap comentari
                tipo.value = num; //Assignar-li el valor de la icona clickada
                //Obtenir i alterar DOM del feedback-footer segons el numero de la icona clickada
                let modalFooter = modal.getElementsByClassName('feedback-footer')[0]
                modalFooter.innerHTML = data.fedbackText[num].footer
                modalFooter.style.color = data.fedbackText[num].color
            }
            //Mostrar la capa translucida de fons i el modal
            shadow.style.zIndex = 4;
            shadow.style.backgroundColor = '#333'
            shadow.style.opacity = 0.9;
            modal.style.opacity = 1;
            modal.style.zIndex = 5
                //Activar un listener per amagar el modal si es clicka fora
            window.onclick = function(event) {
                if (event.target == shadow) {
                    shadow.style.opacity = 0;
                    shadow.style.zIndex = -1;
                    modal.style.opacity = 0;
                    modal.style.zIndex = -1
                }
            }
        },

        /**
         * Metode per S?HA DE MIRA'
         */
        adminMenu: function() {
            if (document.URL.search("/admin") > 0) {
                document.getElementsByClassName('menu-user')[0].style.bottom = '71%'
            }
        },


        /**
         * Metode per validar dades i mostrar ajuda/erros del formulari de registre
         * @param {object} Obj Dades guardes pel model amb els elements DOM del formulari
         */
        listenRegisterFormInputs: function(Obj) {

            //Dels elements del formulari, especificar la accio del Listener
            view.toggleHelpErrors(Obj.nom, 'input')
            view.validateLength(Obj.nom, 'input', 2, 40)

            view.toggleHelpErrors(Obj.cognom, 'input')
            view.validateLength(Obj.cognom, 'input', 2, 40)

            view.toggleHelpErrors(Obj.email, 'input')
            view.validateLength(Obj.email, 'input', 0, 100)

            view.toggleHelpErrors(Obj.nomUsuari, 'input')
            view.validateLength(Obj.nomUsuari, 'input', 8, 14)
                //FER CRIDA AJAX PER SABER SI ESTA REPETIT

            view.toggleHelpErrors(Obj.pass1, 'input')
            view.validateLength(Obj.pass1, 'input', 8, 50)
            view.validatePassword(Obj.pass1, 3, 2, 1)

            view.toggleHelpErrors(Obj.pass2, 'input')
            view.validatePass2(Obj.pass1, Obj.pass2)

            // view.toggleHelpErrors(Obj.birthday)
        },

        listenEditProfileFormInputs: function(Obj) {
            //Dels elements del formulari, especificar la accio del Listener
            view.toggleHelpErrors(Obj.nom, 'input')
            view.validateLength(Obj.nom, 'input', 2, 40)

            view.toggleHelpErrors(Obj.cognom, 'input')
            view.validateLength(Obj.cognom, 'input', 2, 40)

            view.toggleHelpErrors(Obj.email, 'input')
            view.validateLength(Obj.email, 'input', 0, 100)

            view.toggleHelpErrors(Obj.nomUsuari, 'input')
            view.validateLength(Obj.nomUsuari, 'input', 8, 14)
            view.checkUniqueUsername(Obj.nomUsuari)

            //FER CRIDA AJAX PER SABER SI ESTA REPETIT

            //User_descricpio es textarea no input !!
            // view.toggleHelpErrors(Obj.descripcio)
            // view.validateLength(Obj.descripcio, 0, 2000)

            view.toggleHelpErrors(Obj.github, 'input')
            view.validateSocialMedia(Obj.github)
            view.toggleHelpErrors(Obj.linkedin, 'input')
            view.validateSocialMedia(Obj.linkedin)
            view.toggleHelpErrors(Obj.twitter, 'input')
            view.validateSocialMedia(Obj.twitter)
            view.toggleHelpErrors(Obj.facebook, 'input')
            view.validateSocialMedia(Obj.facebook)
        },

        listenArticleFormInputs: function(Obj) {
            //Dels elements del formulari, especificar la accio del Listener
            view.toggleHelpErrors(Obj.titol, 'input')
            view.validateLength(Obj.titol, 'input', 10, 50)

            view.toggleHelpErrors(Obj.resum, 'textarea')
            view.validateLength(Obj.resum, 'textarea', 50, 400)

            view.toggleHelpErrors(Obj.metaTags, 'input')
            view.validateLength(Obj.metaTags, 'input', 0, 100)

            view.toggleHelpErrors(Obj.metaDescription, 'textarea')
            view.validateLength(Obj.metaDescription, 'textarea', 100, 160)

            view.listenCategoriesSelectors(Obj.categories)

            // VERSIO ANTERIOR ON AFEGIEM CATEGORIES DESDE FORM D'ARTICLE

            // //Afegir listener de nova Categoria
            // Obj.selectorCategoria1.addEventListener("change", function() {
            //     if (Obj.selectorCategoria1.options[Obj.selectorCategoria1.selectedIndex].text == "afegir nova categoria") {
            //         Obj.novaCategoriaOption.style.display = "block";
            //     } else if (Obj.selectorCategoria1.options[Obj.selectorCategoria1.selectedIndex].text != "afegir nova categoria" &&
            //         Obj.selectorCategoria2.options[Obj.selectorCategoria2.selectedIndex].text != "afegir nova categoria" &&
            //         Obj.selectorCategoria3.options[Obj.selectorCategoria3.selectedIndex].text != "afegir nova categoria") {
            //         Obj.novaCategoriaOption.style.display = "none";
            //     }
            // })
            // Obj.selectorCategoria2.addEventListener("change", function() {
            //     console.log(Obj.selectorCategoria2.options[Obj.selectorCategoria2.selectedIndex].text)
            //     if (Obj.selectorCategoria2.options[Obj.selectorCategoria2.selectedIndex].text == "afegir nova categoria") {
            //         Obj.novaCategoriaOption.style.display = "block";
            //     } else if (Obj.selectorCategoria2.options[Obj.selectorCategoria2.selectedIndex].text != "afegir nova categoria" &&
            //         Obj.selectorCategoria1.options[Obj.selectorCategoria1.selectedIndex].text != "afegir nova categoria" &&
            //         Obj.selectorCategoria3.options[Obj.selectorCategoria3.selectedIndex].text != "afegir nova categoria") {
            //         Obj.novaCategoriaOption.style.display = "none";
            //     }
            // })
            // Obj.selectorCategoria3.addEventListener("change", function() {
            //     if (Obj.selectorCategoria3.options[Obj.selectorCategoria3.selectedIndex].text == "afegir nova categoria") {
            //         Obj.novaCategoriaOption.style.display = "block";
            //     } else if (Obj.selectorCategoria3.options[Obj.selectorCategoria3.selectedIndex].text != "afegir nova categoria" &&
            //         Obj.selectorCategoria2.options[Obj.selectorCategoria2.selectedIndex].text != "afegir nova categoria" &&
            //         Obj.selectorCategoria1.options[Obj.selectorCategoria1.selectedIndex].text != "afegir nova categoria") {
            //         Obj.novaCategoriaOption.style.display = "none";
            //     }
            // })
        },
        /**
         * Metode amb els Listeners que mostra/oculta els missatges help i error on focusin/focusout
         * @param {HTMLDivElement} Obj Element <div> que conte els elements d'aquell camp del formulari
         * @param {String} formInputType Tipus de camp [input|textarea]
         */
        toggleHelpErrors: function(Obj, formInputType) {
            //Quan entri al camp del formulari, mostrar Ajuda i Errors
            Obj.getElementsByTagName(formInputType)[0].addEventListener("focusin", (function() {
                return function() {
                    Obj.getElementsByClassName('help-text')[0].style.display = 'block'
                    Obj.getElementsByClassName('form-error-text')[0].style.display = 'block'
                }
            })());
            //Quan surti del camp del formulari, amagar Ajuda i Errors
            Obj.getElementsByTagName(formInputType)[0].addEventListener("focusout", (function() {
                return function() {
                    Obj.getElementsByClassName('help-text')[0].style.display = 'none'
                    Obj.getElementsByClassName('form-error-text')[0].style.display = 'none'
                }
            })());
        },

        /**
         * Metode per validar el tamany d'un camp del formulari
         * @param {HTMLDivElement} inputObj 
         * @param {String} formInputType Tipus de camp [input|textarea]
         * @param {*} min Tamany minim que pot tenir
         * @param {*} max Tamany maxim que pot tenir
         */
        validateLength: function(inputObj, formInputType, min, max) {
            //Mentres escrigui -> eventListener per actualitzar Error
            inputObj.getElementsByTagName(formInputType)[0].addEventListener("keyup", (function() {
                return function() {

                    //Capturar l'objecte input i error
                    let input = inputObj.getElementsByTagName(formInputType)[0]
                    let error = inputObj.getElementsByClassName('form-error-text')[0]

                    //Si el tamany es mes petit o mes gran dels especificats
                    if (input.value.length < min || input.value.length > max) {
                        error.style.color = 'tomato'
                        input.style.border = '1px solid red'
                        error.innerHTML = `Actualmente ${input.value.length} carácteres)`

                    } else {
                        error.style.color = '#999'
                        input.style.border = '1px solid #ced4da'
                        console.info(inputObj.value, 'CAMPO CORRECTO')
                        error.innerHTML = ``

                    }
                }
            })());
        },
        checkUniqueUsername: function(inputObj) {

            inputObj.getElementsByTagName('input')[0].addEventListener("keyup", (function() {
                return function() {

                    let string = inputObj.getElementsByTagName('input')[0].value;

                    //Fer consulta a API
                    axios.get(`http://labs.iam.cat/~a14alerevagu/b-nerd/user/validateUsername/${string}`)
                        .then(response => {
                            console.log(response.data);
                            console.log(response);
                        });
                }
            })());
        },

        validatePassword: function(inputObj) {

            let config = {
                min: 8,
                max: 50,
                lowercase: 1,
                uppercase: 1,
                numbers: 2,
                special: "$#%&-!?"
            }

            let error = inputObj.getElementsByClassName('form-error-text')[0]

            inputObj.getElementsByTagName('input')[0].addEventListener("keyup", (function() {
                return function() {

                    let error_msg = '';
                    let pass = inputObj.getElementsByTagName('input')[0].value

                    if ((pass.length < config.min) || pass.length > config.max) {
                        error_msg = `Actualmente ${pass.length} carácteres)`

                    } else if (view.checkPattern(pass, "ABCDEFGHIJKLMNOPQRSTUVWXYZ") < config.uppercase) {
                        error_msg = `La contrasenya ha de contenir mínim ${config.uppercase} lletra en majúscula`

                    } else if (view.checkPattern(pass, "abcdefghijklmnopqrstuvwxyz") < config.lowercase) {
                        error_msg = `La contrasenya ha de contenir mínim ${config.uppercase} lletra en minúscula`

                    } else if (view.checkPattern(pass, "1234567890") < config.numbers) {
                        error_msg = `La contrasenya ha de contenir mínim ${config.numbers} números`

                    } else {
                        error.style.color = '#999'
                        this.style.border = '1px solid #ced4da'
                        error_msg = null
                        error.innerHTML = ``;
                    }

                    if (error_msg != null) { //Si al final, no s'ha passat error_msg a null
                        error.style.color = 'tomato'
                        this.style.border = '1px solid red'
                        error.innerHTML = error_msg;
                    }
                }
            })());
        },
        //Metode per comprovar quantes vegades es repeteix un patro en un string
        checkPattern: function(word, patt) {
            let string = word
            let chars = patt
            let count = 0;
            //Per cada lletra/caracter, comrpovar si està en el patró
            for (i = 0; i < string.length; i++) {
                if (chars.indexOf(string.charAt(i)) != -1) { //Si hi ha coincidencia
                    count++
                }
            }
            return count
        },
        validatePass2: function(fieldPass1, fieldPass2) {

            let pass1 = fieldPass1.getElementsByTagName('input')[0]
            let error = fieldPass2.getElementsByClassName('form-error-text')[0]

            //Mentres escrigui -> eventListener per actualitzar Error
            fieldPass2.getElementsByTagName('input')[0].addEventListener("keyup", (function() {
                return function() {

                    let pass2 = fieldPass2.getElementsByTagName('input')[0]

                    if (pass1.value === pass2.value) {
                        error.style.color = '#999'
                        pass2.style.border = '1px solid #ced4da'
                        error.innerHTML = ``
                    } else {
                        error.style.color = 'tomato'
                        pass2.style.border = '1px solid red'
                        error.innerHTML = `Les contrasenyes no coincideixen`
                    }
                }
            })());
        },
        //Funcio per validar que un input de socail media no conte l'arrel
        validateSocialMedia: function(inputObj) {
            //Mentres escrigui -> eventListener per actualitzar Error
            inputObj.getElementsByTagName('input')[0].addEventListener("keyup", (function() {
                return function() {

                    //Capturar el valor del input
                    let inputString = inputObj.getElementsByTagName('input')[0]
                    let string = inputString.value;
                    //Reemplaçar inline els valors escapats del string
                    string = string.replace('linkedin.com/in/', '');
                    string = string.replace('github.com/', '');
                    string = string.replace('twitter.com/', '');
                    string = string.replace('facebook.com/', '');
                    string = string.replace('http', '');
                    string = string.replace(':', '');
                    string = string.replace('/', '');
                    string = string.replace('www.', '');
                    string = string.replace('<', '');
                    string = string.replace('>', '');
                    //Cambir el valor del input del formulari
                    inputString.value = string;
                }
            })());
            inputObj.getElementsByTagName('input')[0].addEventListener("focusout", (function() {
                return function() {

                    //Capturar el valor del input
                    let inputString = inputObj.getElementsByTagName('input')[0]
                    let string = inputString.value;
                    //Reemplaçar inline els valors escapats del string
                    let onlyUsername = false;
                    while (!onlyUsername) {
                        string = string.replace('linkedin.com/in/', '');
                        string = string.replace('github.com/', '');
                        string = string.replace('twitter.com/', '');
                        string = string.replace('facebook.com/', '');
                        string = string.replace('https', '');
                        string = string.replace('http', '');
                        string = string.replace(':', '');
                        string = string.replace('/', '');
                        string = string.replace('www.', '');
                        string = string.replace('<', '');
                        string = string.replace('>', '');
                        if (string.search('/') == -1) onlyUsername = true;
                    }
                    //Cambir el valor del input del formulari
                    inputString.value = string;
                }
            })());
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
        },
        listenCategoriesSelectors: function(categoriesDiv) {
            //Quan entri al camp del formulari, mostrar Ajuda i Errors
            categoriesDiv.addEventListener("focusin", (function() {
                return function() {
                    categoriesDiv.getElementsByClassName('form-warning-text')[0].style.display = 'block'
                }
            })());
            //Quan surti del camp del formulari, amagar Ajuda i Errors
            categoriesDiv.addEventListener("focusout", (function() {
                return function() {
                    categoriesDiv.getElementsByClassName('form-warning-text')[0].style.display = 'none'
                }
            })());
        }




    };
    controller.init();
}

window.onscroll = function() {

    //GESTIONAR QUE QUAN NO ESTIGUEM AL HOME NO ES CANVIIN ELS COLORS DEL MENU LATERAL
    let menuUser = document.getElementsByClassName('menu-user')

    if ((document.URL.search("/admin")) < 0) {

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

        for (i = 1; i <= 38; i++) {
            if ((winScroll > (menuUserPositions * (i - 1))) && (winScroll < (menuUserPositions * i))) {
                menuUser[0].style.bottom = (35 + i) + "%"

            }
        }
    }

}