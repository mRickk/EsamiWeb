window.onload = function() {
    document.querySelector("button").addEventListener("click", function() {
        const xhttp = new XMLHttpRequest();
        let jsonResponse;
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                jsonResponse = JSON.parse(this.responseText);
                let main = document.querySelector("main");
                Array.from(jsonResponse.data).forEach(e => {
                    let div = document.createElement("div");
                    let ul = document.createElement("ul");
                    let liId = document.createElement("li");
                    liId.innerHTML = e.id;
                    ul.appendChild(liId);
                    let liName = document.createElement("li");
                    liId.innerHTML = e.name;
                    ul.appendChild(liName);
                    let liType = document.createElement("li");
                    liId.innerHTML = e.type;
                    ul.appendChild(liType);
                    div.appendChild(ul);
                    
                    main.appendChild(div);
                });
            }
        };
        xhttp.open("GET", "data.json");
        xhttp.send();
    });
};