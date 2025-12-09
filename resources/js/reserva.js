document.addEventListener("DOMContentLoaded", () => {

    const tipoSelect = document.getElementById("tipo_habitacion");
    const habitacionSelect = document.getElementById("habitacion");
    const form = document.getElementById("formReserva");

    const fechaIngreso = document.getElementById("fecha_ingreso");
    const fechaSalida = document.getElementById("fecha_salida");
    const precioTotalDiv = document.getElementById("precio-total");


    const serviciosCheckboxes = document.querySelectorAll("input[name='servicios[]']");

  
    const tarifasServicios = {
        desayuno: 20000,
        spa: 45000,
        parqueadero: 10000,
        mascotas: 35000,
        transporte: 50000
    };

  
    tipoSelect.addEventListener("change", async () => {
        const tipoId = tipoSelect.value;

        habitacionSelect.innerHTML = `<option value="">Cargando...</option>`;

        if (!tipoId) {
            habitacionSelect.innerHTML = `<option value="">Seleccione un tipo primero</option>`;
            return;
        }

        try {
            const response = await fetch(`/reservas/habitaciones/${tipoId}`);
            const data = await response.json();

            habitacionSelect.innerHTML = "";

            const habitaciones = data.data;

            if (!habitaciones || habitaciones.length === 0) {
                habitacionSelect.innerHTML = `<option value="">No hay habitaciones disponibles</option>`;
                return;
            }

            habitaciones.forEach(habitacion => {
                habitacionSelect.innerHTML += `
                    <option value="${habitacion.id}">
                        Habitación ${habitacion.numero}
                    </option>`;
            });

            calcularPrecio();

        } catch (error) {
            console.error("Error al cargar habitaciones:", error);
            habitacionSelect.innerHTML = `<option value="">Error al cargar</option>`;
            alert("Error al cargar habitaciones: " + error.message);
        }

    });

  
    if (tipoSelect.value !== "") {
        tipoSelect.dispatchEvent(new Event("change"));
    }

    function calcularPrecio() {

        const opcionTipo = tipoSelect.options[tipoSelect.selectedIndex];

        if (!opcionTipo) {
            precioTotalDiv.textContent = "COP $0";
            return;
        }

        const precioPorNoche = opcionTipo.getAttribute("data-precio");

        if (!precioPorNoche) {
            precioTotalDiv.textContent = "COP $0";
            return;
        }

        const ingreso = new Date(fechaIngreso.value);
        const salida = new Date(fechaSalida.value);

        let total = 0;

    
        if (fechaIngreso.value && fechaSalida.value && salida > ingreso) {
            const diferenciaDias = Math.ceil((salida - ingreso) / (1000 * 60 * 60 * 24));
            total += diferenciaDias * precioPorNoche;
        }

       
        serviciosCheckboxes.forEach(chk => {
            if (chk.checked) {
                total += tarifasServicios[chk.value] || 0;
            }
        });

        
        precioTotalDiv.textContent = `COP $${Number(total).toLocaleString("es-CO")}`;
    }

  
    tipoSelect.addEventListener("change", calcularPrecio);
    fechaIngreso.addEventListener("change", calcularPrecio);
    fechaSalida.addEventListener("change", calcularPrecio);

  
    serviciosCheckboxes.forEach(chk =>
        chk.addEventListener("change", calcularPrecio)
    );

 


    form.addEventListener("submit", (e) => {

        if (!tipoSelect.value) {
            e.preventDefault();
            showError("Debe seleccionar un tipo de habitación.");
            return;
        }

        if (!habitacionSelect.value) {
            e.preventDefault();
            showError("Debe seleccionar una habitación disponible.");
            return;
        }

        const entrada = fechaIngreso.value;
        const salida = fechaSalida.value;

        if (entrada && salida && entrada >= salida) {
            e.preventDefault();
            showError("La fecha de salida debe ser mayor que la fecha de entrada.");
            return;
        }
    });

 
    function showError(message) {
        let errorDiv = document.querySelector(".error-message");

        if (!errorDiv) {
            errorDiv = document.createElement("div");
            errorDiv.classList.add("error-message");
            form.prepend(errorDiv);
        }

        errorDiv.innerHTML = message;
        errorDiv.style.opacity = "0";
        setTimeout(() => (errorDiv.style.opacity = "1"), 50);
    }
});
