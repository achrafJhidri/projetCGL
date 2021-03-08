

const selectField = document.getElementById('fournitures_in_Gamme');
const btnAddFourniture= document.getElementById('addFourniture');
const inputFourniture=document.getElementById('price');
const btnSubmit=document.getElementById('submitSimulation');
const divFournitres=document.getElementById("fournituresModifiees");

const fournitures = [];

selectField.addEventListener('change',() =>{
    const index = selectField.options.selectedIndex;
    inputFourniture.value = selectField.options[index].dataset.price;
    inputFourniture.disabled = btnAddFourniture.disabled  = parseInt(selectField.options[index].dataset.isupdateable) === 0 ;
})



btnAddFourniture.addEventListener('click',() =>{
    const indexOption = selectField.options.selectedIndex;

    if(parseInt(selectField.options[indexOption].dataset.price) !== parseFloat(inputFourniture.value) ){

        const obj = {
            idFourniture :  selectField.options[indexOption].value,
            price : inputFourniture.value
        }


        const index = fournitures.findIndex(element => element.idFourniture === obj.idFourniture);

        const span = document.createElement("span");
        span.className="d-inline mr-3 ";

        const spanClose= document.createElement("span");
        spanClose.className = "badge badge-secondary ml-2";
        spanClose.setAttribute("role", "button")

        const i = document.createElement("i");
        i.className = "fas fa-times";
        spanClose.append(i);

        const spanContent = document.createElement('span');
        spanContent.innerText = "{fourniture: "+selectField.options[indexOption].text+", prix: "+obj.price+"}";

        if (index === -1){
            fournitures.push(obj);

            span.append(spanContent, spanClose);

            divFournitres.insertBefore(span, divFournitres.firstChild);

            spanContent.setAttribute("id", "fourniture"+(fournitures.length-1)+"-price")
            spanClose.setAttribute("id", "close"+(fournitures.length-1)+"");

            const btnClose = document.getElementById("close"+(fournitures.length-1)+"");
            btnClose.addEventListener('click',(event)=>{
                btnClose.parentElement.remove();
                fournitures.splice(fournitures.length-1);
            });
        }else
        {
            fournitures[index] = obj;
            const updateSpan = document.getElementById("fourniture"+index+"-price")
            console.log(updateSpan);
            updateSpan.textContent = "{fourniture: "+selectField.options[indexOption].text+", price: "+obj.price+"}";
        }
    }
})

btnSubmit.addEventListener('click',(event)=>{
    event.preventDefault();

    const lesTD = document.querySelectorAll("td:nth-child(4)");
    lesTD.forEach(element =>{
        let buyPrice = 0 ;
        element.dataset.fournitures.split("-").forEach(fourniture => {
            let obj =  JSON.parse(fourniture) ;
            if (!obj.isUpdatable){//si ce n'est pas modifiable on prend le prix de base
                buyPrice = buyPrice+obj.originalPrice*obj.quantite;
            }
            else { //si c'est modifiable
                const index = fournitures.findIndex(fourniure => parseInt(fourniure.idFourniture) === obj.idFourniture);
                if(index !== -1){ // si il a modifier le prix de la fourniture
                    buyPrice=buyPrice+obj.quantite*fournitures[index].price;
                }else { //sinon
                    buyPrice = buyPrice+obj.originalPrice*obj.quantite;
                }
            }
        })
        element.innerHTML=buyPrice.toFixed(2);
        element.nextElementSibling.innerHTML=(parseFloat(element.previousElementSibling.innerHTML)-buyPrice).toFixed(2)
    });
})