const form=document.getElementById("form");
//this is the login form validation script
form.addEventListener("submit",function(event){
    const email=document.getElementById("email").value;
    const password=document.getElementById("password").value;
    if(email==""){
        event.preventDefault();
        alert("Email cannot be empty");
        emailbox=document.getElementById("email");
        emailbox.style.border="2px solid red";
        emailbox.focus();
    }
    else{
        emailbox.style.border="none";
    }
    if(password==""){
        event.preventDefault();
        alert("Password cannot be empty");
        const passwordbox=document.getElementById("password");
        passwordbox.style.border="2px solid red";
        passwordbox.focus();
    }
    else{
        passwordbox.style.border="none";
    }
   
    
    
    //else it does nothing and allows submit to the php script
});
