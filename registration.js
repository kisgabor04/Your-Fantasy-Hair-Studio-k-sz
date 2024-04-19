const registrationbutton = document.querySelector("#registration");
const message = document.querySelector("#message");

function registration()
{
    const username = document.querySelector("#username").value;
    const passwd1 = document.querySelector("#password1").value;
    const passwd2 = document.querySelector("#password2").value;
    const fullname = document.querySelector("#fullname").value;

    //Mezők kitöltéstésének vizsgálata
    if(username === "")
    {
        alert("Felhasználónév megadása kötelező!");
        username.focus();
        return;
    }
    if(passwd1 === "")
    {
        alert("Jelszó megadása kötelező!");
        passwd1.focus();
        return;
    }
    if(passwd2 === "")
    {
        alert("Jelszó megadása kötelező!");
        passwd2.focus();
        return;
    }
    if(fullname === "")
    {
        alert("Teljes név megadása kötelező!");
        fullname.focus();
        return;
    }

    if(passwd1 !=passwd2)
    {
        alert("Nem egyeznek meg a megadott jelszavak!");
        passwd1.focus();
        return;
    }

    fetch("./regist.php",
    {
        method: "POST",
        headers: {"Content-Type":"Application/json"},
        body: JSON.stringify({"username":username, "password":passwd1, "fullname":fullname})
    })
    .then(response=>
    {
        if(!response.ok)
        {
            throw new Error("Hiba a kérésben!");
            
        }
        return response.json();
    })
    .then(datas =>{
        
        if (datas.errorCode === 0)
        {
            
            
                message.innerHTML = `<div class="alert alert-success" role="alert">${datas["errorMessage"]}</div>`;
                setTimeout(()=>{
                    location.href ="./login.html";
                },2000)
            
        }else
        {
            if(datas.errorMessage === "Ez a felhasználónév már foglalt!")
            {
                message.innerHTML = `<div class="alert alert-danger" role="alert">
                ${datas["errorMessage"]} Jelentkezzen be <a href="login.html">itt</a> vagy válasszon másik felhasználónevet! </div>`;
                
                
            }else
            {
                message.innerHTML = `<div class="alert alert-danger" role="alert">
                ${datas["errorMessage"]}</div>`;
            }
        }
    })

}
registrationbutton.addEventListener("click",registration);