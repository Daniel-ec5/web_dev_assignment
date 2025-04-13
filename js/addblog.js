const clear=document.getElementById("clearpost");
clear.addEventListener("click",function(){
   document.getElementById("content").value="";
   document.getElementById("title").value="";
});
const post=document.getElementById("post");
post.addEventListener("click",function(event){
   const title=document.getElementById("title").value;
   const content=document.getElementById("content").value;
   if(title==""){
      event.preventDefault();
      alert("Title cannot be empty!");
      const titlebox=document.getElementById("title");
      titlebox.style.border="3px solid #ff0000";
      titlebox.focus();
   }
   //removes the red border when its refreshed and somethinghas been typed
   else{
      const titlebox=document.getElementById("title");
      titlebox.style.border="none";
   }
    if(content==""){
      event.preventDefault();
      alert("Content cannot be empty!");
      const contentbox=document.getElementById("content");
      contentbox.style.border="3px solid #ff0000";
      contentbox.focus();
   }
   else{
      const contentbox=document.getElementById("content");
      contentbox.style.border="none";
   }
});