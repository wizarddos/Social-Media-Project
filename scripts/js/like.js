
const toogleLike = (x, id)=>{
     if(x.className == "icon-heart"){
          x.className = "icon-heart-empty";
          delLike(id);
          Gid = id;
     }else{
          x.className = "icon-heart";
          addLike(id);
     }
     

}


const addLike = (val) =>{
     $.ajax({
          method: "POST",
          url: "http://localhost/Social-Media-Project/scripts/php/like.php",
          data:'id='+val+'&add='+true,

          success:(status)=>{
               updateLikes(status, val);
          }
      });
 


 }


const delLike = (val)=>{
     $.ajax({
          method: "POST",
          url: "http://localhost/Social-Media-Project/scripts/php/like.php",
          data:'id='+val+'&add='+false,

          success:(status)=>{
               updateLikes(status, val);
          }
      });
 
}

const updateLikes = (status, id2) =>{
     document.getElementById(id2).innerHTML = status;
}