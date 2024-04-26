// function showSuccessAlert(title, text, redirectUrl) {
//     Swal.fire({
//         icon: 'success',
//         title: title,
//         text: text
//     }).then(() => {
//         window.location.href = redirectUrl;
//     });
// }
// Show success alert function


function showSuccessAlert(title, text) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            // Reload the current page
            window.location.reload();
        }
    });
}

function showErrorAlert(title, text) {
    Swal.fire({
        icon: 'error',
        title: title,
        text: text
    });
}