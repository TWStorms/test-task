document.addEventListener("DOMContentLoaded", () =>{
    const nav = document.querySelector(".Wrapper");
    const toggleButton = document.querySelector("#icon")

    toggleButton.addEventListener("click", () =>{
        nav.classList.add("open");
    });

    document.querySelector(".overlay").addEventListener("click", () =>{
        nav.classList.remove("open")
    })

// if(nav.classList==="open "){
//     toggleButton.addEventListener("click" ,() =>{
//         nav.classList.remove("open")
//     });
// }else{
//     toggleButton.addEventListener("click",()=>{
//         nav.classList.add("open")
//     });
// }
});
