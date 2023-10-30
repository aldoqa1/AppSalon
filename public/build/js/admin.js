const date = document.querySelector("#date");

date.addEventListener("input", function(e){
    window.location = `?date=${e.target.value}`;
});