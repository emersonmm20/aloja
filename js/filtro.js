Array.from(document.getElementsByClassName("filter")).forEach(filter=>{
    filter.addEventListener("submit",(e)=>{
    e.preventDefault()

    const formData= new FormData(e.target)
    console.log(formData)

    var objet = new XMLHttpRequest()
    objet.open('POST','js/filtro.php',true)
    objet.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    objet.onreadystatechange=function (){
        console.log(objet.responseText)
    }
    objet.send(formData)


})
})



// document.getElementsByClassName("filter").addEventListener("submit",(e)=>{
//     e.preventDefault()
//     const formData=

// })