import './styles/newProduct.scss';
let Routing = require('../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js')
let Route = require('./js-routes.json')
//console.log(Route)
Routing.setRoutingData(Route);
//console.log(Routing.generate("produit_create"));
//console.log(Routing.generate("produit_edit", {id:5}))

const fournitureSelect = document.querySelector("#produit_produitFournitures");
const ajouterUneQuantite = document.querySelector("#add-quantite");
const gammeSelect = document.getElementById('produit_gamme');
const quantiteInput = document.getElementById("input-quantite");
const btnEnregistrer = document.getElementById("produit_Sauvegarder");

const containerProducts = document.getElementById("container-added-product");
const containerFournitureQuantite = document.getElementById("fournitures-quantite");
let tabFournitureProduits = [];

const lenghtProducts = document.getElementById("lenght-products");
//console.log(lenghtProducts.textContent);

/********************************************************************************
        Au chargement de la page, on vérifie s'il existe déja une liste de fourniture
********************************************************************************/
window.addEventListener('load', ()=>{
    const children = containerFournitureQuantite.children;
    if(children.length>0)
    {
        gammeSelect.disabled = true;
        for(let i = 0; i < children.length; i++)
        {
            console.log(containerFournitureQuantite.children[i]);
            let obj = {
                id_fourniture: containerFournitureQuantite.children[i].dataset.idfourniture,
                quantite:containerFournitureQuantite.children[i].dataset.quantite
            }
            tabFournitureProduits.push(obj);
            const btnClose = document.getElementById("close"+(tabFournitureProduits.length-1)+"");
            btnClose.addEventListener('click',(event)=>{
                btnClose.parentElement.remove();
                tabFournitureProduits.splice(tabFournitureProduits.length-1);
                if(tabFournitureProduits.length === 0){
                    gammeSelect.disabled = false;
                }
            });
        }

    }
});

ajouterUneQuantite.addEventListener('click', (event)=>{
    if(!quantiteInput.value || quantiteInput.value <= 0)
    {
        alert("Quantité non valide !");
    }
    else
    {
        gammeSelect.disabled = true; //on désactive les gammes

        let obj = {
            id_fourniture:fournitureSelect.value,
            quantite:quantiteInput.value
        }
        const index =  tabFournitureProduits.findIndex(element => element.id_fourniture === obj.id_fourniture);

        const span = document.createElement("span");
        span.className="d-inline mr-3 ";


        const spanClose= document.createElement("span");
        spanClose.className = "badge badge-secondary ml-2";
        spanClose.setAttribute("role", "button")

        const i = document.createElement("i");
        i.className = "fas fa-times";
        spanClose.append(i);

        const spanContent = document.createElement('span');
        spanContent.innerText = "{fourniture: "+fournitureSelect.options[fournitureSelect.selectedIndex].text+", quantite: "+obj.quantite+"}";

        //console.log(index);
        if(index === -1)
        {
            tabFournitureProduits.push(obj);
            span.append(spanContent, spanClose);
            containerFournitureQuantite.insertBefore(span, containerFournitureQuantite.firstChild);
            spanContent.setAttribute("id", "fourniture"+(tabFournitureProduits.length-1)+"-quantity")
            spanClose.setAttribute("id", "close"+(tabFournitureProduits.length-1)+"");

            const btnClose = document.getElementById("close"+(tabFournitureProduits.length-1)+"");
            btnClose.addEventListener('click',(event)=>{
                btnClose.parentElement.remove();
                tabFournitureProduits.splice(tabFournitureProduits.length-1);
                if(tabFournitureProduits.length === 0){
                    gammeSelect.disabled = false;
                }
            });
        }
        else
        {
            const conf = confirm("Souhaitez-vous écraser l'ancienne quantité?");
            if(conf)
            {
                tabFournitureProduits[index] = obj;
                console.log("fourniture"+index+"-quantity")
                const updateSpan = document.getElementById("fourniture"+index+"-quantity")
                console.log(updateSpan);
                updateSpan.textContent = "{fourniture: "+fournitureSelect.options[fournitureSelect.selectedIndex].text+", quantite: "+obj.quantite+"}";
            }
        }
        console.log(tabFournitureProduits);
    }
})
const spinner = document.getElementById("spinner");
//spinner.style.visibility='hidden';
function showSpinner() {
    spinner.classList.add('show')
    setTimeout(() => {
        spinner.classList.remove("show");
    }, 2000);
}

btnEnregistrer.addEventListener('click', (event)=>{
    event.preventDefault();
    if(!gammeSelect.disabled){
        alert("Vous êtes un petit malin hein, vous avez modifie une propriete donc impossible de soumettre le formulaire reactialise la page et faite les choses bien svp!");
    }
    else {
        //console.log(document.forms.produit);
        const formSubmit = document.forms.produit;
        let form = new FormData();
        form.append('name', formSubmit.elements["produit[name]"].value );
        form.append('price', formSubmit.elements["produit[sellPrice]"].value );
        form.append('gamme', formSubmit.elements["produit[gamme]"].value);
        form.append("fournitureProduit", JSON.stringify(tabFournitureProduits));


        const hdr = new Headers();
        hdr.append('X-Requested-With', 'XMLHttpRequest');
        showSpinner(); //show spinner

        fetch(formSubmit.getAttribute('action'), {method: 'POST', headers: hdr ,body: form}).then(
            (response) => {
                if(response.ok) {
                    response.json().then(resultat=>{
                        printNewProduct(resultat);
                        tabFournitureProduits = []; //reset tab
                        lenghtProducts.innerText = (parseInt(lenghtProducts.textContent,10) + 1)+"";
                        document.forms.produit.reset();
                        gammeSelect.disabled=false; //reactiver le champs gamme
                    }).catch((error)=>console.log(error))
                } else {
                    alert('Mauvaise réponse du réseau !');
                }
            }).catch((error)=>{
            console.log(error);
        })
    }

})

const printNewProduct = (product) =>{
    const productToJson = JSON.parse(product);
    //console.log(productToJson)
    const tr = document.createElement('tr');
    tr.append(
        makeTd(document.createTextNode(productToJson.name)),
        makeTd(document.createTextNode(productToJson.sellPrice)),
        makeTd(document.createTextNode(productToJson.gamme.name))
    );

    productToJson.produitFournitures.forEach(elem => {
        //console.log(elem.quantite);
        const span = document.createElement('span');
        const br = document.createElement('br');
        const spanContent = document.createTextNode(elem.fourniture.name + ": "+ elem.quantite)
        span.append(spanContent)
        tr.append(spanContent,br);
    });
    containerProducts.insertBefore(tr, containerProducts.firstChild)
}
const makeTd = (content) => {
    const td = document.createElement('td');
    td.append(content);
    return td;
}


/*******************************************************************/
const selectGamme = document.getElementById('produit_gamme');
const spinnerFourniture = document.getElementById('spinner-fourniture');

selectGamme.addEventListener('change', (event)=> {
    const idGamme = selectGamme.value;

    const url = Routing.generate("get_fourniture_by_gamme");

    const headers = new Headers();
    headers.append('X-Requested-With', 'XMLHttpRequest');
    headers.append('idGamme', idGamme)

    fetch(url, {method: 'GET', headers: headers }).then(
        (response) => {
            if(response.ok) {
                response.json().then(resultat=>{
                    const ressultData = JSON.parse(resultat);
                    if(ressultData.status !== 200 ){
                        alert(ressultData.message);
                    }else {
                        updateFournitures(ressultData.data);
                    }
                }).catch((error)=>console.log(error))
            } else {
                alert('Mauvaise réponse du réseau !');
            }
        }).catch((error)=>{
        console.log(error);
    })

})

const updateFournitures = (data) => {
    removeAllChildNodes(fournitureSelect)
    data.forEach(element=> {
            fournitureSelect.append(makeOptionToSelect(element.id, element.name));
    })
}

const makeOptionToSelect = (value, text) => {
    const elementOption = document.createElement('option');
    elementOption.setAttribute('value', value);

    elementOption.innerText = text;
    return elementOption;
}
const removeAllChildNodes = (parent) => {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}