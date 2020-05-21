function refresh() {

    // Rep text de HTML Editor 
    let code = document.getElementById("html-editor").value;
    let body = document.getElementById("viewer").contentWindow.document.getElementsByTagName("html")[0].getElementsByTagName("body")[0];

    // Comprova si hi ha styles
    if(document.getElementById("css-editor").value.length > 0){
        //Crea l'element style dintre del heade del iframe
        let head = document.getElementById("viewer").contentWindow.document.getElementsByTagName("html")[0].getElementsByTagName("head")[0];
        //Comprova si ja esta declarat l'element style
        let style;
        if(!document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0]){
            style = document.createElement("style");
            // Rep text de CSS Editor i incrusta tot al head
            style.textContent = document.getElementById("css-editor").value;
            head.appendChild(style);
        }else{
            style = document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0];
            style.textContent = document.getElementById("css-editor").value;
        }
    }else{
        if(document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0]){
            document.getElementById("viewer").contentWindow.document.getElementsByTagName("style")[0].remove();
        }
    }
    
    //Torna el codi
    body.innerHTML = code;

    // Comprova si hi ha scripts
    if(document.getElementById("js-editor").value.length > 0){
        //Crea l'element script dintre del heade del iframe
        let script = document.createElement("script");

        // Rep text de CSS Editor i incrusta tot al head
        script.textContent = document.getElementById("js-editor").value;
        body.appendChild(script);
    }
}
