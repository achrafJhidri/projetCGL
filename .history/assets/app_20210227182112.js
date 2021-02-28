/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

const fournitureSelect = document.querySelector("#produit_produitFournitures");
const ajouterUneQuantite = document.querySelector("#add-quantite");
const quantiteInput = document.querySelector("input[type=number");
const btnEnregistrer = document.getElementById("#produit_Enregister");

let tabFournitureProduits = [];
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
        console.log(index);
        if(index === -1)
        {
            tabFournitureProduits.push(obj);
        }
        else
        {
            const conf = confirm("Souhaitez-vous écraser l'ancienne quantité?");
            if(conf)
            {
                tabFournitureProduits[index] = obj;
            }
        }
        console.log(tabFournitureProduits);
    }
})

btnEnregistrer.addEventListener('click', (event)=>{
    event.preventDefault();
    console.log();
})

