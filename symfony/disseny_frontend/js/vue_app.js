new Vue({
    //Indicamos el ID del Div que contiene la APP Vue
    el: '#app',
    data: {
        results: {},
    },
    mounted() {
        this.listarTodasTareas();
    },
    methods: {
        listarTodasTareas: function() {
            axios.get(`http://localhost:8000/homepage`)
                .then(response => {
                    this.results = response.data;
                    console.log(response)
                    console.log(this.results)
                });
        },
    }
});