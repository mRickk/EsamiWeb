const selectedColor = "#cacaca";
let selectedCell = null;

window.onload = function() {
    let main = document.querySelector("main");
    let numeri = document.createElement("table");
    const defaultColor = main.style.backgroundColor;
    numeri.id = "numeri";
    let tr = document.createElement("tr");
    let log = document.querySelector("p.log");
    for (let i = 1; i <= 9; i++) {
        let td = document.createElement("td");
        td.innerHTML = i;
        td.addEventListener("click", function() {
            if (selectedCell === null) {
                log.innerHTML = "Cella non selezionata";
            } else {
                selectedCell.innerHTML = i;
                selectedCell.style.backgroundColor = defaultColor;
                selectedCell = null;
                log.innerHTML = "Numero inserito correttamente";
            }
        });
        tr.appendChild(td); 
    }
    numeri.appendChild(tr);
    main.appendChild(numeri);
    let tabellone = document.querySelector("table.tabellone");
    let cells = tabellone.querySelectorAll("td");
    cells.forEach(c => {
        c.addEventListener("click", function() {
            if (selectedCell === null) {
                selectedCell = c;
                c.style.backgroundColor = selectedColor;
            } else if (selectedCell === c) {
                selectedCell = null;
                c.style.backgroundColor = defaultColor;
            } else {
                selectedCell.style.backgroundColor = defaultColor;
                selectedCell = c;
                c.style.backgroundColor = selectedColor;
            }
        });
    });

};