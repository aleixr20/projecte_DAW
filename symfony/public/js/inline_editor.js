function refresh() {

    var htmlEditor = ace.edit("html-editor");
    htmlEditor.setTheme("ace/theme/monokai");
    htmlEditor.session.setMode("ace/mode/html");

    var cssEditor = ace.edit("css-editor");
    cssEditor.setTheme("ace/theme/monokai");
    cssEditor.session.setMode("ace/mode/css");

    var jsEditor = ace.edit("js-editor");
    jsEditor.setTheme("ace/theme/monokai");
    jsEditor.session.setMode("ace/mode/javascript");

    // Rep text de HTML Editor 
    let code = htmlEditor.getValue();
    let body = document.getElementById("viewer").contentWindow.document.getElementsByTagName("html")[0].getElementsByTagName("body")[0];

    // Comprova si hi ha styles
    if(cssEditor.getValue().length > 0){
        //Crea l'element style dintre del heade del iframe
        let head = document.getElementById("viewer").contentWindow.document.getElementsByTagName("html")[0].getElementsByTagName("head")[0];
        //Comprova si ja esta declarat l'element style
        let style;
        if(!document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0]){
            style = document.createElement("style");
            // Rep text de CSS Editor i incrusta tot al head
            style.textContent = cssEditor.getValue();
            head.appendChild(style);
        }else{
            style = document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0];
            style.textContent = cssEditor.getValue();
        }
    }else{
        if(document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0]){
            document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0].remove();
        }
    }
    
    //Torna el codi
    body.innerHTML = code;

    // Comprova si hi ha scripts
    if(jsEditor.getValue().length > 0){
        //Crea l'element script dintre del heade del iframe
        let script = document.createElement("script");

        // Rep text de CSS Editor i incrusta tot al head
        script.textContent = jsEditor.getValue();
        body.appendChild(script);
    }
}
