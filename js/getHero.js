function getHeroById(heroId) {
    //for some reason I can't reuse these :(
    const ajax = new XMLHttpRequest();
    let data = new FormData();
    data.append("hero_id", heroId);
    ajax.open("POST", "api/getHero_HTML.php", true);
    ajax.onreadystatechange = (t) => {
        console.log(t);
        if(ajax.readyState === 4) {
            document.getElementById("main-right").innerHTML = ajax.responseText;
        }
    };
    ajax.send(data);
}

function getHeroesForTeam(teamId) {
    //for some reason I can't reuse these :(
    const ajax = new XMLHttpRequest();
    ajax.open("GET", `api/heroes.php?team_id=${teamId}`, true);
    ajax.onreadystatechange = () => {
        if(ajax.readyState === 4) {
            let jsonData = JSON.parse(ajax.responseText);
            let output = "";
            for(let hero of jsonData) {
                output += `<div class="hero">
                                <div class="image">
                                    <img src='${hero.HERO_IMAGE}' />
                                </div>
                                <div class="description">
                                    <h3 class="nicefont">${hero.HERO_NAME}</h3>
                                    <p>${hero.HERO_DESCRIPTION}</p>
                                    <a class='btn' href="?team_id=${hero.TEAM_ID}&hero_id=${hero.HERO_ID}" onclick='getHeroById(${hero.HERO_ID});return false;'>Read more</a>
                                </div>
                                <div class='clearfix'></div>
                            </div>`;
            }
            document.getElementById("main-center").innerHTML = output;
        }
    };
    ajax.send(null);
}