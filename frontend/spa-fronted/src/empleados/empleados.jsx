import {useEffect, useState} from "react";
import api from "../api/api";

function Empleados(){
    //usamos useState para almacenar los empleados que obtenemos de la API
    // empleados es el estado que contiene la lista de empleados, 
    // y setEmpleados es la función para actualizar ese estado
    // inicializamos el estado con un array vacío, ya que al principio no tenemos datos
    //useState es un hook de React que nos permite agregar estado a nuestros componentes funcionales
    const [empleados, setEmpleados] = useState([]);
    const [editando, setEditando] = useState(false); // estado para controlar si estamos editando un empleado o no
    const [empleadoId, setEmpleadoId] = useState(null); // estado para almacenar el ID del empleado que estamos editando
    const [showModal, setShowModal] = useState(false); // estado para controlar la visibilidad del modal de confirmación de eliminación


    const [form, setForm] = useState({
        cedula_ruc : "",
        nombre : "",
        telefono :"",
        especialidad : "",
    });

    const getEmpleados = async () => {
        try {
            const res = await api.get("/empleados");
            setEmpleados(res.data);
        } catch (error) {
            console.error(error);
        }
    };

    useEffect(() => {
        // eslint-disable-next-line react-hooks/set-state-in-effect
        getEmpleados();
    }, []);
        


    const handleChange = (e) => { // es el evento que se dispara cuando el usuario cambia el valor de un campo del formulario 
        setForm({ // actualizamos el estado del formulario con el nuevo valor del campo que ha cambiado
            ...form,
            [e.target.name] : e.target.value 
        });

    };

    const nuevoempleado = () =>{ // creamos la estructura del modal para el nuevo empleado
        setForm({
            cedula_ruc: "",
            nombre: "",
            telefono: "",
            especialidad: "",

        });

        setEmpleadoId(null);
        setEditando(false);
        setShowModal(true);
    }

    const editarEmpleado = (empleado) => { // creamos una función para editar un empleado, que recibe como parámetro el empleado que queremos editar
        setForm({
            cedula_ruc : empleado.cedula_ruc,
            nombre : empleado.nombre,
            telefono : empleado.telefono,
            especialidad : empleado.especialidad,
        });
        setEmpleadoId(empleado.id); // almacenamos el ID del empleado que estamos editando
        setEditando(true); // cambiamos el estado a true para indicar que estamos editando un empleado 
        setShowModal(true); // mostramos el modal para editar el empleado
        
    };

    const storeEmpleado = async (e) => {
        e.preventDefault(); // evitamos que el formulario se envíe de forma tradicional, lo que recargaría la página
        await api.post("/empleados", form); // hacemos una peticion de tipo POST a la API para crear un nuevo empleado, enviando los datos del formulario")

        setForm({
            cedula_ruc : "",
            nombre : "",
            telefono :"",
            especialidad : "",  
        }); // limpiamos el formulario después de enviar los datos

        getEmpleados(); // actualizamos la lista de empleados después de agregar uno nuevo
    };


    const updateEmpleado = async (e) => {
        e.preventDefault(); // evitamos que el formulario se envíe de forma tradicional, lo que recargaría la página
        await api.put(`/empleados/${empleadoId}`,form); // hacemos una peticion de tipo PUT a la API para actualizar el empleado, enviando los datos del formulario y el ID del empleado que estamos editando
        try{
            alert("Empleado actualizado correctamente"); // mostramos una alerta para indicar que el empleado se ha actualizado correctamente

            setForm({
                cedula_ruc : "",
                nombre : "",
                telefono :"",
                especialidad : "",  
            }); // limpiamos el formulario después de enviar los datos

            setEditando(false); // cambiamos el estado a false para indicar que ya no estamos editando un empleado
            setEmpleadoId(null); // limpiamos el ID del empleado que estamos editando
            getEmpleados(); // actualizamos la lista de empleados después de actualizar uno
        }catch(error){
            console.error(error);
        }
    }

    const deleteEmpleado = async (id) => {
        try{
            await api.delete(`/empleados/${id}`); // hacemos una peticion de tipo DELETE a la API para eliminar el empleado, enviando el ID del empleado que queremos eliminar)
            alert("Empleado eliminado correctamente"); // mostramos una elerta para indicar que el empleado se ha eliminado correctamente
            getEmpleados(); // actualizamos la lista de empleados después de eliminar uno
        }catch(error){
            console.error(error);
            alert(error.response.data.message);
        }
    }

    return (
         
        <div className="min-h-screen bg-gray-100 p-6">
            <div className="max-w-7xl mx-auto">
                    <div className="bg-white rounded-xl shadow-md overflow-hidden">
                        <div className="p-4 border-b">
                            <h3 className="text-xl font-semibold">
                                Lista de Empleados
                            </h3>
                            <button style={{marginLeft: "1000px"}}
                                    onClick={nuevoempleado}// al hacer clic en el botón, cambiamos el estado mostrarModal a true para mostrar el modal de confirmación de eliminación
                                    className="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg"
                                >
                                Nuevo Empleado
                            </button>
                        </div>
                        <div className="overflow-x-auto">
                            
                            <table className="w-full">
                                <thead className="bg-gray-100">
                                    <tr>
                                        <th className="text-left p-4">ID</th>
                                        <th className="text-left p-4">Cédula</th>
                                        <th className="text-left p-4">Nombre</th>
                                        <th className="text-left p-4">Teléfono</th>
                                        <th className="text-left p-4">Especialidad</th>
                                        <th className="text-center p-4">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {empleados.map((emp) => (
                                        <tr
                                            key={emp.id}
                                            className="border-b hover:bg-gray-50 transition"
                                        >
                                            <td className="p-4">{emp.id}</td>
                                            <td className="p-4">{emp.cedula_ruc}</td>
                                            <td className="p-4">{emp.nombre}</td>
                                            <td className="p-4">{emp.telefono}</td>
                                            <td className="p-4">{emp.especialidad}</td>

                                            <td className="p-4">
                                                <div className="flex justify-center gap-2">
                                                    <button
                                                        onClick={() => editarEmpleado(emp)}
                                                        className="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg"
                                                    >
                                                        Editar
                                                    </button>

                                                    <button
                                                        onClick={() => deleteEmpleado(emp.id)}
                                                        className="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg"
                                                    >
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}

                                    {empleados.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan="6"
                                                className="text-center p-6 text-gray-500"
                                            >
                                                No hay empleados registrados
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            

                { showModal && (
                    <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

                    <div className="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">

                        <div className="flex justify-between items-center mb-6">
                            <h2 className="text-xl font-bold">
                                {editando ? "Editar Empleado" : "Nuevo Empleado"}
                            </h2>

                            <button
                                onClick={() => setShowModal(false)}
                                className="text-gray-500 hover:text-red-500 text-2xl"
                            >
                                ×
                            </button>
                        </div>

                        <form
                            onSubmit={editando ? updateEmpleado : storeEmpleado}
                            className="space-y-4"
                        >

                            <input
                                type="text"
                                name="cedula_ruc"
                                placeholder="Cédula o RUC"
                                value={form.cedula_ruc}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <input
                                type="text"
                                name="nombre"
                                placeholder="Nombre"
                                value={form.nombre}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <input
                                type="text"
                                name="telefono"
                                placeholder="Teléfono"
                                value={form.telefono}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <input
                                type="text"
                                name="especialidad"
                                placeholder="Especialidad"
                                value={form.especialidad}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <div className="flex justify-end gap-2">

                                <button
                                    type="button"
                                    onClick={() => setShowModal(false)}
                                    className="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg"
                                >
                                    Cancelar
                                </button>

                                <button
                                    type="submit"
                                    className={`px-4 py-2 rounded-lg text-white ${
                                        editando
                                            ? "bg-yellow-500 hover:bg-yellow-600"
                                            : "bg-green-600 hover:bg-green-700"
                                    }`}
                                >
                                    {editando ? "Actualizar" : "Guardar"}
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            )}
        </div>
    );   
}

export default Empleados;