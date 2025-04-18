const posts=document.querySelectorAll(".postdel");
posts.forEach(function(post){
    post.addEventListener("click",function(e){
        if(confirm("Are you sure you want to delete post?")){
            return;
        }
        else{
            e.preventDefault();
            return false;
        }
    });
});
const comments=document.querySelectorAll(".commentdel");
comments.forEach(function(comment){
    comment.addEventListener("click",function(e){
        if(confirm("Are you sure you want to delete comment?")){
            return;
        }
        else{
            e.preventDefault();
            return false;
        }
    });
});