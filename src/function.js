import { useAuthStore } from "./auth";
import Swal from "sweetalert2";

export function show_alert(msj, icon, redirect) {
    if (redirect != '') {
        Swal.fire({
            title: msj, icon: icon,
            showConfirmButton: false,
        });
    } else {
        Swal.fire({
            title: msj, icon: icon,
        });
    }
}

export async function confirmation(name, url, redirect, callback) {
    const alert = Swal.mixin({ buttonsStyling: true });
    let status;
    let list_errors;

    const result = await alert.fire({
        title: '¿Estás seguro de eliminar a ' + name + ' ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        const response = await sendRequest('DELETE', {}, url, redirect);
        if (response.status == 422) {
            show_alert(response.error, 'error', redirect);
        }
        else if (!redirect && callback) {
            callback();
        }
    }
}

export async function sendRequest(method, params, url, redirect = '') {
    const authStore = useAuthStore();
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;
    let status;
    let list_errors;
    let error;
    let responseData;
    await axios({ method: method, url: url, data: params }).then(
        response => {
            status = response.status,
                responseData = response.data,
                show_alert(response.data.message, 'success', redirect),
                setTimeout(
                    () => (redirect !== '') ? window.location.href = redirect : '', 2000
                )
        }).catch(
            (errors) => {
                status = errors.response.status;
                list_errors = errors.response.data.errors;
                error = errors.response.data.error

                if (!list_errors && error) {
                    show_alert(error, 'error', redirect);
                }
            })
    return { status, list_errors, error, responseData };
}