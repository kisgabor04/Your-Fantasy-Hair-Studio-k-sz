//Telefonos menü megjelenítése:
const menu = document.querySelector(".phone");
const dropDown = document.querySelector(".lenyilo");
menu.addEventListener("click", menuX)

function menuX() {
    this.classList.toggle("change");

    if (dropDown.style.display === "flex") {
        dropDown.style.display = "none";
    }
    else {
        dropDown.style.display = "flex";
    }

}

//Felhasználó név megjelenítése, ha már bejelentkezett
fetch("./idopont2.php")
    .then(response => {
        if (!response.ok) {
            throw new Error("Hiba a kérésben!");
        }
        return response.json();

    })
    .then(datas => {
        
        //Ha nincs bejelentkezve, akkor átdobja a login.html oldalra

        if (datas["user"] != "Felhasználó nem található!") {
            //Kiírjuk a felhasználó nevét
            const bejelentkezesmenu = document.querySelector(".bejelentkezes");
            const bejelentkezett = document.querySelector(".bejelentkezett");
            const nev = document.querySelector(".nev");
            if (datas["user"] === "Felhasználó nem található!") {
                bejelentkezesmenu.classList.add("flex");
                bejelentkezett.classList.add("hidden");
            }
            else {
                bejelentkezesmenu.classList.add("hidden");
                bejelentkezett.classList.add("flex");
                nev.innerHTML = datas["user"];
                document.querySelector("#belep").classList.add("hidden");
                document.querySelector("#regisztral").classList.add("hidden");
            }

            



            if (datas["hairdresser"] === 1) {
                document.querySelector("#user").classList.add("hidden");
                document.querySelector("#hairdresser").classList.add("flex");
                document.querySelector("#leidopontjaim").classList.add("hidden");
                document.querySelector("#leidopontok").classList.add("flex");
            }
            else {
                document.querySelector("#user").classList.add("flex");
                document.querySelector("#hairdresser").classList.add("hidden");
                document.querySelector("#leidopontjaim").classList.add("flex");
                document.querySelector("#leidopontok").classList.add("hidden");
            }
        }
        else
        {
            document.querySelector("#user").classList.add("hidden");
            document.querySelector("#hairdresser").classList.add("hidden");
            document.querySelector("#leidopontok").classList.add("hidden");
            document.querySelector("#leidopontjaim").classList.add("hidden");
        }

    })


//Kijelentkezés: 
const kijelentkezes = document.querySelector(".kijelentkezes");

kijelentkezes.addEventListener("click", () => {
    const bejelentkezesmenu = document.querySelector(".bejelentkezes");
    const bejelentkezett = document.querySelector(".bejelentkezett");
    fetch("./logout.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Hiba a kérésben!");
            }
            return response.json();
        })
        .then(datas => {
            
            if (datas["logout"] === "Sikeres kijelentkezés!") {
                bejelentkezett.classList.add("hidden");
                bejelentkezett.classList.remove("flex");
                bejelentkezesmenu.classList.add("flex");
                document.querySelector("#belep").classList.add("flex");
                document.querySelector("#regisztral").classList.add("flex");
                document.querySelector("#leidopontjaim").classList.add("hidden");
                document.querySelector("#leidopontjaim").classList.remove("flex");
                document.querySelector("#leidopontok").classList.add("hidden");
                document.querySelector("#leidopontok").classList.remove("flex");
            }
        })
        .catch(error => console.log(error));
})



//Főoldal cikkek megjelenítése:

fetch("./cikkek.json")
    .then(response => {
        if (!response.ok) {
            throw new Error("Baj ban a fetch kérésben!");
        }
        return response.json();
    })
    .then(datas => {
        

        const content = document.querySelector(".content");
        for (let i = 0; i < datas.length; i++) {

            content.innerHTML += `
            <div class="card " style="z-index:-1;">
                <div class="row g-0">
                <div class="col-md-6" style="display:flex; justify-items:center; align-items:center;">
                <div class="kép"><img src="${datas[i].kep}" class="img-fluid rounded-start kép"></div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title" style="margin-left:5px">${datas[i].cim}</h5>
                    <p class="card-text" style="margin-left:5px">${datas[i].cikk}</p>
                    
                </div>
            </div>
            </div>
        </div>`;
        }

    })
    .catch(error => { console.log(error) })

