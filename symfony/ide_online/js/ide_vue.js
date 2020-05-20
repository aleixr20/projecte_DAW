new Vue({
    //Indicamos el ID del Div que contiene la APP Vue
    el: '#app',
    data: {
        input_html: "",
        input_css: "",
        input_js: "",

        resultado: "",
    },
    mounted() {

    },
    methods: {
        mostrarHtml: function() {
            //Este boton deberia mostrar textarea HTML y ocultar los otros dos
            //Cambiar la classe del textarea de col-4 a col-12
            //Cambiar los otros dos textarea de col-4 a d-none
        },
        mostrarCss: function() {
            //Este boton deberia mostrar textares CSS y ocultar los otros dos
            //Cambiar la classe del textarea de col-4 a col-12
            //Cambiar los otros dos textarea de col-4 a d-none
        },
        mostrarJs: function() {
            //Este boton deberia mostrar textares JAVSCRIPT y ocultar los otros dos
            //Cambiar la classe del textarea de col-4 a col-12
            //Cambiar los otros dos textarea de col-4 a d-none
        },
        cargarFrame: function(input_html, input_css, input_js) {
            console.log(input_html);
            console.log(input_css);
            console.log(input_js);

            this.input_html = input_html;
            this.input_css = input_css;
            this.input_js = input_js

            //Crear cabezera HTML
            // let html = `
            // <!DOCTYPE html>
            // <html lang="en">

            // <head>
            //     <meta charset="UTF-8">
            //     <meta name="viewport" content="width=device-width, initial-scale=1.0">
            //     <title>iFrame Sample</title>
            //     `
            //Añadir STYLE
            let html = `<style>\n${this.input_css}\n</style>\n${this.input_html}\n<script>\n${this.input_js}\n</script>\n`

            //Añadir HTML
            // html += `${input_html}\n`

            //Añadir JAVASCRIPT
            // html += `<script>\n${input_js}\n</script>\n`

            //Cerrar HTML
            // html += `</body>\n</html>`
            resultado = html;
            console.log(resultado)
        },
    }
});