const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

$(document).ready(function (){
   const successToast = $('#toast-success');
   const errorToast = $('#toast-error');

   if (successToast.length){
       let text = successToast.text();
       if (text){
           Toast.fire({
               icon: 'success',
               title: text
           })
       }
   }

   if (errorToast.length){
       let text =  errorToast.text();
       if (text){
           Toast.fire({
               icon: 'error',
               title: text
           })
       }
   }
});
