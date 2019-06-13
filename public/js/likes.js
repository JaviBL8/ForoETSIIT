var clicks = 0;
    function onClick(idIncidencia) {
        clicks += 1;
        document.getElementById("btn" + idIncidencia).innerHTML = clicks;
    };