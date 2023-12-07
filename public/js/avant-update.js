
//const collection = document.getElementsByTagName("span");
const listproduct = document.getElementsByTagName("span");

for (i = 0 ; i < listproduct.length; i++) {
    listproduct[i].addEventListener("click", function () {
        // window.location.replace('http:127.0.0.1:8000/product/edit/'+i);
        //window.location.href = 'http:127.0.0.1:8000/product/edit/'+i;
        location.assign('http:127.0.0.1:8000/product/edit/'+i);
        //location.assign('http:127.0.0.1:8000/product/edit/'+n);
    });
}

