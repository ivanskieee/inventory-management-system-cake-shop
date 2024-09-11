let menu = document.querySelector('#mtbn');
let navbar = document.querySelector('.head .nvb');

menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};
window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
};

var swiper = new Swiper(".hs", {
    loop:true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

let lmbtn = document.querySelector('.products .load-more .btn');
let curItem = 3;

lmbtn.onclick = () => {
    let boxes = [...document.querySelectorAll('.products .box-cont .box')];
    for(var i =curItem; i < curItem + 3; i++){
        boxes[i].style.display = 'inline-block';
    };
    curItem += 3;
    if(curItem >= boxes.length){
        lmbtn.style.display = 'none';
    }
}