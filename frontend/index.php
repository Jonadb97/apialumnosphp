<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Alumnos</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
</head>

<body style="margin: 2rem;">
    <h1>API Alumnos</h1>

    <div id="app">
        <h1>Alumnos</h1>
        Total alumnos: <strong>{{ alumnos.length }}</strong>
        <hr>
        <form @submit.prevent="crearAlumno()">
            Nombres:
            <input type="text" v-model="nuevoAlumno.nombres" name="nombres" id="nombres">
            Apellidos:
            <input type="text" v-model="nuevoAlumno.apellidos" name="apellidos" id="apellidos">
            <button type="submit" class="btn btn-success" style="margin-left: 1rem;">Agregar +</button>
        </form>
        <hr>
        <ul>
            <li v-for="alumno in alumnos" :key="alumno.id" style="margin-top: 0.5rem; margin-bottom: 0.5rem; width: 100%;display: flex;">
                {{ alumno.nombres }} - {{ alumno.apellidos }}
                <button class="btn btn-error" style="margin-left: auto;" @click="eliminarAlumno(alumno.id)">Eliminar</button>
            </li>
        </ul>
    </div>


    <script>
        const {
            createApp,
            ref,
            onMounted
        } = Vue;

        const baseURL = '../backend/';

        const app = createApp({
            setup() {
                const alumnos = ref([]);
                const nuevoAlumno = ref({
                    nombres: '',
                    apellidos: ''
                });

                const obtenerAlumnos = async () => {
                    const response = await axios.get(baseURL + 'allalumnos')
                    alumnos.value = response.data;
                };

                const crearAlumno = async () => {
                    try {
                        const response = await axios.post(baseURL + 'crearalumno', nuevoAlumno.value);
                        alumnos.value.push(response.data);
                        nuevoAlumno.value = {
                            nombres: "",
                            apellidos: ""
                        };
                        obtenerAlumnos();

                    } catch (error) {
                        console.log("Error al instertar");
                    }

                };

                const eliminarAlumno = async (id) => {
                    try {
                        await axios.delete(`${baseURL}${id}`);
                        obtenerAlumnos();

                    } catch (error) {
                        console.log("Error al instertar");
                    }

                };

                onMounted(() => {
                    obtenerAlumnos();
                });

                return {
                    alumnos,
                    crearAlumno,
                    nuevoAlumno,
                    eliminarAlumno
                };
            }
        });


        app.mount('#app');
    </script>
</body>

</html>