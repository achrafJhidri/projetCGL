import './styles/newProduct.scss';
let Routing = require('../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js')
let Route = require('./js-routes.json')

Routing.setRoutingData(Route);
//console.log(Routing.generate("produit_create"));

const fournitureSelect = document.querySelector("#produit_produitFournitures");
const ajouterUneQuantite = document.querySelector("#add-quantite");
const quantiteInput = document.getElementById("input-quantite");
const btnEnregistrer = document.getElementById("produit_Sauvegarder le produit");

const containerProducts = document.getElementById("container-added-product");
const containerFournitureQuantite = document.getElementById("fournitures-quantite");
let tabFournitureProduits = [];

const lenghtProducts = document.getElementById("lenght-products");
//console.log(lenghtProducts.textContent);


ajouterUneQuantite.addEventListener('click', (event)=>{
    if(!quantiteInput.value || quantiteInput.value <= 0)
    {
        alert("Quantité non valide !");
    }
    else
    {
        let obj = {
            id_fourniture:fournitureSelect.value,
            quantite:quantiteInput.value
        }
        const index =  tabFournitureProduits.findIndex(element => element.id_fourniture === obj.id_fourniture);

        const span = document.createElement("span");
        span.className="d-inline mr-3 "


        const spanClose= document.createElement("span");
        spanClose.className = "badge badge-secondary ml-2";
        spanClose.setAttribute("role", "button")

        const i = document.createElement("i");
        i.className = "fas fa-times";

        spanClose.append(i);
        const spanContent = document.createTextNode("{fourniture: "+fournitureSelect.options[fournitureSelect.selectedIndex].text+", quantite: "+obj.quantite+"}");

        //console.log(index);
        if(index === -1)
        {

            tabFournitureProduits.push(obj);
            span.append(spanContent, spanClose);
            containerFournitureQuantite.insertBefore(span, containerFournitureQuantite.firstChild);
            span.setAttribute("id", "fourniture"+(tabFournitureProduits.length-1)+"-quantity")
            spanClose.setAttribute("id", "close"+(tabFournitureProduits.length-1)+"");

            const btnClose = document.getElementById("close"+(tabFournitureProduits.length-1)+"");
            btnClose.addEventListener('click',(event)=>{
                btnClose.parentElement.remove();
                tabFournitureProduits.splice(tabFournitureProduits.length-1);
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
                updateSpan.innerHTML = "{fourniture: "+fournitureSelect.options[fournitureSelect.selectedIndex].text+", quantite: "+obj.quantite+"}";
                updateSpan.append(spanClose);
            }
        }
        console.log(tabFournitureProduits);
    }
})

btnEnregistrer.addEventListener('click', (event)=>{
    event.preventDefault();
    //console.log(document.forms.produit);
    const formSubmit = document.forms.produit;
    let form = new FormData();
    form.append('name', formSubmit.elements["produit[name]"].value );
    form.append('price', formSubmit.elements["produit[sellPrice]"].value );
    form.append('gamme', formSubmit.elements["produit[gamme]"].value);
    form.append("fournitureProduit", JSON.stringify(tabFournitureProduits));
    /*for (var value of form.values()) {
        console.log(value);
     }*/
    //console.log(form);
    const url = Routing.generate("produit_create");
    //console.log(url);

    const hdr = new Headers();
    hdr.append('X-Requested-With', 'XMLHttpRequest');
    fetch(url, {method: 'POST', headers: hdr ,body: form}).then(
        (response) => {
            if(response.ok) {
                response.json().then(resultat=>{
                    printNewProduct(resultat);
                    tabFournitureProduits = []; //reset tab
                    lenghtProducts.innerText = (parseInt(lenghtProducts.textContent,10) + 1)+"";
                    document.forms.produit.reset();
                }).catch((error)=>console.log(error))
            } else {
                alert('Mauvaise réponse du réseau !');
            }
        }).catch((error)=>{
        console.log(error);
    })
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