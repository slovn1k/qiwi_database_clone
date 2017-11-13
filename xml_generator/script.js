window.onload = function(){
  limit_acces();
}
function limit_acces(){
  
document.querySelector('.cont_bgc_modal').style.display = "block"; 
 document.querySelector('.cont_modal').style.display = "block"; 
  setTimeout( function(){
 document.querySelector('.cont_bgc_modal').className = "cont_bgc_modal  cont_bgc_modal_activo";  
 document.querySelector('.cont_modal').className = "cont_modal cont_modal_activo";
   
 },100);
  

}
