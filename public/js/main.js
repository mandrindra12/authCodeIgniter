const b = document.querySelector("#loginButton");
const popup = document.querySelector("#popup");
const close = document.getElementsByClassName("p-close")[0];
const p_text = document.querySelector('.p-content-text');
b.addEventListener('click', (e) => {
    e.preventDefault();
    login();
});

const login = async() => {
    const prenom = document.querySelector("input[name='prenom']");
    const nom = document.querySelector("input[name='nom']").value;
    const password = document.querySelector("input[name='password']").value;
    if(username == '' || password == '') {
        p_text.innerText = 'Veuillez remplir tous les champs!';
        popup.style.display = 'block';
        return ;
    }
    fetch('/connexion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({nom, prenom, password})
    })
    .then(
        resp => resp.json()
    )
    .then(
        data => {
            console.log(data)
            if(data.status_code == 200) {
          // ito no ovaina rehefa tiana anao redirection makany am page d'accueil
                window.location.href = '/Accueil/index.php';
            } else if (data.status_code == 403){
                p_text.innerText = "L'utilisateur est deja connecte!";
                popup.style.display = 'block';
            } else {
                p_text.innerText = data.status;
                popup.style.display = 'block';    
            }   

        }
    )
    .catch(err => {
        console.error(err)
    });
}

close.onclick = () => {
    popup.style.display = 'none';
}
window.onclick = e => {
    if (e.target == popup) {
        popup.style.display = 'none';
    }
}
