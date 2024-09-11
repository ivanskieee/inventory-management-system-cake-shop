var sideBarisOpen = true;

togbtn.addEventListener('click', (event) => {
    event.preventDefault();

    if (sideBarisOpen) {
        side.style.width = '10%';
        side.style.transition = '0.3s all';
        dcontentcont = '90%';
        logo.style.fontSize = '20px';
        UserImg.style.width = '60px';

        menuIcons = document.getElementsByClassName('menuT');
        for (var i = 0; i < menuIcons.length; i++) {
            menuIcons[i].style.display = 'none';
        }

        document.getElementsByClassName('mlist')[0].style.textAlign = 'center';
        sideBarisOpen = false;
    } else {
        side.style.width = '20%';
        dcontentcont = '80%';
        logo.style.fontSize = '40px';
        UserImg.style.width = '80px';

        menuIcons = document.getElementsByClassName('menuT');
        for (var i = 0; i < menuIcons.length; i++) {
            menuIcons[i].style.display = 'inline-block';
        }

        document.getElementsByClassName('mlist')[0].style.textAlign = 'left';
        sideBarisOpen = true;
    }
});

document.addEventListener('click', function(e){
     let clickedEl = e.target;

    if(clickedEl.classList.contains('showhidesm')){
        let subMenu = clickedEl.closest('li').querySelector('.subMenus');
        let mainMenuicon = clickedEl.closest('li').querySelector('.arup');

        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
        if(subMenu !== sub) sub.style.display = 'none';
        });

        
        showHideSubMenu(subMenu,mainMenuicon);
    
    }
});

function showHideSubMenu(subMenu,mainMenuicon){
    if(subMenu != null){
        if(subMenu.style.display === 'block'){
            subMenu.style.display = 'none';
            mainMenuicon.classList.remove('fa-angle-down');
            mainMenuicon.classList.add('fa-angle-left');
            
            
        } else {
            subMenu.style.display = 'block';
            mainMenuicon.classList.remove('fa-angle-left');
            mainMenuicon.classList.add('fa-angle-down');
        }
    }
}


let pathArray = window.location.pathname.split( '/' );
let curFile = pathArray[pathArray.length - 1];


let curNav = document.querySelector('a[href="./'+ curFile +'"]');
curNav.classList.add('sbm');


let mainNav = curNav.closest('li.LMM');
mainNav.style.background = 'rgb(89, 88, 87)';


let subMenu = curNav.closest('.subMenus');
let mainMenuicon = mainNav.querySelector('i.arup');


showHideSubMenu(subMenu,mainMenuicon);
