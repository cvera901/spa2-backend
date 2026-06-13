import {useEffect, useState} from "react";
import api from "../api/api";

//creamos la funcion para generear el codigo
function Servicios(){
    const [servicios, SetServicios] = useState([]);
    const [editando, setEditando] = useState(false);
    const [servicioId, setServicioId] = useState(null);
    const [showModal, setShowModal] = useState(false);

    const [form, setForm] = useState({ // se crea el formulario 
        nombre: "",
        precio: "",
        duracion: "",
        descripcion: "",
    });

    const getServicios = async () => { // constante usado para tomar los servicios desde la api
        try{
            const res = await api.get("/servicios"); // se llama a la consulta get
            SetServicios(res.data); // almacenar el servicio 
        }catch(error){
            console.error(error);
        }
    };

    useEffect(()=>{
        // eslint-disable-next-line react-hooks/set-state-in-effect
        getServicios();
    },[]);

    const handleChange = (e) => { // se dispara una vez que se cambia el valor de algun input
        setForm({
            ...form,
            [e.target.name] : e.target.value
        });
    }

    const nuevoServicio = () =>{ // estructura para un nuevo servicio, modal
        setForm({
            nombre: "",
            precio: "",
            duracion:"",
            descripcion:"",
        });

      setServicioId(null);
      setEditando(false);
      setShowModal(true);
    }

    const editarServicio = (servicio) => {
        setForm({
            nombre: servicio.nombre,
            precio: servicio.precio,
            duracion: servicio.duracion,
            descripcion: servicio.descripcion,
        });
        setServicioId(servicio.id); // tomamos el id del servicio a ser modificado
        setEditando(true); //habilitamos el estado para la modificacion
        setShowModal(true); // abrimos el modal
    }

    const storeServicio = async (e) => { // funcion de nuevo servicio
        e.preventDefault();
        await api.post("/servicios",form);
        alert("Se ha creado un nuevo servicio")
        setForm({
            nombre: "",
            precio: "",
            duracion: "",
            descripcion:"",

        }); // se procede a limpiar el formulario
        
        getServicios();
        setShowModal(false);
    }

    const updateServicios = async (e) => {
        e.preventDefault();
        await api.put(`/servicios/${servicioId}`,form);
        try{
         alert("Servicio actualizado correctamente");
         setForm({
            nombre: "",
            precio: "",
            duracion: "",
            descripcion: "",
         }); // se limpia el formulario despues de enviar los datos actualizados
         setEditando(false); //cambiamos el estado de editar a falso
         setServicioId(null); // limpiamos el id recibido
         getServicios(); //actualizamos los servicios disponibles
        
        }catch(error){
            console.error(error);
        }

    }

    const deleteServicio = async (id) =>{
        try{
            await api.delete(`/servicios/${id}`); //llamamos a la funcion eliminar
            alert("Se ha eliminado de manera correcta el servicio");
            getServicios(); // actualizar la tabla de servicios
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
                                Lista de Servicios
                            </h3>
                            <button style={{marginLeft: "1000px"}}
                                    onClick={nuevoServicio}// al hacer clic en el botón, cambiamos el estado mostrarModal a true para mostrar el modal de confirmación de eliminación
                                    className="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg"
                                >
                                Nuevo Servicio
                            </button>
                        </div>
                        <div className="overflow-x-auto">
                            
                            <table className="w-full">
                                <thead className="bg-gray-100">
                                    <tr>
                                        <th className="text-left p-4">ID</th>
                                        <th className="text-left p-4">Nombre</th>
                                        <th className="text-left p-4">Precio</th>
                                        <th className="text-left p-4">Duracion</th>
                                        <th className="text-left p-4">Descripcion</th>
                                        <th className="text-center p-4">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {servicios.map((serv) => (
                                        <tr
                                            key={serv.id}
                                            className="border-b hover:bg-gray-50 transition"
                                        >
                                            <td className="p-4">{serv.id}</td>
                                            <td className="p-4">{serv.nombre}</td>
                                            <td className="p-4">{serv.precio}</td>
                                            <td className="p-4">{serv.duracion}</td>
                                            <td className="p-4">{serv.descripcion}</td>

                                            <td className="p-4">
                                                <div className="flex justify-center gap-2">
                                                    <button
                                                        onClick={() => editarServicio(serv)}
                                                        className="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg"
                                                    >
                                                        Editar
                                                    </button>

                                                    <button
                                                        onClick={() => deleteServicio(serv.id)}
                                                        className="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg"
                                                    >
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}

                                    {servicios.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan="6"
                                                className="text-center p-6 text-gray-500"
                                            >
                                                No hay servicios disponibles
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
                                {editando ? "Editar Servicio" : "Nuevo Servicio"}
                            </h2>

                            <button
                                onClick={() => setShowModal(false)}
                                className="text-gray-500 hover:text-red-500 text-2xl"
                            >
                                ×
                            </button>
                        </div>

                        <form
                            onSubmit={editando ? updateServicios : storeServicio}
                            className="space-y-4"
                        >

                            <input
                                type="text"
                                name="nombre"
                                placeholder="Nombre del Servicio"
                                value={form.nombre}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <input
                                type="number"
                                name="precio"
                                placeholder="Precio del Servicio"
                                value={form.precio}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <input
                                type="text"
                                name="duracion"
                                placeholder="Duracion del Servicio"
                                value={form.duracion}
                                onChange={handleChange}
                                className="w-full border rounded-lg px-4 py-2"
                            />

                            <input
                                type="text"
                                name="descripcion"
                                placeholder="Descripcion del Servicio"
                                value={form.descripcion}
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

export default Servicios;