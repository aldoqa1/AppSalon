const next = document.getElementById("next");
const previous = document.getElementById("previous");
const lis = document.querySelectorAll(".nav li");
const sections = document.querySelectorAll(".section");
let actualStep = 1;

const cita = {
    userId:'',
    dateNumber:'',
    name:'',
    date: '',
    time: '',
    services: []
}

document.addEventListener("DOMContentLoaded", function (){
    updateStateButtons();
    updateSections()
    gettingServices();
    //coloca le nombre el usuario en el arreglo
    gettingClientId();
    gettingClientName();
    //seleccion fecha, coloca la fecha en el objeto
    gettingDate();
    //seleccionar time
    gettingTime();
});

next.addEventListener("click", ()=>{
    if(actualStep<3){
        actualStep++;
    }
    showSummary();
    updateStateButtons();
    updateSections();
    addActiveCss(document.querySelector(`[data-position='${actualStep}']`));
})

previous.addEventListener("click", ()=>{
    if(actualStep>1){
        actualStep--;
    }
    updateStateButtons();
    updateSections();
    addActiveCss(document.querySelector(`[data-position='${actualStep}']`));
})


lis.forEach(li => {
    li.addEventListener("click", ()=>{
        actualStep = parseInt(li.dataset.position);
        //agregando el nav blanco y removiendo al anterior
        showSummary();
        addActiveCss(li);
        updateStateButtons();
        updateSections();
    })

});

function showSummary(){

    if(document.querySelector(".error")){
        document.querySelector(".error").remove();
    }



    if(Object.values(cita).includes("") || cita.services.length==0){
        showAlert("error", "You need to fill out all the data", "#summary", true);
        return;
    }

    summaryDiv = document.querySelector("#summary");

    summaryDiv.innerHTML = "";

    summaryName = document.createElement("div");
    summaryName.classList.add("summary");
    summaryName.innerHTML = `<span>Name:</span> ${cita.name}`;


    summaryDate = document.createElement("div");
    summaryDate.classList.add("summary");
    summaryDate.innerHTML = `<span>Date:</span> ${cita.date}`;


    summaryTime = document.createElement("div");
    summaryTime.classList.add("summary");
    summaryTime.innerHTML = `<span>Time:</span> ${cita.time} hours`;

    summaryServices = document.createElement("div");
    summaryServices.classList.add("summary-services");

    cita.services.forEach(service => {
        //console.log(service);
        const {id, price, name} = service;
        summaryService = document.createElement("div");
        summaryService.innerHTML = `<p>${name}</p><p>$ ${price}</p>`;
        summaryServices.append(summaryService);
    });

    divServices = document.createElement("div");
    divServices.classList.add("section");
    divServices.classList.add("displayblock");
    divServices.innerHTML = `<h2>YOUR SERVICES</h2>`;

    divButton = document.createElement("div");
    divButton.classList.add("button-position-end");
    divButton.innerHTML= "<button class='button-register' id='button-create'>CREATE</button>";

    divButton.querySelector("button").addEventListener("click", bookingAppointment);

    summaryDiv.append(summaryName);
    summaryDiv.append(summaryDate);
    summaryDiv.append(summaryTime);
    summaryDiv.append(divServices);
    summaryDiv.append(summaryServices);
    summaryDiv.append(divButton);
}

async function gettingServices(){

    url = "/API/services";
    consulta = await fetch(url);
    jsons = await consulta.json();
    jsons.forEach(json => {
        const {id, name, price} = json;
        div = document.createElement('div');
        div.setAttribute("data-div",`${id}`);
        content = `<p class='list-service'>${name}</p><p class='list-price'>$ ${price}</p>`;
        div.innerHTML = content;
        service = document.querySelector("#services");
        service.append(div);

        div.addEventListener("click", function() {

            //agregar css activo al servicio elejido
            divChoosen = document.querySelector(`[data-div='${id}']`);

            divChoosen.classList.toggle("service-active");

            //agrega o quita ids de servicios del arreglo de serivcios del usuario
            let {services} = cita;

            if(services.includes(json)){
                cita.services = cita.services.filter(element => element.id != json.id);

            }else{
                cita.services = [...services , json];
            }

            //c(cita)
        })
    });

}

function gettingClientName(){
    cita.name = document.querySelector("#name").value;
}

function gettingClientId(){
    cita.userId = document.querySelector("#id").value;
}

function updateSections(){
    sections.forEach(section =>{
        section.classList.remove("displayblock");
        if(section.id==`step-${actualStep}`){
            section.classList.add("displayblock");
        }
    })
}

function addActiveCss($element){
    document.querySelector(".navTab-active").classList.remove("navTab-active");
    $element.classList.add("navTab-active");
}

function updateStateButtons(){

    if(actualStep==1){
        previous.classList.add("visibilityOff");
        next.classList.remove("visibilityOff");
    }else if(actualStep==2){
        previous.classList.remove("visibilityOff");
        next.classList.remove("visibilityOff");
    }else{
        previous.classList.remove("visibilityOff");
        next.classList.add("visibilityOff");
    }

}

function gettingDate(){
    inputDate = document.querySelector("#date");
    inputDate.addEventListener("input", ()=>{


        dateInput = dateToNumber(inputDate.value);
        date1day = dateToNumber( );

        if(!inputDate.value){
            showAlert("error", "Date empty", ".formAuth");

        }else{

            const dia = new Date(inputDate.value).getUTCDay();

            if([6,0].includes(dia)){

                showAlert("error", "We dont work on weekends", ".formAuth");
                inputDate.value = "";

            }else{

                //elimina el ultimo error temporal si la fecha esta bien
                if(document.querySelector(".error")){
                    document.querySelector(".error").remove();
                }
                if(dateInput<date1day){
                    showAlert("error", "This day is not valid", ".formAuth");
                    inputDate.value = "";
                }else{

                    const dateObj = new Date(inputDate.value);
                    const month = dateObj.getMonth();
                    const day = dateObj.getDate()+2;
                    const year = dateObj.getFullYear();

                    const dateUTC = new Date(Date.UTC(year, month, day));
                    const options = {weekday: "long", year: "numeric", month: "long", day: "numeric"}
                    const formatedDate = dateUTC.toLocaleString("en-US", options);

                    cita.date = formatedDate;
                    cita.dateNumber = inputDate.value;
                    //elimina el ultimo error temporal si la fecha esta bien
                    if(document.querySelector(".error")){
                        document.querySelector(".error").remove();
                    }
                }
            }
        }

    })
}

function dateToNumber(date="") {

    if(date!=""){
        array = date.split("-");
        let year = parseInt(array[0]);
        let month = parseInt(array[1]);
        let day = parseInt(array[2]);


        number = day + (month*30) + 365*year;
        return number;
    }


    let c = new Date();
    let day = c.getDate()+1;
    let year = c.getFullYear();
    let month = parseInt(c.toLocaleString('es-NI', { month: '2-digit'}));
    number = day + (month*30) + 365*year;

    return number;



}

function gettingTime(){
    inputTime = document.querySelector("#time");

    inputTime.addEventListener("input", ()=>{

        timeLimit = inputTime.value.split(":")[0];

        if(timeLimit>20 || timeLimit<7){
            inputTime.value = "";
            showAlert("error", "Time not allowed", ".formAuth");
        }else{
            if(document.querySelector(".error")){
                document.querySelector(".error").remove();
            }

            cita.time = inputTime.value;
        }

    })
}

function showAlert(type, message, element, duration=false){

    if(document.querySelector(".error")){
        document.querySelector(".error").remove();
    }

    div = document.createElement("div");
    div.classList.add(type);
    div.innerText = message;
    element = document.querySelector(element);
    element.append(div);

    if(!duration){
        setTimeout(()=>{div.remove();} , 4000)
    }


}

async function bookingAppointment(){

    services = cita.services.map(function(service){return service.id});
    data =  new FormData();
    data.append("userId",cita.userId);
    data.append("name",cita.name);
    data.append("time",cita.time);
    data.append("date",cita.dateNumber);
    data.append("services", services);

    //console.log([...data])

    try {
        url = "/API/appointmentsRegister";
        consult = await fetch(url, {
        method : "POST",
        body : data
        })

        result = await consult.json();

        if(result){

            Swal.fire({
                icon: 'success',
                title: 'Appointment created',
                text: 'Your appointment has been created!'
            }).then(()=>window.location.reload());

        }

    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Appointment error',
            text: 'Your appointment couldnt have been created!',
            button: "OK"
        }).then(()=>window.location.reload());
    }

c(cita);
}

function c($var){
    console.log($var);
}