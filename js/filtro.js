//Filtro

// ---------------------------------------********************

//ESTRUCTURA BOTONES VALUES
//[TABLE, SQLTABLE, ELEMENTOS....]

// ---------------------------------------********************


const botones = Array.from(document.getElementsByClassName("btn-buscar"))

botones.forEach(btn=>{
    if(btn.getAttribute("value")){
        btn.addEventListener("click",()=>filtrar(btn.getAttribute("value").split(",")))
    }
})


const filtrar =(valores)=>{
    let tablaHTML=valores[0]
    let tablaSQL=valores[2]
    alert(valores)
    // let parametrosFiltro=

}



