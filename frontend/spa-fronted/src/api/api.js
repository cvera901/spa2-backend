import axios from "axios"; // Importar la biblioteca axios para realizar solicitudes HTTP

const api = axios.create({ // Crear una instancia de axios con una configuración personalizada
  baseURL: "http://127.0.0.1:8000/api", // Establecer la URL base para todas las solicitudes a la API
});

export default api; // Exportar la instancia de axios para que pueda ser utilizada en otros archivos de la aplicación