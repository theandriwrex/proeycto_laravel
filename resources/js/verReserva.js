document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".enviar-correo").forEach(btn => {

        btn.addEventListener("click", async () => {

            const idReserva = btn.dataset.id;
            const email = btn.dataset.email;

            if (!idReserva) return;

            alert("Enviando correo de confirmación...");

            try {
                const response = await fetch(`/reservas/enviar-correo/${idReserva}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                if (data.success) {
                    alert("✔ Correo enviado correctamente a " + email);
                } else {
                    alert("❌ Error al enviar el correo: " + data.message);
                }

            } catch (error) {
                alert("⚠ Error AJAX: " + error);
            }

        });

    });

});
