
//pop-up box
document.getElementById("contact-form").addEventListener("submit", function(event){
    event.preventDefault();

    document.getElementById("popup").style.display = "block";

    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("message").value = "";
});

document.querySelector(".popup-content .close").addEventListener("click", function(){
    document.getElementById("popup").style.display = "none";
});
