window.onload = function() {
    document.querySelector("button").addEventListener("click", function() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const jsonResponse = JSON.parse(this.responseText);
                const main = document.querySelector("main");
                Array.from(jsonResponse.data).forEach(e => {
                    const div = document.createElement("div");
                    div.innerHTML = 
                    `
                    <ul>
                        <li>${e.id}</li>
                        <li>${e.name}</li>
                        <li>${e.type}</li>
                    </ul>
                    `
                    const upButton = document.createElement("button");
                    upButton.textContent = "sopra";
                    upButton.addEventListener("click", function() {
                        const parent = this.parentNode;
                        const sibling = parent.previousSibling;
                        if (sibling !== null) {
                            main.insertBefore(parent, sibling);
                        }
                    });
                    div.appendChild(upButton);
                    const downButton = document.createElement("button");
                    downButton.textContent = "sotto";
                    downButton.addEventListener("click", function() {
                        const parent = this.parentNode;
                        const sibling = parent.nextSibling;
                        if (sibling !== null) {
                            main.insertBefore(parent, sibling);
                        }
                    });
                    div.appendChild(downButton);
                    main.appendChild(div);
                });
            }
        };
        xhttp.open("GET", "data.json");
        xhttp.send();
    });
};