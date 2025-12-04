document.addEventListener("DOMContentLoaded", () => {

    const tipoSelect = document.getElementById("tipo_habitacion");
    const habitacionSelect = document.getElementById("habitacion");
    const form = document.getElementById("formReserva");

    // -------------------------------
    // 1. CARGAR HABITACIONES POR TIPO
    // -------------------------------
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

           const habitaciones = data.data; // extraer el array real

            if (!habitaciones || habitaciones.length === 0) {
                habitacionSelect.innerHTML = `<option value="">No hay habitaciones disponibles</option>`;
                return;
            }

            // ⚠️ AQUÍ TAMBIÉN CAMBIA
            habitaciones.forEach(habitacion => {
                habitacionSelect.innerHTML += `
                    <option value="${habitacion.id}">
                        Habitación ${habitacion.numero}
                    </option>`;
            });

        } catch (error) {
            console.error("Error al cargar habitaciones:", error);
            habitacionSelect.innerHTML = `<option value="">Error al cargar</option>`;
        }
    });


    // ----------------------------------------------------------
    // 2. SI LA VISTA VIENE CON UN TIPO SELECCIONADO → AUTO-CARGA
    // ----------------------------------------------------------
    if (tipoSelect.value !== "") {
        const event = new Event("change");
        tipoSelect.dispatchEvent(event);
    }


    // --------------------------------
    // 3. VALIDACIÓN ANTES DEL ENVÍO
    // --------------------------------
    form.addEventListener("submit", (e) => {

        // Validación rápida por si el usuario no espera al servidor
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

        const entrada = document.getElementById("fecha_ingreso").value;
        const salida = document.getElementById("fecha_salida").value;

        if (entrada && salida && entrada >= salida) {
            e.preventDefault();
            showError("La fecha de salida debe ser mayor que la fecha de entrada.");
            return;
        }
    });


    // ---------------------------------------
    // 4. FUNCIÓN: MOSTRAR MENSAJE DE ERROR
    // ---------------------------------------
    function showError(message) {
        let errorDiv = document.querySelector(".error-message");

        if (!errorDiv) {
            errorDiv = document.createElement("div");
            errorDiv.classList.add("error-message");
            form.prepend(errorDiv);
        }

        errorDiv.innerHTML = message;

        // Animación suave
        errorDiv.style.opacity = "0";
        setTimeout(() => (errorDiv.style.opacity = "1"), 50);
    }
});
