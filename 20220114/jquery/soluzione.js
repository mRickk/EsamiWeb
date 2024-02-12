window.onload = function() {
    let matrix = Array(6);
    for(let i = 0; i < matrix.length; i++) {
        let row = Array(7);
        for(let j = 0; j < row.length; j++) {
            row[j] = Math.random() < 0.5 ? 1 : 2;
        }
        matrix[i] = row;
    }
    console.log(matrix);

    let table = document.querySelector("main > table");
    let defaultColor = table.style.backgroundColor;
    for(let i = 0; i < matrix.length; i++) {
        let tr = document.createElement("tr");
        for(let j = 0; j < matrix[i].length; j++) {
            let td = document.createElement("td");
            td.style.backgroundColor = matrix[i][j] == 1 ? "red" : "blue";
            td.addEventListener("click", function(e) {
                e.target.style.backgroundColor = defaultColor;
                matrix[i][j] = 0;
                console.log(matrix);
            });
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }

    let button = document.querySelector("button");
    button.addEventListener("click", function() {
        let table2 = document.querySelector("main > div > table");
        table2.innerHTML = "";
        let defaultColor = table2.style.backgroundColor;
        for(let i = 0; i < matrix.length; i++) {
            let tr = document.createElement("tr");
            for(let j = 0; j < matrix[i].length; j++) {
                let td = document.createElement("td");
                td.style.backgroundColor = matrix[i][j] == 1 ? "red" : matrix[i][j] == 0 ? defaultColor : "blue";
                tr.appendChild(td);
            }
            table2.appendChild(tr);
        }
    })
}