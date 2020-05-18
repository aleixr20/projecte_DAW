Vue.component('componente-tarea', {
    template: `
    <section>
        <p>{{tarea.titol}}</p>
        <p>{{tarea.subtitol}}</p>
        <div>{{tarea.contingut}}</div>       
    </section>
    `,
    props: ['tarea'],
    data() {
        return {

        }
    },
});