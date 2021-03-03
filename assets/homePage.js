

const closeAlertButton = document.getElementById("closeAlertSucces");

if (closeAlertButton){
    closeAlertButton.addEventListener('click', () =>{
        closeAlertButton.parentElement.remove();
    })
}
