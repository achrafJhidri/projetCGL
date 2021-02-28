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
const tabFournitureProduits = [];
ajouterUneQuantite.addEventListener('click', (event)=>{
    let obj = {
        id_fourniture:fournitureSelect.value,
        quantite:quantiteInput.value
    }
    const index =  tabFournitureProduits.find(element => {
        element.id_fourniture === obj.id_fourniture
    })
    if(index === )
    tabFournitureProduits.push(obj);
   console.log(obj);

})

const onlyUnique = (value, index, self) =>{ 
    return self.indexOf(value.id_fourniture) === ;
}

