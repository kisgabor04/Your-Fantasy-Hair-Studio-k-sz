const message = document.querySelector(".message");
//Bejelentkezés
const bejelentkezés = () => {
    const username = document.querySelector(".username").value;
    const passwd1 = document.querySelector(".password").value;

    if (username === "") {
        window.alert("Felhasználónevet ki kell tölteni!");
        document.querySelector(".username").focus();
        return;
    }
    if (passwd1 === "") {
        window.alert("Jelszót ki kell tölteni!");
        document.querySelector(".password1").focus();
        return;
    }

    fetch("./login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ "username": username, "password": passwd1 })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Hiba történt a fetch-ben!");
            }
            return response.json();
        })
        .then(datas => {
            
            if (datas.errorCode === 0) {

                message.innerHTML = `<div class="alert alert-success" role="alert">${datas["errorMessage"]}</div>`;
                setTimeout(() => {
                    location.href = "main.html";
                }, 2000);



            } else {
                
                message.innerHTML = `<div class="alert alert-danger" role="alert">
                ${datas["errorMessage"]}</div>`;
                setTimeout(() => {
                    message.innerHTML = "";
                }, 2000)
            }
        })
        .catch(error => {
            console.error("Hiba történt:", error);
        });
};

const loginbutton = document.querySelector("#login");
loginbutton.addEventListener("click", bejelentkezés);



