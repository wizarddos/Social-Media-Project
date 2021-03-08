function getPhotos(){
    console.clear();
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        if(xhr.status === 200){
            if(xhr.responseText === ""){
                return xhr.responseText;
            }else{
                let data = JSON.parse(xhr.responseText);
                console.log(data);
                return data;
            }
        }else{
            console.log("error");
        }
    }   
    xhr.open('GET', 'http://localhost/Social-Media-Project/scripts/php/getPhotos.php', true);
    xhr.send(null);

    //TODO: Naprawić Ajax
}


async function getThinks(){

}

async function showPhotos(){
    let data = getPhotos();
    if(data === ""){
        document.getElementById("Posts").innerHTML = "Brak Zdjęć<br/><a href = \"../addphoto.php\">Dodaj zdjęcie</a>";
    }else{
        let content;
        for(let i = 0; i < data.rows.length; i++){
            content += "<section class = \"photo\"><h2>data.rows[i].title</h2><img src = \"img/"+data.rows[i].Pname+"/ alt=\"PostPrzyjaciela\"/><div class = \"answers\"><i class = \"Icon-Heart\" ></i><i class = \"Icon-Happy\"></i><i class = \"Icon-Like\" id = \"like\"></i></div><p>data.rows[i].description</p></section>";
        }
        document.getElementById("Posts").innerHTML = content;
    }
    

}

