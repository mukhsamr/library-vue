import { usePage } from '@inertiajs/inertia-vue3'
import Swal from 'sweetalert2'

export default function (obj = null) {

    const alert = usePage().props.value.alert

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    const message = alert?.status == 'success'
        ? 'Berhasil '
        : 'Gagal '

    const options = obj ?? {
        icon: alert.status,
        title: message + alert.msg
    };

    Toast.fire(options)
}