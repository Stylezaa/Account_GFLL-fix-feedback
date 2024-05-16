export const swalSuccess = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        customClass: {
            container: 'swalZ-index'
        }
    })
}
export const swalError = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        customClass: {
            container: 'swalZ-index'
        }
    })
}

export const swalWarning = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        customClass: {
            container: 'swalZ-index'
        }
    })
}

export const swalSuccessToast = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        toast: true,
        timer: 3000,
        showConfirmButton: false,
        position: 'top-right',
        timerProgressBar: true,
        customClass: {
            container: 'swalZ-index'
        }
    })
}

export const swalWarningToast = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: 'red',
        color: 'white',
        customClass: {
            container: 'swalZ-index'
        }
    })
}

export const swalErrorToast = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: "error",
        toast: true,
        position: "top-right",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: 'red',
        color: 'white',
        customClass: {
            container: 'swalZ-index'
        }
    })
}



export const closeSwal = () => {
    Swal.hideLoading()
    Swal.close()
}

export const swalLoading = ( title, text, icon) => {
    let timerInterval
    Swal.fire({
        title:  title,
        html: 'ຈະປິດໜ້າຕ່າງພາຍໃນ <b></b> ວິນາທີ.',
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
    })
}

export const swalConfirm = (title, text, callbackFunction = Function) =>{
   Swal.fire({
       title:title,
       text:text,
       icon:'question',
       timer:7000,
       timerProgressBar:true,
       showConfirmButton:true,
       confirmButtonText:'ຕົກລົງ',
       showCancelButton:true,
       cancelButtonText:'ຍົກເລີກ',
   }).then((rs)=>{
       if (rs.isConfirmed){
           callbackFunction()
       }
   })
}
