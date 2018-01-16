const ajax = new XMLHttpRequest();
function getHeroById(heroId) {
    let data = new FormData();
    data.append("hero_id", heroId);
    ajax.open("POST", "/api/getHero_HTML.php", true);
    ajax.onreadystatechange = () => {
        if(ajax.readyState === 4) {
            document.getElementById("main-right").innerHTML = ajax.responseText;
        }
    };
    ajax.send(data);
}